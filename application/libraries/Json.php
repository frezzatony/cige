<?php

/**
 * @author Tony Frezza

 */



class Json {
	
	private $services;
	
	function __construct() {
		
		$directory = dirname(__FILE__) . '/Json/';
		require_once($directory . 'Services_JSON.php');
		
		$this->services = New Services_JSON();
		
	}
	
	function __call($name, $arguments) {
		
		if (method_exists($this->services, $name)) {
			return $this->services->$name($arguments);
		}
        else{
            return $this->$name;    
        }
		
	}
	
	
	public function getAllAsHtml($json, $escape = null) {
		$json = $this->getFullArray($json, $escape);
		if (is_array($json)) {
			array_walk_recursive($json, 'Json::setAsHtml');
		}
		
		return $this->services->encode($json);
		
	}
	
	public function getAllAsString($json) {
		
		$json = $this->getFullArray($json);
		array_walk_recursive($json, 'Json::setAsstring');
		
		return $this->services->encode($json);
		
	}
	/*
	public function getFullArray($value,$recursive = TRUE){
        
        if(is_string($value)){
            //$value = json_decode($value,true);    
        }
        
        return $this->_getFullArray($value,$recursive);
       
	}*/
     
	public static function getFullArray($value, $formatString = TRUE,$recursive = TRUE) {
		
		if (is_object($value)) {
			$value = get_object_vars($value);
		}
        
        if(is_string($value) AND $formatString){
            $value = str_replace('"}"','"}',str_replace(':"{',':{',$value));
        }
        
		if (!empty($value) AND is_string($value) AND is_array(json_decode($value, true))) {
			$return = json_decode($value, true);
		} elseif (is_array($value) AND $recursive) {
			$return = array_map('Json::getFullArray', $value);
		} else {
			$return = $value;
		}
		
		if (is_array($return)) {
			foreach ($return as $key => &$val) {
				if (is_string($val) AND is_array(json_decode($val, true))) {
					$val = self::getFullArray($val);
				}
				
			}
		}
		
		return $return;
	}
	
	// currying, anyone?
	public function json_mapper_norecurse($value) {
		return Json::getFullArray($value, false);
	}
	
	public function json_to_array($array, $recursive = true) {
		# if $array is not an array, let's make it array with one value of
		# former $array.
		if (!is_array($array)) {
			$array = array(
				$array
			);
		}
		
		return array_map($recursive ? 'Json::getFullArray' : 'Json::json_mapper_norecurse', $array);
	}
	
	
	private function setAsString(&$v, $k) {
		if ($v === null)
			$v = "";
		else if (!is_array($v)) {
			$v = (string) $v;
		}
	}
	
	private function setAsHtml(&$v, $k) {
		if ($v === null)
			$v = "";
		else if (!is_array($v)) {
			$v = htmlspecialchars((string) $v);
		}
	}
}


?>