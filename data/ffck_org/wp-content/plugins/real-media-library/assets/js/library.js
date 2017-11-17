"use strict";

/* global RMLisDefined */

/**
 * Refresh the page. Detect if it is in
 * grid mode and refresh via AJAX. Otherwise, refresh
 * full page.
 */
function rmlRefreshIt() {
    var $ = jQuery;
    
    if ($("body").hasClass("upload-php-mode-grid")) {
        try {
            if (RMLisDefined(wp.media.frame.content)) {
                wp.media.frame.content.get().collection.props.set({ignore: (+ new Date())});
            }else{
                window.location.reload();
            }
        }catch (e) {
            console.log(e);
            window.location.reload();
        }
    }else{
        window.location.reload();
    }
}

/**
* Makes attachments in grid mode draggable with helper.
*/
function rmlDraggable() {
    var $ = jQuery;
    $("ul.attachments > li, .wp-list-table.media tbody tr").draggable({
        revert: 'invalid',
        appendTo: 'body',
        cursorAt: { top: 10, left: 10 },
        helper: function() {
            var items = 0;
            if ($("body").hasClass("upload-php-mode-list")) {
                // Count list
                items = $('input[name="media[]"]:checked').size();
            }else{
                // Count grid
                if ($(".media-frame").hasClass("mode-select")) {
                    $("ul.attachments > li.selected").each(function() {
                        items++;
                    });
                }
            }
            if (items == 0) {
                items++;
            }
            return $('<div class="attachment-move"><i class="fa fa-files-o"></i> ' + items + '</div>');
        }
    });
}

/**
* Toggle the edit mode (sort mode).
* 
* @param mode boolean
*/
function rmlToggleEditMode(mode) {
    var $ = jQuery;
    if (mode) {
        window.rmlOldHTML = $(".rml-container .rml-root-list").html();
        $(".rml-container > .wrap").addClass("edit-mode").removeClass("ready-mode");
        $("#wpbody-content").stop().fadeTo(200, 0.3);
        $(".rml-container .list a").each(function() {
            $(this).attr("data-href", $(this).attr("href"));
            $(this).attr("href", "");
        });
        // Handler for sortable directories
        $('.rml-container .rml-root-list > ul').nestedSortable({
            handle: 'a[data-href]',
            items: 'li',
            listType: 'ul',
            doNotClear: true
        });
    }else{
        $(".rml-container > .wrap").addClass("ready-mode").removeClass("edit-mode");
        $("#wpbody-content").stop().fadeTo(200, 1);
        $(".rml-container .list a").each(function() {
            $(this).attr("href", $(this).attr("data-href"));
            $(this).attr("data-href", "");
        });
    }
    
    rmlSticky();
}
/**
* Adds a create form.
* 
* @param type String folder|collection|gallery
*/
function rmlPrepareAddForm(type) {
    var $ = jQuery;
    var active = $(".rml-container .rml-root-list").find("a.active"), parentID;
    if (active.size() == 0) {
        parentID = -1;
        active = $(".rml-container .rml-root-list > ul");
    }else{
        parentID = active.attr("data-id");
        active = active.next(); // take ul list
        active.parents("li").addClass("rml-open");
    }
    
    // Detect icon variable
    var icon = 'fa fa-folder-open-o';
    if (type == 1) {
        icon = 'mwf-collection';
    }else if (type == 2) {
        icon = 'mwf-gallery';
    }
    
    var li = $('<li>\
                  <form data-type="' + type + '" data-create-rml="' + parentID + '">\
                    <a>\
                      <i class="' + icon + '"></i> \
                      <input type="text" />\
                      <button class="button-primary"><i class="fa fa-circle-o-notch fa-spin" style="display:none;"></i> OK</button>\
                    </a>\
                  </form>\
                </li>').appendTo(active);
    li.find("input").focus();
}
/**
* Updates the current type of folder. Can be
* folder, collection or gallery.
*/
function rmlUpdateActiveType() {
    var $ = jQuery;
    var active = $(".rml-container .rml-root-list").find("a.active"),
        type = active.attr("data-type"), options = [
            { id: '#rml-add-new-folder', active: true },
            { id: '#rml-add-new-collection', active: true },
            { id: '#rml-add-new-gallery', active: false }
        ];
        
    if (RMLisDefined(type)) {
        if (type == "1") {
            options[0].active = false;
            options[2].active = true;
        }else if (type == "2") {
            options[0].active = false;
            options[1].active = false;
            options[2].active = false;
        }
    }
    
    for (var i = 0; i < options.length; i++) {
        if (options[i].active) {
            $(options[i].id).show();
        }else{
            $(options[i].id).hide();
        }
    }
}
function rmlSticky() {
    if (jQuery(window).width() < 667) {
        return;
    }
    
    var $ = jQuery, c = $(".rml-container:not(.dummy)");
    
    if (c.data("sticky_kit")) {
        c.trigger("sticky_kit:detach");
        //$(document.body).trigger("sticky_kit:recalc");
        //return;
    }
    
    c.data("sticky_kit", false);
    c.stick_in_parent({
        offset_top: 32
    });
}
function rmlUpdateTreeCollapse() {
    var $ = jQuery;
    var expander, treeClass, treeStatus;
    $(".list.rml-root-list li .rml-expander").remove();
    $(".list.rml-root-list li").each(function() {
        if ($(this).children("ul").children("li").size() > 0) {
            treeStatus = rmlGetTreeStatus(parseInt($(this).children("a").attr("data-id")));
            if (treeStatus) {
                treeClass = 'rml-open';
            }else{
                treeClass = '';
            }
            $(this).addClass(treeClass);
            expander = $("<div class=\"rml-expander " + treeClass + "\"><i class=\"fa fa-minus-square-o\"></i><i class=\"fa fa-plus-square-o\"></i></div>").appendTo($(this));
        }
    });
}
function rmlToggleTreeStatus(id) {
    var value = window.localStorage.getItem('rml-' + window.rml_blog_id + '-expand-' + id);
    if (RMLisDefined(value)) {
        value = !(value == "true");
    }else{
        value = false;
    }

    window.localStorage.setItem('rml-' + window.rml_blog_id + '-expand-' + id, value);
}
function rmlGetTreeStatus(id) {
    var $ = jQuery;
    var value = window.localStorage.getItem('rml-' + window.rml_blog_id + '-expand-' + id);
    if (RMLisDefined(value)) {
        return value == "true";
    }else{
        return true;
    }
    return true;
}

