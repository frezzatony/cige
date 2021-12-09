<?php
class date {
    
    var $CI;
    private $arrDateFormats = array('d/m/Y','Y-m-d',);
    
    public function __construct() {
        
    }
    
    
    public function dateAdd($arrProp = array()){
        
        if(gettype($arrProp['date'])!='object'){
            $date = DateTime::createFromFormat($this->getDateFormat($arrProp['date']),$arrProp['date']); 
        }
        else{
            $date = $arrProp['date'];
        }
        
        $dateString = $this->getDateEditString($arrProp);
        
        if($dateString){
            $date->add(new DateInterval($dateString));    
        } 
        
        if(gettype($arrProp['date'])!='object'){
            return $date->format($dateString);
        }
        return $date;
        
    }
    
    public function dateCompare($arrProp = array()){
                
        $dateFormat =  $this->getDateFormat(array('date'=>$arrProp['date_start']));
        
        if(!$dateFormat){
            return true;
        }
        
        $dateCheck = DateTime::createFromFormat($dateFormat,$arrProp['date_start']);
        
        //valida por data informada
        if(isset($arrProp['date_end'])){
            if($this->getDateFormat(array('date'=>$arrProp['date_end'])) == $dateFormat){
                $dateEnd = DateTime::createFromFormat($dateFormat,$arrProp['date_end']);       
            }
            else{
                return false;
            }
        }
        //valida por calculo de dias (AINDA NAO CONSIDERANDO DIAS ÚTEIS, SOMENTE DIAS CORRIDOS) 
        else{
            $dateEnd = DateTime::createFromFormat($dateFormat,date($dateFormat));    
        }
         
         
        if($arrProp['since'] == 'after'){
            $dateEnd = $this->dateAdd(
                array(
                    'date'  =>  $dateEnd,
                    'Y'     =>  (isset($arrProp['Y']) ? $arrProp['Y'] : null),
                    'M'     =>  (isset($arrProp['M']) ? $arrProp['M'] : null),
                    'D'     =>  (isset($arrProp['D']) ? $arrProp['D'] : null)  
                )
            );      
        }
        else if($arrProp['since'] == 'before'){
            $dateEnd = $this->dateSub(
                array(
                    'date'  =>  $dateEnd,
                    'Y'     =>  (isset($arrProp['Y']) ? $arrProp['Y'] : null),
                    'M'     =>  (isset($arrProp['M']) ? $arrProp['M'] : null),
                    'D'     =>  (isset($arrProp['D']) ? $arrProp['D'] : null)  
                )
            );      
        }             
             
        
        if($arrProp['compare'] == '=='){
            return $dateCheck == $dateEnd;
        }
        
        if($arrProp['compare'] == '<'){
            return $dateCheck < $dateEnd;
        }
        
        if($arrProp['compare'] == '<='){
            return $dateCheck <= $dateEnd;
        }
        
        if($arrProp['compare'] == '>'){
            return $dateCheck > $dateEnd;
        }
        
        if($arrProp['compare'] == '>='){
            return $dateCheck >= $dateEnd;
        }
        
    }
    
    
    public function dateSub($arrProp = array()){
        
        if(gettype($arrProp['date'])!='object'){
            $date = DateTime::createFromFormat($this->getDateFormat($arrProp['date']),$arrProp['date']); 
        }
        else{
            $date = $arrProp['date'];
        }
        
        $dateString = $this->getDateEditString($arrProp);
        
        if($dateString){
            $date->sub(new DateInterval($dateString));    
        } 
        
        if(gettype($arrProp['date'])!='object'){
            return $date->format($dateString);
        }
        return $date;
        
    } 
    public function getDateFormat($arrProp = array()){
        
        foreach($this->arrDateFormats as $format){
            $date = DateTime::createFromFormat($format,$arrProp['date']); 
            $valid = DateTime::getLastErrors();         
            if($valid['warning_count']==0 and $valid['error_count']==0){
                return $format;
            }     
        }
        
        return false;
    }
    
    public function getDateEditString($arrProp = array()){
        
        $dateString = '';
        
        if(isset($arrProp['Y']) AND is_numeric($arrProp['Y'])){
            $dateString .= $arrProp['Y'].'Y';
        }
        if(isset($arrProp['M']) AND is_numeric($arrProp['M'])){
            $dateString .= $arrProp['M'].'M';
        }
        if(isset($arrProp['D']) AND is_numeric($arrProp['D'])){
            $dateString .= $arrProp['D'].'D';
        }
         
        return $dateString ?  'P'.$dateString : '';
            
    }
    
    
    
}
