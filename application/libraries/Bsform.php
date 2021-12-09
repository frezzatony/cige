<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class BsForm extends Data{
    
    
    //directories to include more inputs
    public  $arrScanInputsDirectories    = array();
    
    public function __construct($arrProp = array()){
        
        parent::__construct();
        
        $this->CI->template->loadCss(BASE_URL.'assets/plugins/bsform/css/bsform.css');
        
        $this->CI->template->loadJs(BASE_URL.'assets/plugins/mask/jquery.inputmask.bundle.js');
        $this->CI->template->loadJs(BASE_URL.'assets/plugins/bsform/bsform.js');
        $this->CI->template->loadJs(BASE_URL.'assets/plugins/bsform/bsform-setvalues.js');
        $this->CI->template->loadJs(BASE_URL.'assets/plugins/bsform/bsform-getvalues.js');
        
        
        
        if($arrProp){
            $this->set($arrProp);
        }
        
        $directory = dirname(__FILE__).'/BsForm/';
        require_once($directory.'Bsform_defaults.php');
        require_once($directory.'Bsform_javascript.php');
        
        $directory.='Inputs/';
        $this->scanInputDirectory($directory);
        
        if(sizeof($this->arrScanInputsDirectories)){
            foreach($this->scanInputsDir as $directory){
                if(!is_dir($directory)){
                    $this->scanInputDirectory($directory);   
                }   
            }
        }
        
        $this->arrNoAttribute = array(
            'grid_xs','grid_sm','grid_md','grid_lg','input_xs','input_sm','input_md','input_lg','grid_class',
            'tfonte_nome','tfonte_c_pk','tfonte_c_val', 'no_grid','no_fieldset', 'no_label', 'no_errorarea',
            'no_tabulate','from_list','from_rest','from_model','column','autoincrement',
        );
        
        
        if(!$this->get('id')){
            $this->set('id',$this->getId($arrProp));
            $this->set('random_id',TRUE);
        }
        
    }
    
    public function getButtons($arrProp = array()){
        
        if(array_key_exists('buttons',$arrProp)===FALSE){
            $arrProp['buttons'] = $this->getHtmlData()['buttons'];
        }
        
        foreach($arrProp['buttons'] as $key => $button){
            $flagUnset = FALSE;
            
            if(array_key_exists('unset_by_id',$arrProp) AND array_key_exists('id',$button) AND in_array($button['id'],$arrProp['unset_by_id'])){
                $flagUnset = TRUE;
            }
            
            if(array_key_exists('unset_by_class',$arrProp) AND array_key_exists('class',$button)){
                foreach($arrProp['unset_by_class'] as $class){
                    if(in_array($class,explode(' ',$button['class']))){
                        $flagUnset = TRUE;       
                    }
                }
            }
            
            if(array_key_exists('filter_by_class',$arrProp) AND array_key_exists('class',$button)){
                foreacH($arrProp['filter_by_class'] as $class){
                    if(!in_array($class,explode(' ',$button['class']))){
                        $flagUnset = TRUE;       
                    }
                }
            }
            
            
            if($flagUnset){
                unset($arrProp['buttons'][$key]);
            }
        }
        return $arrProp['buttons'];    
    }
    
    public function getHtml(){
        
        $html = new Html;
        
        $htmlData = $this->getHtmlData();
        
        if(array_key_exists('form',$htmlData)){
            
            $html->add($htmlData['form']);
            
        }
        else{
            $html->add($htmlData);    
        }
        
        return $html->getHtml();
    }
    
    public function getHtmlData(){
        
        $htmlData = array(
            'javascript'    =>  '',
        );
        
        $strJsOnUpdate = $this->getJsOnUpdate();
        if($strJsOnUpdate OR $this->get('ajax')){
            
            if(!$this->get('id') OR $this->get('random_id')){
                show_error('Você não informou a ID de um formulário que possui atualizações dinâmicas (ajax).'); 
                return;
            }
            
            $htmlData['javascript'] .= $strJsOnUpdate;
            $this->saveFormInCache();    
        }
        
        
        $template = $this->get('template') ? $this->get('template') : '1';
        
        $directory = dirname(__FILE__).'/BsForm/';
        require_once($directory.'Templates/'.$template.'.php');
        
        $className = 'BsFormTemplate_'.$template;
        
        $tempBsForm = new BsForm($this->get());
        $tempBsForm->parse();
        $template = new $className($tempBsForm);
        
        $htmlData = array_merge(
            $htmlData,
            $template->getHtmlData()
        );
        
        $htmlData['javascript'] = ($htmlData['javascript']??NULL) ? $htmlData['javascript'] : '';
        
        return $htmlData;
    }
    
    
    public function getId($arrInput = array()){
        
        if(!isset($arrInput['id']) || !$arrInput['id']){
            $arrInput['id'] = random_string();
        }
        
        return $arrInput['id'];
            
    }
    
    public function getInputHtmlData(&$arrProp,$treeData = array()){
        
        $arrProp['index'] = $arrProp['index'] ?? 0; 
        
        if(!sizeof($treeData)){
            $treeData = $this->getHtmlData()['form']['children'];
        }
        
        foreach($treeData as $node){
            
            if(($node['id']??NULL) == $arrProp['input_id']){
                if(($arrProp['index_value']??NULL)===NULL){
                    return $node;
                }
                else if(($arrProp['index_value']??NULL)!==NULL && $arrProp['index_value'] == $arrProp['index']){
                    return $node;    
                }
                else if(($arrProp['index_value']??NULL)!==NULL){
                    $arrProp['index']++;
                }
                 
            }
            else if(($node['children'] ?? NULL)){
                
                $arrReturn = self::getInputHtmlData($arrProp,$node['children']);
                if($arrReturn){
                    return $arrReturn;
                }
            }        
        }
        
        return NULL;
    }
    
    public function getOptionsFromData($arrProp = array()){
        
        $arrReturn = array();
        
        foreach($arrProp['data'] as $data){
            
            $arrReturn[] = array(
                'value'     =>  $data[$arrProp['value_key']],
                'text'      =>  $data[$arrProp['text_key']]
            );
        }
        
        return $arrReturn;
        
    }
    
    public function parse($arrData = array(),$treeParents=''){
        
        if(!$arrData){
            $arrData = $this->get();
        }
        
       
        
        foreach($arrData as $key => $val){
            
            if(is_array($val) AND !sizeof($val)){ //ARRAY VAZIO
                continue;
            }
            else if(is_array($val) AND sizeof($val)){
                
                self::parse($val,($treeParents ? $treeParents.'.' : '' ) . $key);
                
            }
            else if(strpos($val,'{')===0 AND substr($val,-1)=='}'){
                
                $val = substr(substr($val,1),0,strlen($val)-2);
                $arrKeys = explode('.',$val);
                $keyParent = $arrKeys[0];
                unset($arrKeys[0]);
                
                foreach($arrKeys as &$keyValue){
                    if(strpos($keyValue,'{')===0 AND substr($keyValue,-1)=='}'){
                       $keyValue = substr(substr($keyValue,1),0,strlen($keyValue)-2);
                       $keyValue = $this->get($keyValue);
                    }
                    
                }
                
                $val = implode('.',$arrKeys);
                
                switch($keyParent){
                    case 'this':{
                        $treeParents = ($treeParents ? $treeParents.'.' : '' ) . $key;
                        
                        if($this->isset($val)){
                            $this->set($treeParents,$this->get($val));    
                        }
                        break;
                    } 
                }
            }
        }    
    }
    
    public function setValues($arrValues = array()){
        
        
        foreach($arrValues as $inputId => $value){
            
            if($this->get('nodes')){
                foreach($this->get('nodes') as $key => $node){
                    $keyInput = array_search($inputId,array_column($this->get('nodes.'.$key.'.inputs'),'id'));
                    
                    if($keyInput!==FALSE){
                        $this->set('nodes.'.$key.'.inputs.'.$keyInput.'.value',$value);    
                    }       
                }
            }
            else{
                $keyInput = array_search($inputId,array_column($this->get('inputs'),'id'));
                
                if($keyInput!==FALSE){
                    $this->set('inputs.'.$keyInput.'.value',$value);    
                }    
            }
  
        }
    }
    /**
     * PRIVATES
     **/
    private function getJsOnUpdate(){
        
        if($this->get('nodes')){
           $arrNodes = $this->get('nodes');            
        }
        else{
            $arrNodes = array(
                array(
                    'inputs'    =>  $this->get('inputs'),
                )
            );
        }
        
        if(!$arrNodes){
            return NULL;
        }
        
        $jsReturn = '';
        foreach($arrNodes as $node){
            
            foreach(($node['inputs'] ?? array()) as $key => $input){
                if(($input['update_on'] ?? NULL)){
                    
                    $input['id'] = $this->getId($input); 
                    
                    $input['data-token'] = $this->CI->encryption->encrypt(
                        json_encode(
                            array(
                                'internal'      =>  TRUE,
                                'source'        =>  'input_options',
                                'form'          =>  $this->get('id'),
                                'input_id'      =>  $input['id'],
                            ),
                            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                        )
                    );
                    
                    $input['data-bind'] = '';
                    
                    foreach($input['update_on'] as $action){
                        if($input['data-bind']){
                            $input['data-bind'] .=',';
                        } 
                        $input['data-bind'] .= $action['bind'].'['.$action['selector'].']';
                    }
                    
                    $this->set('inputs.'.$key,$input);
                    
                    $jsReturn .= "\n".$this->getInputJsOnUpdate($input);
                }    
            }
        } 
        
        return $jsReturn;       
    }
    
    private function getInputJsOnUpdate($arrInput = array()){
        
        $bsformJs = new Bsform_javascript($this->get());
        return $bsformJs->getJsOnUpdate($arrInput);
        
    }
    
    
    private function saveFormInCache($rewrite = FALSE){
        
        if(!$this->get('id')){
            show_error('Você não informou a ID de um formulário que possui atualizações dinâmicas (ajax).'); 
            return;   
        }
        
        $cacheName = 'bsform_'.$this->get('id');
        
        if(!$this->CI->cache->file->get($cacheName) OR $rewrite){
            $this->CI->cache->file->save($cacheName, $this->get(),60*60*2);
        }
        
        return TRUE;
    }
    
    private function scanInputDirectory($directory){
        
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        
        foreach($scanned_directory as $input_file){
            if(is_dir($directory.$input_file)){
                continue;
                  
            }   

            require_once($directory.$input_file);
            
            $objectName = preg_replace('/.php/', '', $input_file);
            $className = $objectName.'_bsform';
            
            $this->{strtolower($objectName)} = new $className;
            
        } 
    }

}
