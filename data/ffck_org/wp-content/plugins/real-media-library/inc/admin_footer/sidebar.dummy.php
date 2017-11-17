<?php
/**
 * This file creates a dummy for the sidebar
 * shown in the media library. Javascript handles
 * it, to append it to the components.
 * 
 * @author MatthiasWeb
 * @package real-media-library
 * @since 1.0
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$folders = RML_Structure::getInstance();
$folderActive = isset($_REQUEST['rml_folder']) ? $_REQUEST['rml_folder'] : "";
$folderTree = $folders->getView()->treeHTML($folderActive);
?>

<div class="rml-container rml-dummy"
    data-lang-uploading-collection="<?php _e('A collection can not contain files. Upload moved to root...', RML_TD); ?>" 
    data-lang-uploading-gallery="<?php _e('A gallery can contain only images. Upload moved to root...', RML_TD); ?>" 
    data-lang-delete-failed="<?php _e('In this folder are sub directories, please delete them first!', RML_TD); ?>"
    data-lang-delete-root="<?php _e('Do not delete root. :(', RML_TD); ?>"
    data-lang-delete-confirm="<?php _e('Would you like to delete this folder? Note: All files in this folder will be deleted.', RML_TD); ?>"
    data-lang-rename-root="<?php _e('Do not rename root. :(', RML_TD); ?>"
    data-lang-rename-prompt="<?php _e('Say me the new name: ', RML_TD); ?>">
    <div class="wrap ready-mode rml-hide-upload-preview-<?php echo get_option('rml_hide_upload_preview', 0); ?>">
        <h1>
            <?php _e('Folders', RML_TD); ?> 
            <a class="page-title-action" data-type="0" data-helper="create-folder" id="rml-add-new-folder"><i class="fa fa-folder-open-o"></i>&nbsp;<i class="fa fa-plus"></i></a>
            <a class="page-title-action" data-type="1" data-helper="create-collection" id="rml-add-new-collection"><i class="mwf-collection"></i>&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
            <a class="page-title-action" data-type="2" data-helper="create-gallery" id="rml-add-new-gallery"><i class="mwf-gallery"></i>&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
        </h1>
        <div class="wp-filter">
            <div class="rml-info">
                <span><?php echo RML_Structure::getInstance()->getCntAttachments(); ?></span> <?php _e('Files', RML_TD); ?><br />
                <span><?php echo count(RML_Structure::getInstance()->getParsed()); ?></span> <?php _e('Folders', RML_TD); ?>
            </div>
        	<div class="filter-items">
        		<div class="view-switch">
                    <a data-helper="refresh" href="javascript:rmlRefreshIt();" class="view-switch-refresh"><i class="fa fa-refresh"></i></a>
                    <a data-helper="rename" href="#" class="view-switch-rename" id="rml-folder-rename"><i class="fa fa-pencil"></i></a>
                    <a data-helper="delete" href="#" class="view-switch-delete" id="rml-folder-delete"><i class="fa fa-trash-o"></i></a>
                    <a data-helper="edit" href="#" class="view-switch-sort"><i class="fa fa-sort"></i></a>
        		</div>
        	</div>
        	<div class="clear"></div>
        </div>
        
        
        <div class="page-title-action-helper" data-helper="create-folder">
            <div><?php _e('Click this to create <strong>a new folder</strong>', RML_TD); ?></div>
            <p><?php _e('A folder can contain every type of file or a collection, but no gallery.', RML_TD); ?></p>
        </div>
        <div class="page-title-action-helper" data-helper="create-collection">
            <div><?php _e('Click this to create <strong>a new collection</strong>', RML_TD); ?></div>
            <p><?php _e('A collection can contain no files. But you can create there other collections and <strong>galleries</strong>.', RML_TD); ?></p>
        </div>
        <div class="page-title-action-helper" data-helper="create-gallery">
            <div><?php _e('Click this to create <strong>a new gallery</strong>', RML_TD); ?></div>
            <p><?php _e('A gallery can contain only images. If you want to display a gallery go to a post and have a look at the visual editor buttons.', RML_TD); ?></p>
        </div>
        <div class="page-title-action-helper bar" data-helper="refresh">
            <div><?php _e('Refresh the current view.', RML_TD); ?></div>
        </div>
        <div class="page-title-action-helper bar" data-helper="delete">
            <div><?php _e('Delete selected folder.', RML_TD); ?></div>
        </div>
        <div class="page-title-action-helper bar" data-helper="rename">
            <div><?php _e('Rename selected folder.', RML_TD); ?></div>
        </div>
        <div class="page-title-action-helper bar" data-helper="edit">
            <div><?php _e('Change the hierarchical order.', RML_TD); ?></div>
        </div>
        
        <div class="clear"></div>
        <div class="sort-notice"><?php _e('Change the hierarchical order.'); ?></div>
        <button style="display:none;" class="abort-sort button-secondary"><?php _e('Cancel'); ?></button>
        <button style="display:none;" class="save-sort button-primary"><?php _e('Save'); ?></button>
        <div class="clear" style="margin-top:5px;"></div>
        
        <div class="rml-uploading" style="display:none;">
            
            <!-- 
            <div class="rml-uploading-item">
                <div class="left"><img src="http://plugin-matzeeeeeable.c9.io/wp-media/6680//2015/12/fXOAC5G6UwJcmZ23kH1N498jN_9voDjYZiDkmfLj_TE-1024x683.jpg" /></div>
                <div class="right">
                    <div class="filename">MyCar.jpg</div>
                    <div class="folder">
                        <i class="fa fa-folder-o"></i> /MyFolder/Behance<br />
                        322 KB - <span class="read_percent">80%</span>
                    </div>
                    <div class="bar">
                        <div class="percent" style="width:80%;"></div>
                    </div>
                </div>
                <div class="fix"></div>
            </div>
            
            <div class="rml-uploading-item">
                <div class="left"><img src="http://plugin-matzeeeeeable.c9.io/wp-media/6656/2015/12/rs6_innen-middle.jpg" /></div>
                <div class="right">
                    <div class="filename">SecondImage.jpg</div>
                    <div class="folder">
                        <i class="fa fa-folder-o"></i> /MyFolder/Behance<br />
                        322 KB - <span class="read_percent">22%</span>
                    </div>
                    <div class="bar">
                        <div class="percent" style="width:22%;"></div>
                    </div>
                </div>
                <div class="fix"></div>
            </div>
            !-->
            
            
        </div>
        
        <div class="list">
            <a id="rml-list-li-all-files" href="<?php echo RML_Structure::getInstance()->getView()->treeHref("", ""); ?>"
                <?php echo RML_Structure::getInstance()->getView()->treeActive($folderActive, ""); ?>
                data-id="">
                    <i class="fa fa-files-o"></i> <?php _e('All Files', RML_TD); ?>
                    <span><?php echo RML_Structure::getInstance()->getCntAttachments(); ?></span>
            </a>
            
            <hr />
            
            <div class="list rml-root-list">
                <?php echo $folderTree; ?>
            </div>
        </div>
        
        <div id="rml-info-links">
            <a href="#" id="rml-info-link-info">
                <span class="active-show"><i class="fa fa-close"></i> <?php _e('Hide this info', RML_TD); ?></span>
                <span class="active-hide"><i class="fa fa-info"></i> <?php _e('Help', RML_TD); ?></span>
            </a>
             &bull; 
            <a href="http://codecanyon.net/item/wp-real-media-library-organize-your-uploads/13155134" target="_blank">RML Version <?php echo RML_VERSION; ?></a>
        </div>
        <div id="rml-info">
            <div class="rml-info-image rii1"></div>
            <div class="arrow-down"><i class="fa fa-arrow-down"></i></div>
            <h3><?php _e('What a chaos in your media library?', RML_TD) ?></h3>
            <div class="arrow-down"><i class="fa fa-arrow-down"></i></div>
            
            <div class="rml-intro-view">
                <span class="rml-intro-view-button">
                    <i class="fa fa-folder-open-o"></i>&nbsp;<i class="fa fa-plus"></i>
                </span>
                <div><?php _e('Click this to create <strong>a new folder</strong>', RML_TD); ?></div>
                <p><?php _e('A folder can contain every type of file or a collection, but no gallery.', RML_TD); ?></p>
            </div>
            
            <div class="rml-intro-view">
                <span class="rml-intro-view-button">
                    <i class="mwf-collection"></i>&nbsp;<i class="fa fa-plus"></i>
                </span>
                <div><?php _e('Click this to create <strong>a new collection</strong>', RML_TD); ?></div>
                <p><?php _e('A collection can contain no files. But you can create there other collections and <strong>galleries</strong>.', RML_TD); ?></p>
            </div>
            
            <div class="rml-intro-view">
                <span class="rml-intro-view-button">
                    <i class="mwf-gallery"></i>&nbsp;<i class="fa fa-plus"></i>
                </span>
                <div><?php _e('Click this to create <strong>a new gallery</strong>', RML_TD); ?></div>
                <p><?php _e('A gallery can contain only images. If you want to display a gallery go to a post and have a look at the visual editor buttons.', RML_TD); ?></p>
            </div>
            
            <div class="arrow-down"><i class="fa fa-arrow-down"></i></div>
            <h3><?php _e('Bye bye chaos!', RML_TD) ?></h3>
            <div class="arrow-down"><i class="fa fa-arrow-down"></i></div>
            <div class="rml-info-image rii2"></div>
        </div>
        
        <?php
        if (isset($_GET["rml_test"])) {
            wp_rml_test_showcase();
        }
        ?>
    </div>
</div>