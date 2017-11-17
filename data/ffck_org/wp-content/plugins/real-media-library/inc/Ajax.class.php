<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class RML_Ajax {
	private static $me = null;
        
        private function __construct() {
                
        }
        
        private function check() {
                if (!current_user_can('upload_files')) {
                        wp_send_json_error(__("Something went wrong."));
                }
        }
        
        public function wp_ajax_bulk_move() {
                $this->check();
                
                $ids = isset($_POST["ids"]) ? $_POST["ids"] : null;
                $to = isset($_POST["to"]) ? $_POST["to"] : null;
                
                wp_rml_move($to, $ids);
                
                wp_die();
        }
        
        public function wp_ajax_bulk_sort() {
                $this->check();
                
                $ids = isset($_POST["ids"]) ? $_POST["ids"] : null;
                if (!is_array($ids) || count($ids) == 0) {
                        wp_send_json_error(__("Something went wrong."));
                }
                
                // fid (folderid): pid: (parentid)
                $struct = RML_Structure::getInstance();
                
                $changer = array(); // This folders can be changed
                
                // Check, if types are right
                $i = 0;
                $foundError = false;
                foreach ($ids as $value) {
                        $fid = $value["fid"]; // Folder ID
                        $pid = $value["pid"]; // Parent ID
                        
                        // Check
                        if (!is_numeric($fid) || !is_numeric($pid)) {
                                continue;
                        }
                        
                        // Execute
                        $fid = $struct->getFolderById($fid);
                        if ($fid !== null && $struct->isAllowedTo($pid, $fid->type)) {
                                // Check, if parent may have this name as folder.
                                
                                $changer[] = array($fid, $pid, $i);
                        }else{
                                $foundError = true;
                                break;
                        }
                        
                        $i++;
                }
                
                // Change it!
                if ($foundError) {
                        wp_send_json_error(__("Something went wrong. Please be sure folders can not be in collections and galleries, collections can only be in folders and other collections and galleries can only be in collections.", RML_TD));
                }else{
                        foreach ($changer as $value) {
                                $value[0]->setParent($value[1], $value[2]);
                        }
                        wp_send_json_success();
                }
        }
        
        public function wp_ajax_folder_create() {
                $this->check();
                
                $name = isset($_POST["name"]) ? $_POST["name"] : "";
                $parent = isset($_POST["parent"]) ? $_POST["parent"] : -1;
                $type = isset($_POST["type"]) ? $_POST["type"] : -1;
                
                if (wp_rml_create($name, $parent, $type)) {
                        wp_send_json_success();
                }else{
                        wp_send_json_error(__("Please use a valid folder name and make sure, there is no duplicate folder name.", RML_TD));
                }
        }
        
        public function wp_ajax_folder_rename() {
                $this->check();
                
                $name = isset($_POST["name"]) ? $_POST["name"] : "";
                $id = isset($_POST["id"]) ? $_POST["id"] : -1;
                
                if (wp_rml_rename($name, $id)) {
                        wp_send_json_success();
                }else{
                        wp_send_json_error(__("Please use a valid folder name and make sure, there is no duplicate folder name.", RML_TD));
                }
        }
        
        public function wp_ajax_folder_delete() {
                $this->check();
                
                $id = isset($_POST["id"]) ? $_POST["id"] : -1;
                
                if (wp_rml_delete($id)) {
                        wp_send_json_success();
                }else{
                        wp_send_json_error();
                }
        }
        
        public static function getInstance() {
                if (self::$me == null) {
                        self::$me = new RML_Ajax();
                }
                return self::$me;
        }
}

?>