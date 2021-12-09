<?php

/**
 * @author Tony Frezza
 */

class Arrays {
        
    public function buildTree(array &$elements, $parentId = 0,$keys = array()) {

        $branch = array();
        
        $keys['id'] = $keys['id'] ?? 'id';
        $keys['children'] = $keys['children'] ?? 'children';
        $keys['child_parent'] = $keys['child_parent'] ?? 'id_item_pai';
        
        foreach ($elements as &$element) {
    
            if (array_key_exists($keys['child_parent'],$element) AND  $element[$keys['child_parent']] == $parentId) {
                $children = self::buildTree($elements, $element[$keys['id']],$keys);
                if ($children) {
                    $element[$keys['children'] ] = $children;
                }
                $branch[$element[$keys['id']]] = $element;
                unset($element);
            }
            else{
               //$branch[] = $element;
               //unset($element);
            }
        }
        return $branch;
    }
        
}
?>