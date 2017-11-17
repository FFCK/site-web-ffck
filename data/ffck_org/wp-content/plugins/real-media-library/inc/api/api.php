<?php

/**
 * Defined Post Types
 * 
 *      define('RML_TYPE_FOLDER', 0);
 *      define('RML_TYPE_COLLECTION', 1);
 *      define('RML_TYPE_GALLERY', 2);
 *
 * Example Szenario #1:
 *   1. User navigates to http://example.com/rml/collection1
 *   2. Use wp_rml_get_by_absolute_path("/collection1") to get the RML_Folder Object
 *   3. (Additional check) $folder->is(RML_TYPE_COLLECTION) to check, if it is a collection.
 *   4. Iterate the childrens with foreach ($folder->children as $value) { }
 *   5. In collection can only be other collections or galleries.
 * 
 *   6. (Additional check) $value->is(RML_TYPE_GALLERY) to check, if it is a gallery.
 *   7. Fetch the IDs with $value->fetchFileIds();
 * 
 * 
 * If you want to use more attractive functions look into the RML_Structure Class.
 * You easily get it with RML_Structure::getInstance() (Singleton).
 */

if (!function_exists('wp_rml_create')) {
        function wp_rml_create($name, $parent, $type) {
                return RML_Structure::getInstance()->createFolder($name, $parent, $type);
        }
}

if (!function_exists('wp_rml_rename')) {
        function wp_rml_rename($name, $id) {
                return RML_Structure::getInstance()->renameFolder($name, $id);
        }
}

if (!function_exists('wp_rml_delete')) {
        function wp_rml_delete($id) {
                return RML_Structure::getInstance()->deleteFolder($id);
        }
}

if (!function_exists('wp_rml_move')) {
        function wp_rml_move($to, $ids) {
                if (!is_array($ids) || count($ids) == 0 || $to == null) {
                        return;
                }
                
                $folder = RML_Structure::getInstance()->getFolderById($to);
                if ($folder !== null) {
                        $folder->moveItemsHere($ids);
                }else{
                        if (is_array($ids) && count($ids) > 0) {
                            foreach ($ids as $value) {
                                update_post_meta($value, "_rml_folder", -1);
                                do_action("rml_item_moved", $value, false);
                            }
                        }
                }
        }
}

if (!function_exists('wp_rml_dropdown')) {
        /**
         * This functions returns a HTML formatted string which contains
         * <options> elements with all folders, collections and galleries.
         * 
         * @param $selected The selected item
         *              "": "All Files"
         *              -1: "Root"
         *              int: Folder ID
         * @param $disabled array Defines, which folder types are disabled (@see ./real-media-library.php for Constant-Types)
         *                        Default disabled is RML_TYPE_COLLECTION
         * @param $useAll boolean Defines, if "All Files" should be showed
         * @return String
         */
        function wp_rml_dropdown($selected, $disabled, $useAll = true) {
                return RML_Structure::getInstance()->optionsFasade($selected, $disabled, $useAll);
        }
}

if (!function_exists('wp_rml_dropdown_collection')) {
        /**
         * This functions returns a HTML formatted string which contains
         * <options> elements with all folders, collections and galleries.
         * Note: Only COLLECTIONS are SELECTABLE!
         * 
         * @param $selected The selected item
         *              "": "All Files"
         *              -1: "Root"
         *              int: Folder ID
         * @return String
         */
        function wp_rml_dropdown_collection($selected) {
                return wp_rml_dropdown($selected, array(0,2,3,4));
        }
}

if (!function_exists('wp_rml_dropdown_gallery')) {
        /**
         * This functions returns a HTML formatted string which contains
         * <options> elements with all folders, collections and galleries.
         * Note: Only GALLERIES are SELECTABLE!
         * 
         * @param $selected The selected item
         *              "": "All Files"
         *              -1: "Root"
         *              int: Folder ID
         * @return String
         */
        function wp_rml_dropdown_gallery($selected) {
                return wp_rml_dropdown($selected, array(0,1,3,4));
        }
}

