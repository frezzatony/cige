<?php


/**
 * @author Tony Frezza

 */
 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(__DIR__.'/../../system/libraries/Data_core.php');
class MY_Config extends CI_Config {
    
    
    private $data;
    
    
    function __construct(){
        
        parent::__construct();
        
    }
	/**
	 * Load Config File
	 *
	 * @param	string	$file			Configuration file name
	 * @param	bool	$use_sections		Whether configuration values should be loaded into their own section
	 * @param	bool	$fail_gracefully	Whether to just return FALSE or display an error message
	 * @return	bool	TRUE if the file was loaded correctly or FALSE on failure
	 */
	public function load($file = '', $use_sections = FALSE, $fail_gracefully = FALSE){

		$file = ($file === '') ? 'config' : str_replace('.php', '', $file);
		$loaded = FALSE;

		foreach ($this->_config_paths as $path)
		{
            foreach (array($file, ENVIRONMENT.DIRECTORY_SEPARATOR.$file) as $location)
			{
				$file_path = $path.'config/'.$location.'.php';
				if (in_array($file_path, $this->is_loaded, TRUE))
				{
					return TRUE;
				}

				if ( ! file_exists($file_path))
				{
                    continue;
				}

				include($file_path);

				if ( ! isset($config) OR ! is_array($config))
				{
					if ($fail_gracefully === TRUE)
					{
						return FALSE;
					}

					show_error('Your '.$file_path.' file does not appear to contain a valid configuration array.');
				}

				if ($use_sections === TRUE)
				{
					
                    //MODIFICADO AQUI POR TONY FREZZA
                    
                    
                    $configName = explode('/',$file);
                    $configName = $configName[sizeof($configName)-1];
                    
                    $this->config[$configName] = isset($this->config[$configName])
						? array_merge($this->config[$configName], $config)
						: $config;
				}
				else
				{
					$this->config = array_merge($this->config, $config);
				}

				$this->is_loaded[] = $file_path;
				$config = NULL;
				$loaded = TRUE;
				log_message('debug', 'Config file loaded: '.$file_path);
			}
		}

		if ($loaded === TRUE)
		{
			return TRUE;
		}
		elseif ($fail_gracefully === TRUE)
		{
			return FALSE;
		}
        
		show_error('The configuration file '.$file.'.php does not exist.');
	}
    
    
    // --------------------------------------------------------------------

	/**
	 * Fetch a config file item
	 *
	 * @param	string	$item	Config item name
	 * @param	string	$index	Index name
	 * @return	string|null	The configuration item or NULL if the item doesn't exist
	 */
	public function item($item='', $index = ''){
		
        
        $name = explode('.',$item);
        
        if(sizeof($name)>1 AND $index != ''){
            
            $config = $this->config[$index] ?? NULL;
            if(!$config){
                return NULL;
            }
            
            $data = new Data_core();
            $data->set($config);
            
            return $data->get($item);
        
        }
        
        
        
        if($item==''){
            return $this->config;
        }
        if ($index == '')
		{
			return isset($this->config[$item]) ? $this->config[$item] : NULL;
		}

		return isset($this->config[$index], $this->config[$index][$item]) ? $this->config[$index][$item] : NULL;
	}
    
    
}
