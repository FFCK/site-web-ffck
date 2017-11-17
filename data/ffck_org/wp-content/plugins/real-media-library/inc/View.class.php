<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class RML_View {
        private $structure;
        
        public function __construct($structure) {
                $this->structure = $structure;
        }
        
        /**
         * Gets a HTML formatted string for <option>
         * 
         * @recursive
         */
        public function optionsHTML($selected = -1, $tree = null, $slashed = "", $spaces = "--", $useAll = true, $disabled = null) {
            $return = '';
            if ($disabled === null) {
                $disabled = array(RML_TYPE_COLLECTION);
            }
            
            if ($tree == null) {
                $tree = $this->structure->getTree();
                if ($useAll) {
                    $return .= '<option value="" ' . $this->optionsSelected($selected, "") . '
                                        ' . ((in_array(RML_TYPE_ALL, $disabled)) ? 'disabled="disabled"' : '') . '
                                        >' . __('All', RML_TD) . '</option>';
                }
                $return .= '<option value="-1" ' . $this->optionsSelected($selected, "-1") . '
                                    data-slug="/"
                                    ' . ((in_array(RML_TYPE_ROOT, $disabled)) ? 'disabled="disabled"' : '') . '
                                    data-id="-1">' . __('Root', RML_TD) . '</option>';
            }
            
            if(!is_null($tree) && count($tree) > 0) {
                foreach($tree as $parent) {
                    $return .= '<option value="' . $parent->id . '" ' . $this->optionsSelected($selected, $parent->id) . '
                                        data-slug="/' . $parent->absolutePath() . '"
                                        data-id="' . $parent->id . '"
                                        ' . ((in_array($parent->type, $disabled)) ? 'disabled="disabled"' : '') . '>
                                        ' . $spaces . '&nbsp;' . $parent->name . '
                                </option>';
                    
                    if (isset($parent->children) &&
                        is_array($parent->children) &&
                        count($parent->children) > 0
                        ) {
                        $return .= $this->optionsHTML($selected, $parent->children, $slashed, $spaces . "--", $useAll, $disabled);
                    }
                }
            }
            
            return $return;
        }
        
        /**
         * Gets the html string for the left tree.
         * 
         * @recursive
         */
        public function treeHTML($selected = -1, $tree = null) {
            $return = '';
            
            // First item
            if ($tree == null) {
                $tree = $this->structure->getTree();
                $return .= '<a href="' . $this->treeHref(-1) . '"
                                ' . $this->treeActive($selected, -1) . '
                                data-slug="/"
                                data-id="-1">
                                
                                    <i class="fa fa-dot-circle-o"></i>/
                                    <span class="rml-cnt-' . $this->structure->getCntRoot() . '">' . $this->structure->getCntRoot() . '</span>
                            </a>';
            }
            
            // Create list
            $return .= '<ul>';
            if(!is_null($tree) && count($tree) > 0) {
                foreach($tree as $parent) {
                    $icon = '<i class="fa fa-folder-open"></i><i class="fa fa-folder"></i>';
                    if ($parent->type == 1) {
                        $icon = '<i class="mwf-collection"></i>';
                    }else if ($parent->type == 2) {
                        $icon = '<i class="mwf-gallery"></i>';
                    }
                    
                    $return .= '
                    <li id="list_' . $parent->id . '">
                        <a href="' . $this->treeHref($parent->id) . '"
                            ' . $this->treeActive($selected, $parent->id) . '
                            data-slug="/' . $parent->absolutePath() . '"
                            data-type="' . $parent->type . '" 
                            data-id="' . $parent->id . '">
                            
                            ' . $icon . ' ' . $parent->name . '
                            <span class="rml-cnt-' .  $parent->getCnt() . '">' . $parent->getCnt() . '</span>
                        </a>
                    ';
                    
                    if (isset($parent->children) &&
                        is_array($parent->children) &&
                        count($parent->children) > 0
                        ) {
                        $return .= $this->treeHTML($selected, $parent->children);
                    }else{
                        $return .= '<ul></ul>';
                    }
                    
                    $return .= '</li>';
                }
            }
            $return .= '</ul>';
            
            return $return;
        }
        
        public function optionsSelected($selected, $value) {
            if ($selected == $value) {
                return 'selected="selected"';
            }else{
                return '';
            }
        }
        
        public function treeHref($id) {
            $query = $_GET;
            $query['rml_folder'] = $id;
            $query_result = http_build_query($query);
            
            return admin_url('upload.php?' . $query_result);
        }
        
        public function treeActive($selected, $value) {
            if ($selected == $value) {
                return 'class="active"';
            }else{
                return '';
            }
        }
            
        /**
         * Get array for the javascript backbone view.
         */
        public function namesSlugArray($tree = null, $spaces = "--") {
            $return = array(
                "names" => array(),
                "slugs" => array(),
                "type" => array()
            );
            
            if ($tree == null) {
                $tree = $this->structure->getTree();
                $return["names"][] = "Root";
                $return["slugs"][] = -1;
                $return["types"][] = 0;
            }
            
            if(!is_null($tree) && count($tree) > 0) {
                foreach($tree as $parent) {
                    $return["names"][] = $spaces . ' ' . $parent->name;
                    $return["slugs"][] = $parent->id;
                    $return["types"][] = $parent->type;
                    
                    if (isset($parent->children) &&
                        is_array($parent->children) &&
                        count($parent->children) > 0
                        ) {
                        $append = $this->namesSlugArray($parent->children, $spaces . "--");
                        $return["names"] = array_merge($return["names"], $append["names"]);
                        $return["slugs"] = array_merge($return["slugs"], $append["slugs"]);
                        $return["types"] = array_merge($return["types"], $append["types"]);
                    }
                }
            }
            
            return $return;
        }
        
        public function getHTMLBreadcrumbByID($id) {
            $breadcrumb = $this->structure->getBreadcrumbByID($id);
            
            $output = '<i class="fa fa-folder-open"></i>';
            
            if (count($breadcrumb) == 0) {
                return $output . ' ' . __('Root', RML_TD);
            }
            
            for ($i = 0; $i < count($breadcrumb); $i++) {
                $output .= '<span class="folder">' . $breadcrumb[$i]->name . '</span>';
                
                // When not last, insert seperator
                if ($i < count($breadcrumb) - 1) {
                    $output .= '<i class="fa fa-chevron-right"></i>';
                }
            }
            
            return $output;
        }
        
        public function getStructure() {
                return $this->structure;
        }
}

?>