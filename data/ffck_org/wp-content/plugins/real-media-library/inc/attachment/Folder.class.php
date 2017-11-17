<?php
/**
 * This class creates a folder object. The $type variable defines,
 * if it is a:
 * 
 * RML_TYPE_FOLDER
 * RML_TYPE_COLLECTION
 * RML_TYPE_GALLERY
 * 
 * @author MatthiasWeb
 * @package real-media-library\inc\attachment
 * @since 1.0
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class RML_Folder {
    
    public $id;
    public $parent;
    public $name;
    private $cnt;
    public $order;
    
    /**
     * Defines the RML_TYPE_...
     * @since 2.2
     */
    public $type;
    
    /**
     * A array of childrens RML_Folder object
     */
    public $children;
    
    /**
     * The slug of this folder for URLs, use getter.
     */
    private $slug;
    
    /**
     * The absolute path to this folder, use getter.
     */
    private $absolutePath;

    public function __construct($id, $parent, $name, $order = 999, $type = 0) {
        $this->id = $id;
        $this->parent = $parent;
        $this->name = $name;
        $this->cnt = null;
        $this->order = $order;
        $this->type = $type;
        $this->children = array();
        $this->slug = null;
        $this->absolutePath = null;
    }
    
    /**
     * Move several items to this folder.
     * 
     * @param $ids array of post ids
     * @author MatthiasWeb
     * @package real-media-library\inc\attachment
     * @since 1.0
     */
    public function moveItemsHere($ids) {
        if (is_array($ids) && count($ids) > 0 && $this->type != 1) {
            foreach ($ids as $value) {
                if ($this->type == 2 && !wp_attachment_is_image($value)) { // if it is a gallery, there are only images allowed
                    continue;
                }else{
                    update_post_meta($value, "_rml_folder", $this->id);
                    do_action("rml_item_moved", $value, $this);
                }
            }
        }
    }
    
    /**
     * Fetch all attachment ids currently in this folder.
     * 
     * @return array of post ids
     */
    public function fetchFileIds() {
        return self::sFetchFileIds($this->id);
    }
    
    public static function sFetchFileIds($id) {
        $query = new WP_Query(array(
        	'post_status' => 'inherit',
        	'post_type' => 'attachment',
        	'posts_per_page' => -1,
        	/*'meta_query' => array(
        	    array(
        	        'key' => '_rml_folder',
        	        'value' => $id,
        	        'compare' => '='
	            )),*/
	        'rml_folder' => $id,
	        'fields' => 'ids'
        ));
        $query = apply_filters('rml_query'. $query);
        $posts = $query->get_posts();
        $posts = apply_filters('rml_posts', $posts);
        return $posts;
    }
    
    /**
     * Returns a santitized title for the folder.
     * 
     * @return string slug
     */
    public function slug() {
        if ($this->slug === null) {
            $this->slug = sanitize_title($this->name, "", "folder");
        }
        
        return $this->slug;
    }
    
    /**
     * Creates a absolute path.
     * 
     * @return string path
     */
    public function absolutePath() {
        if ($this->absolutePath === null) {
            $return = array($this->slug());
            $folder = $this;
            while (true) {
                $f = RML_Structure::getInstance()->getFolderByID($folder->parent);
                if ($f !== null) {
                    $folder = $f;
                    $return[] = $folder->slug();
                }else{
                    break;
                }
            }
            $this->absolutePath = implode("/", array_reverse($return));
        }
        return $this->absolutePath;
    }
    
    /**
     * Checks, if this folder has a children with the name.
     *  
     * @param $slug String Slug or Name of folder
     * @param $isSlug boolean Set it to false, if the slug is not santizied (@see $this->slug())
     * @return boolean true/false
     */
    public function hasChildSlug($slug, $isSlug = true) {
        if (!$isSlug) {
            $slug = sanitize_title($slug, "", "folder");
        }
        
        foreach ($this->children as $value) {
            if ($value->slug() == $slug) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Changes the parent folder of this folder.
     * 
     * @return boolean true = Parent could be changed
     */
    public function setParent($id, $ord = 99, $force = false) {
        if ($force || RML_Structure::getInstance()->isAllowedTo($id, $this->type)) {
            $oldParent = $this->parent;
            
            $this->parent = $id;
            
            global $wpdb;
            
            // Save in database
            $table_name = RML_Core::getInstance()->getTableName();
            $wpdb->query($wpdb->prepare("UPDATE $table_name SET parent=%d, ord=%d WHERE id = %d", $id, $ord, $this->id));
            
            // Reset
            $this->slug = null;
            $this->absolutePath = null;
            
            // @TODO update children in parents
            
            do_action('rml_set_parent', $this, $id, $ord, $force);
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Renames a folder and then checks, if there is no duplicate folder in the
     * parent folder.
     * 
     * @param name String New name of the folder
     * @return boolean
     */
    public function setName($name) {
        if (strpbrk($name, "\\/?%*:|\"<>") === FALSE && $this->id > 0) {
            if (RML_Structure::getInstance()->hasChildSlug($this->parent, $name, false)) {
                return false;
            }
            
            global $wpdb;
            
            // Save in Database
            $table_name = RML_Core::getInstance()->getTableName();
            $wpdb->query($wpdb->prepare("UPDATE $table_name SET name=%s WHERE id = %d", $name, $this->id));
            
            // Reset
            $this->slug = null;
            $this->absolutePath = null;
            
            do_action('rml_set_name', $name, $this);
            
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Gets the count of the files in this folder.
     * 
     * @return int
     */
    public function getCnt() {
        if ($this->cnt === null) {
            $query = new RML_WP_Query_Count(
                apply_filters('rml_count_query', array(
                	'post_status' => 'inherit',
                	'post_type' => 'attachment',
                	'rml_folder' => $this->id
                ))
            );
            if (isset($query->posts[0])) {
                $this->cnt = $query->posts[0];
            }else{
                $this->cnt = 0;
            }
        }
        return $this->cnt;
    }
    
    public function getType() {
        return $this->type;
    }
    
    /**
     * Returns childrens of this folder.
     * 
     * @return array of RML_Folder
     */
    public function getChildrens() {
        return $this->children;
    }
    
    /**
     * Check if folder is a RML_TYPE_...
     * 
     * @param $folder_type (@see ./real-media-library.php for Constant-Types)
     * @return boolean
     */
    public function is($folder_type) {
        return $this->type == $folder_type;
    }
}

?>