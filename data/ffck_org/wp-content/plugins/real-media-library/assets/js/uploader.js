"use strict";

/*global mOxie RMLisDefined wp*/

// @link http://stackoverflow.com/questions/10420352/converting-file-size-in-bytes-to-human-readable
function rmlHumanFileSize(bytes, si) {
    var thresh = si ? 1000 : 1024;
    if(Math.abs(bytes) < thresh) {
        return bytes + ' B';
    }
    var units = si
        ? ['kB','MB','GB','TB','PB','EB','ZB','YB']
        : ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];
    var u = -1;
    do {
        bytes /= thresh;
        ++u;
    } while(Math.abs(bytes) >= thresh && u < units.length - 1);
    return bytes.toFixed(1)+' '+units[u];
}

/**
 * Create a uploading file row with preview image
 */
function rmlPrepareUpload(file) {
    var $ = jQuery;
    // Get the actual folder slug
    var active = $(".rml-root-list").find(".active"),
        opts = {
            slug: null,
            id: null,
            deny: ''
        };
    
    // Get translation texts for warnings
    var uploadingTexts = {
        denyCollection: $(".rml-container").attr("data-lang-uploading-collection"),
        denyGallery: $(".rml-container").attr("data-lang-uploading-gallery")
    };
    
    // Get active folder
    if (active.size() > 0) {
        opts.slug = active.attr("data-slug");
        opts.id = parseInt(active.attr("data-id"));

        // Check folder type and automatically redirect it to root folder.
        if (active.attr("data-type") == "1") {
            opts.slug = "/";
            opts.id = -1;
            opts.deny = '<div class="warnings">\
                <span class="deny-collection">' + uploadingTexts.denyCollection + '</span>\
            </div>';
        }else if (active.attr("data-type") == "2") {
            // May only contain image files
            var allowedExts = [ 'jpg', 'jpeg', 'jpe', 'gif', 'png' ],
                ext = file.name.substr(file.name.lastIndexOf('.') + 1).toLowerCase();
            if ($.inArray(ext, allowedExts) <= -1) {
                opts.slug = "/";
                opts.id = -1;
                opts.deny = '<div class="warnings">\
                    <span class="deny-gallery">' + uploadingTexts.denyGallery + '</span>\
                </div>';
            }
        }
    }else{
        opts.slug = "/";
        
        // Get the id
        var select = $("#media-attachment-folder-filters");
        if (select.size() > 0 && select.val() != "all") {
            opts.id = parseInt(select.val());
        }else{
            opts.id = -1;
        }
    }
    
    // Create row item
    var item = $( '<div class="rml-uploading-item rml-uploading-' + file.attachment.cid + '"\
                data-slug="' + opts.slug + '" \
                data-id="' + opts.id + '"\
                id="rml-uploading-' + file.id + '">\
            <div class="left"></div>\
            <div class="right">\
                <div class="filename">' + file.name + '</div>\
                <div class="folder">\
                    <i class="fa fa-folder-o"></i> ' + opts.slug + '<br />\
                    ' + rmlHumanFileSize(file.size) + ' - <span class="read_percent">0%</span>\
                </div>\
                <div class="bar">\
                    <div class="percent"></div>\
                </div>\
                ' + opts.deny + '\
            </div>\
            <div class="fix"></div>\
        </div>' ).appendTo( '.rml-uploading' );
    
    $(".rml-uploading").show();
	var image = $( new Image() ).appendTo( item.find(".left") );
	
	if ($(".rml-hide-upload-preview-1").size() == 0) {
    	var preloader = new mOxie.Image();
    	preloader.onload = function() {
    	    preloader.downsize( 48, 48 );
    	    image.prop( "src", preloader.getAsDataURL() );
    	}
    	preloader.load( file.getSource() );
	}
}

/**
 * Handles a progress for a uploading item
 */
function rmlUploadProgress(up, file) {
    var $ = jQuery;
    var item = $('#rml-uploading-' + file.id),
        percent =  file.percent + "%";
    if (item.size() > 0) {
        item.find(".percent").css("width", percent);
        item.find(".read_percent").html(percent);
    }
}

/**
 * Success handler for uploaded files. Move the file to
 * the specific folder.
 */
function rmlUploadSuccess(fileObj) {
    var $ = jQuery;
    var item = $('.rml-uploading-' + fileObj.cid);
    if (item.size() > 0) {
        var data = {
            'action': 'bulk_move',
            'ids' : [fileObj.id],
            'to' : parseInt(item.attr("data-id"))
        };
        
        item.find(".percent").addClass("finish");
        
        jQuery.ajax({
            url: window.rml_ajax_url,
            data: data,
            method: 'POST',
            invokeData: item
        }).done(function(response) {
            var invoke = this.invokeData;
            invoke.fadeOut(1500, function() {
                $(this).remove();
            });
            
            // Refresh if neccessery
            setTimeout(function() {
                try {
                    if (RMLisDefined(wp.media.frame.content)) {
                        wp.media.frame.content.get().collection.props.set({ignore: (+ new Date())});
                    }
                }catch (e) {
                    console.log(e);
                }
            }, 1000);
        });
    }
}