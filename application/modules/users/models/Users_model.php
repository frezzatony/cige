<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{

    private $cacheTree = array();

    function __construct(){

        parent::__construct();

    }  
    
    public function getUsers($arrProp = array()){
        
        $arrData = array(
            'from'      =>  'tsistema_usuarios TU',  
        );
         
        $arrData['where_in']    =   array();
        
        $arrData['select'] = array(
            'TU.id','TU.login','TU.nome as name','TU.email','TU.senha as password',
            'CONCAT("[",GROUP_CONCAT(TGU.id),"]") as groups',
            
        );
        
        $arrData['join'][] = array(
            'table'     =>  'tsistema_usuarios_grupos TUG',
            'on'        =>  'TUG.tsistema_usuarios_id = TU.id',
        );
        
        $arrData['join'][] = array(
            'table'     =>  'tsistema_grupos_usuarios TGU',
            'on'        =>  'TGU.id = TUG.tsistema_grupos_usuarios_id',
        );
        
        $arrData['group_by'] = array(
            'TU.id','TGU.id',
        );
        
        if(isset($arrProp['users_id'])){
            
            $arrData['where_in'][] = array(
                'column'    =>  'TU.id',
                'value'     =>  $arrProp['users_id']
            );
        } 
        
        
        $arrDataReturn = $this->database->getExecuteSelectQueryData($arrData);
        
        return $this->json->getFullArray($arrDataReturn);
    }
    
    
    public function update($arrProp = array()){
        
        
        if(($arrProp['data']['configs']??NULL)){
            
            $strKeys = '';
            $strValues = '';
            
            foreach($arrProp['data']['configs'] as $key => $value){
                if($strKeys){
                    $strKeys .=',';
                    $strValues .=',';
                }
                $strKeys .= '\''.$key.'\''; 
                $strValues .= '\''.$value.'\''; 
                
            }
                        
            $strKeys = 'ARRAY['.$strKeys.']';
            $strValues = 'ARRAY['.$strValues.']';
                
            $this->db->set('configs','json_object_set_keys(configs::JSON,'.$strKeys.','.$strValues.')',false);
            
            unset($arrProp['data']['configs']);
        }
        
        $this->db->set($arrProp['data']??array());
        
        
        $this->db->where('id',$arrProp['id']);
        $this->db->update('usuarios.usuarios');
        
        return ($this->db->affected_rows() > 0); 
        
    }
    /**
     * PRIVATES & PROTECTEDS
     */


}