/*global wp,jQuery */
/**
 * Create filter for the media grid.
 * 
 * @link https://gist.github.com/bitfade/4476771
 */
jQuery(document).ready(function($) {
	if (!window.wp || !window.wp.media || !window.folderAttachmentsArray) {
		return;
	}
	
	var media = window.wp.media;
	var names = window.folderAttachmentsArray.names;
	var slugs = window.folderAttachmentsArray.slugs;
	
	var folderFilter = media.view.AttachmentFilters.extend({
	    id:        'media-attachment-folder-filters',
	    
		createFilters: function() {
			var filters = {};
			
			// default "all" filter, shows all tags
			filters.all = {
				text:  "All",
				props: {
					rml_folder: ""
				},
				priority: 10
			};
			
			// create a filter for each tag
			var i;
			for (i = 0;i<names.length;i++) {
				filters[slugs[i]] = {
					// tag name
					text:  names[i],
					props: {
						rml_folder: slugs[i]
					},
					priority: 20+i
				};

			}
			
			this.filters = filters;
		}
	});
	
	// backup the method
	var orig = wp.media.view.AttachmentsBrowser;
	
	wp.media.view.AttachmentsBrowser = wp.media.view.AttachmentsBrowser.extend({
		createToolbar: function() {
			// call the original method
			orig.prototype.createToolbar.apply(this,arguments);
			
			media.model.Query.defaultArgs.filterSource = 'filter-media-taxonomies';
			
			// add our custom filter
			this.toolbar.set('rml_folder', new folderFilter({
				controller: this.controller,
				model:      this.collection.props,
				priority:   -75
			}).render() );
		}
	});
	
});