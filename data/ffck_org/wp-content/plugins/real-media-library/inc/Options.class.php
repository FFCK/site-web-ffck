<?php
/**
 * This class handles all hooks for the options.
 * 
 * @author MatthiasWeb
 * @package real-media-library\inc\attachment
 * @since 1.0
 * @singleton
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class RML_Options {
    private static $me = null;
    
    private function __construct() {
            
    }

    public function register_fields() {
        add_settings_section(
        	'rml_options',
        	'Real Media Library',
        	array($this, 'empty_callback'),
        	'media'
        );
        
        register_setting( 'media', 'rml_hide_upload_preview', 'esc_attr' );
        add_settings_field(
            'rml_hide_upload_preview',
            '<label for="rml_hide_upload_preview">'.__('Hide upload preview' , RML_TD ).'</label>' ,
            array($this, 'html_hide_upload_preview'),
            'media',
            'rml_options'
        );
        
        register_setting( 'media', 'rml_all_folders_gallery', 'esc_attr' );
        add_settings_field(
            'rml_all_folders_gallery',
            '<label for="rml_all_folders_gallery">'.__('Allow all folders for folder gallery' , RML_TD ).'</label>' ,
            array($this, 'html_rml_all_folders_gallery'),
            'media',
            'rml_options'
        );
    }
    
    function empty_callback( $arg ) {
    }
    
    public function html_rml_all_folders_gallery() {
        $value = get_option( 'rml_all_folders_gallery', '' );
        echo '<input type="checkbox" id="rml_all_folders_gallery"
                name="rml_all_folders_gallery" value="1" ' . checked(1, $value, false) . ' />';
    }
    
    public function html_hide_upload_preview() {
        $value = get_option( 'rml_hide_upload_preview', '' );
        echo '<input type="checkbox" id="rml_hide_upload_preview"
                name="rml_hide_upload_preview" value="1" ' . checked(1, $value, false) . ' />';
    }
    
    public static function getInstance() {
        if (self::$me == null) {
                self::$me = new RML_Options();
        }
        return self::$me;
    }
}

?>