if (!function_exists('wp_rml_dropdown_gallery_or_collection')) {
        /**
         * This functions returns a HTML formatted string which contains
         * <options> elements with all folders, collections and galleries.
         * Note: Only GALLERIES AND COLLECTIONS are SELECTABLE!
         * 
         * @param $selected The selected item
         *              "": "All Files"
         *              -1: "Root"
         *              int: Folder ID
         * @return String
         */
        function wp_rml_dropdown_gallery_or_collection($selected) {
                return wp_rml_dropdown($selected, array(0,3,4));
        }
}

if (!function_exists('wp_rml_is_type')) {
        /**
         * Determines, if a Folder is a special folder type.
         * 
         * @param $folder RML_Folder
         * @param $allowed array Defines, which folder types are allowed (@see ./real-media-library.php for Constant-Types) 
         * @return boolean
         */
        function wp_rml_is_type($folder, $allowed) {
                if (!$folder instanceof RML_Folder) {
                        return false;
                }
                
                return in_array($folder->type, $allowed);
        }
}

if (!function_exists('wp_rml_get_by_id')) {
        /**
         * This functions checks if a specific folder exists by ID and is
         * a given allowed RML Folder Type.
         * 
         * @param $id int Folder ID
         * @param $allowed array Defines, which folder types are allowed (@see ./real-media-library.php for Constant-Types)
         *                       If it is null, all folder types are allowed.
         * @return RML_Folder object or NULL
         * 
         * Note: The Folder ID must be a valid Folder ID, not Root and "All Files" => FolderID > -1
         */
        function wp_rml_get_by_id($id, $allowed = null) {
                $folder = RML_Structure::getInstance()->getFolderByID($id);
                
                if (is_array($allowed)) {
                        if (!wp_rml_is_type($folder, $allowed)) {
                                return null;
                        }
                }
                
                return $folder;
        }
}

if (!function_exists('wp_rml_get_by_absolute_path')) {
        /**
         * This functions checks if a specific folder exists by absolute path and is
         * a given allowed RML Folder Type.
         * 
         * @param $path string Folder Absolute Path
         * @param $allowed array Defines, which folder types are allowed (@see ./real-media-library.php for Constant-Types)
         *                       If it is null, all folder types are allowed.
         * @return RML_Folder object or NULL
         * 
         * Note: The absolute path may not be "/" (Root).
         */
        function wp_rml_get_by_absolute_path($path, $allowed = null) {
                $folder = RML_Structure::getInstance()->getFolderByAbsolutePath($path);
                
                if (is_array($allowed)) {
                        if (!wp_rml_is_type($folder, $allowed)) {
                                return null;
                        }
                }
                
                return $folder;
        }
}

if (!function_exists('wp_rml_test_showcase')) {
        /**
         * Outputs a few options for the api usage
         */
        function wp_rml_test_showcase() {
                echo '<br /><br />
                        Selected: Root; All folder types allowed; "All Files" disabled
                        <select>
                                ' . wp_rml_dropdown(-1, array(), false) . '
                        </select>';
                        
                echo '<br /><br />
                        Selected: All Files; Only folders allowed; "All Files" allowed
                        <select>
                                ' . wp_rml_dropdown(-1, array(RML_TYPE_COLLECTION, RML_TYPE_GALLERY), true) . '
                        </select>';
                        
                echo '<br /><br />
                        Select a collection
                        <select>
                                ' . wp_rml_dropdown_collection("") . '
                        </select>';
                        
                echo '<br /><br />
                        Select a gallery
                        <select>
                                ' . wp_rml_dropdown_gallery("") . '
                        </select>';
                        
                echo '<br /><br />
                        Select a gallery or collection
                        <select>
                                ' . wp_rml_dropdown_gallery_or_collection("") . '
                        </select>';
                        
                echo '<br /><br />
                        Get Folder with childrens by Absolute Path (/kollektionen/bmw)
                ';
                RML_Core::print_r(wp_rml_get_by_absolute_path("/kollektionen/bmw"));
                
                echo '<br /><br />
                        Check if root has child folder /kollektionen/
                ';
                var_dump(RML_Structure::getInstance()->hasChildSlug(-1, "kollektionen", false));
        }
}

?>