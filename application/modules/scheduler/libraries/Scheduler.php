<?php

/**
 * @author Tony Frezza

 */


class Scheduler extends Cadastros{
    
    function __construct($arrProp = array()){
        
        $this->CI = &get_instance();
        
        parent::__construct(
            array(
                'module'            =>  'scheduler',
                'uri_segment'       =>  $this->CI->config->item('uri_segment','scheduler'),
                'request_by_config' =>  TRUE,
                'configs'           =>  $this->CI->config->item('scheduler'),
                'data_file'         =>  'data_scheduler',
                'item'              =>  $arrProp['item'] ?? NULL,
            )
        ); 
        
        $this->set('id',$this->get('data.id_controller'));
    }
    
    public function setJob($periodicidade,$action,$idJob=NULL){
        
        $this->CI->load->library('crontab');        
        $this->CI->crontab->set_job($periodicidade,$action,$idJob);
    }
    
    public function removeJob($idJob = NULL){
        
        $this->CI->load->library('crontab');
        $this->CI->crontab->remove_job($idJob);
    }
    public function initModule(){
        
        //set no DATA do core para que modulos se registrem
        $this->CI->data->set('scheduler',
            array(
                'modules'   =>  array()
            )
        );
    }
    
    public function registerModule($arrProp = array()){
        
        /**
         * formato do registro do modulo:
         *  array(
         *      'name'      =>  {NOME},
         *       'methods'   =>  array(
         *          array(
         *              'name'          =>  '{method_name}',
         *              'parameters'    =>  array()
         *          )
         *      )  
         *  )
        **/
        
        $this->CI->data->append('scheduler.modules',$arrProp);
        
    }
    
    public function getRegisteredModules(){
        
        return $this->CI->data->get('scheduler.modules');
        
    }
    
     

    /**
     * PRIVATES
     */


}

?>