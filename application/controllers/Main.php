<?php

/**
 * @author Tony Frezza
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{
    
    private $arrTemplate;
    
    function __construct(){
        
        parent::__construct();
        
        
        $this->auth_model->login();
        
        $this->arrTemplate = $this->common->getTemplate();        
        
    }
    
    function index(){           
        
        
        $this->template->load($this->arrTemplate['template'],$this->arrTemplate['path'], $this->arrTemplate['view']);
        
    }
    
    /**
     * PRIVATES
     **/
     
    private function getShowAsData($arrProp = array()){
        
        $arrReturn = array(
            'buttons_data'      => array(),
            'templates_data'    => array(),
        );
               
        $arrReturn['buttons_data'] =   array(
            'tag'       =>  'div',
            'class'     =>  array('inline-block','ged-show-as','padding-right-2'),
            'parent_id' =>  $arrProp['parent_id'],
            'children'  =>  array(),
        );
        
        //show em box
        $bootstrap = new Bootstrap;
        $bootstrap->button(
            array(
                'size'              =>  'sm',
                'class'             =>  array('ged-show-as-button','nopadding','nomargin','padding-left-3','padding-right-2'),
                'data-show'         =>  'box',
                'title'             =>  'Exibir em box',
                'icon_left'         =>  'fa fa-th',
                'icon_left_size'    =>  14,
            )
        );
        $htmlButtonList_boxType = $bootstrap->getHtmlData();
        append($arrReturn['buttons_data']['children'],
            $htmlButtonList_boxType
        );
        //fim show em box
        
        //show em lista
        $bootstrap->reset();
        $bootstrap->button(
            array(
                'size'              =>  'sm',
                'class'             =>  array('ged-show-as-button','nopadding','nomargin','padding-left-3','padding-right-2'),
                'data-show'         =>  'list',
                'title'             =>  'Exibir em lista',
                'icon_left'         =>  'fa fa-list',
                'icon_left_size'    =>  14,
            )
        );
        $htmlButtonList_boxType = $bootstrap->getHtmlData();
        append($arrReturn['buttons_data']['children'],
            $htmlButtonList_boxType
        );
        //fim show em  lista
        
        
        //template lista
        $bootstrap->reset();
        $bootstrap->grid(
            array(
                'class'     =>  array('col-lg-24','nopadding','nomargin'),
                'footer'    =>  FALSE,
                'header'    =>  array(
                    array(
                        'text'  =>  'Nome',
                        'class' =>  array(),
                        'head-col'  =>  array(
                            'lg'    =>  13
                        )
                    ),
                    array(
                        'text'  =>  'Data',
                        'class' =>  array('text-centered'),
                        'head-col'  =>  array(
                            'lg'    =>  5
                        )
                    ),
                    array(
                        'text'      =>  'Tamanho',
                        'class'     =>  array('text-centered'),
                        'head-col'  =>  array(
                            'lg'    =>  3
                        ),
                    ),
                    array(
                        'text'  =>  'Tipo',
                        'class' =>  array('text-centered'),
                        'head-col'  =>  array(
                            'lg'    =>  3
                        )
                    ),
                ),
                'columns'      =>  array(
                    1       =>  array(
                        'class' =>  array('text-right','size-11','padding-top-4'),
                    ),
                    2       =>  array(
                        'class' =>  array('text-centered','size-11','padding-top-4'),
                    ),
                    3       =>  array(
                        'class' =>  array('text-centered','size-11','padding-top-4'),
                    ),  
                )
            )
        );
        $arrReturn['templates_data'][] = array(
            'tag'       =>  'div',
            'class'     =>  array('ged-template-show-as-list','softhide'),
            'children'  =>  $bootstrap->getHtmlData(),
        );
        //fim template lista
        
        
        //template box
        $htmlBox = new Html();
        $idTemplateBox = $htmlBox->add(
            array(
                'tag'       =>  'div',
                'class'     =>  array('col-lg-1','nopadding','ged-box-file'),
                'children'  =>  array(
                    array(
                        'tag'       =>  'div',
                        'class'     =>  array('col-lg-24','nopadding','nomargin','text-centered','ged-box-file-icon','size-40'),
                    ),
                    array(
                        'tag'       =>  'div',
                        'class'     =>  array('col-lg-24','nopadding','nomargin','size-11','text-centered','ged-box-file-name'),
                        //'style'     =>  'word-wrap: break-word;',
                        'children'  =>  array(
                            array(
                                'tag'       =>  'span',
                                'class'     =>  array('file-name','file-name-box'),
                            )
                        )
                    )
                ),
            )
        );
        
        $arrReturn['templates_data'][] = array(
            'tag'       =>  'div',
            'class'     =>  array('ged-template-show-as-box','softhide'),
            'children'  =>  $htmlBox->getData(),
        );

        //fim template box
        
                
        return $arrReturn;
    }
    
    private function getBreadcrumb($arrProp = array()){
        
        $arrReturn = array(
            'tag'       =>  'div',
            'class'     =>  array('col-lg-24','nopadding','nomargin','padding-left-4','padding-right-4','bg-gray','ged-breadcrumb-box'),
            'parent_id' =>  $arrProp['parent_id'],
            'children'  =>  array()
        );
        
        
        $bootstrap = new Bootstrap;
        $bootstrap->breadcrumb(
            array(
                'class'     =>  array('ged-breacrumb'),
                'home_href' =>  '#',
                'nodes'     =>  array(
                    array(
                        'text'      =>  '1',
                        'href'      =>  '/1',
                    )
                )
            )
        );
        $htmlBreadcrumb = $bootstrap->getHtmlData();
        
        append($arrReturn['children'],
            $htmlBreadcrumb
        );
               
        return $arrReturn;
    }
    
    private function getInputSortData($arrProp = array()){
        
        $arrReturn = array(
            'tag'       =>  'div',
            'class'     =>  array('inline-block','text-right','padding-right-2'),
            'style'     =>  'width: 98px;',
            'parent_id' =>  $arrProp['parent_id'],
            'children'  =>  array(),
        );
        
        
        $arrIconsSort = array(
            'font'  =>  'fa',
            'asc'   =>  'fa-sort-amount-asc',
            'desc'  =>  'fa-sort-amount-desc',
        );
        
        $bootstrap = new Bootstrap;
        $bootstrap->button_dropdown(
            array(
                'size'          =>  'sm',
                'color'         =>  'secondary', 
                'class'         =>  array('ged-sort-menu-button','nopadding','nomargin','padding-left-3','padding-right-2'),
                'title'         =>  'Ordem de exibição',
                'menu_position' =>  'right',
                'children'      =>  array(
                    array(
                        'tag'       =>  'span',
                        'class'     =>  array('sort-title'),
                        'children'  =>  array(
                            array(
                                'tag'       =>  'i',
                                'class'     =>  array($arrIconsSort['font'],($arrIconsSort[$arrProp['sort']['dir']??'asc'])),
                            ),
                            array(
                                'text'      =>  $arrProp['sort']['column']??'Nome',
                            )
                        )  
                    )
                ),
                'nodes'         =>  array(
                    array(
                        'text'              =>  'Nome',
                        'data-sort-column'  =>  'name',
                    ),
                    array(
                        'text'              =>  'Data',
                        'data-sort-column'  =>  'date',
                    ),
                    array(
                        'text'              =>  'Tamanho',
                        'data-sort-column'  =>  'size',
                    ),
                    array(
                        'text'              =>  'Tipo',
                        'data-sort-column'  =>  'type',
                    ),
                )
            )
        );
        $htmlButtonSortFiles = $bootstrap->getHtmlData();
        
        $arrReturn['children'] = $htmlButtonSortFiles;
        
        return $arrReturn;
    }
    
    private function getButtonUploadData($arrProp = array()){
        
        $arrReturn = array(
            'parent_id'     =>  $arrProp['parent_id'],
            'children'      =>  array(),
        );
        
        $bootstrap = new Bootstrap;
        $bootstrap->button(
            array(
                'size'      =>  'sm',
                'text'      =>  'Enviar&nbsp;',
                'class'     =>  array('ged-upload-files','btn-3d'),
                'icon_left' =>  'fa fa-upload',
            )
        );
        
        $htmlButtonUpload = $bootstrap->getHtmlData();
        append($arrReturn['children'],$htmlButtonUpload);
        
        
        $bootstrap->reset();
        $bootstrap->button(
            array(
                'size'              =>  'sm',
                'class'             =>  array('ged-new-folder',' nomargin padding-left-6 padding-right-6'),
                'title'             =>  'Nova pasta',
                'icon_left'         =>  'fa fa-folder',
                'data-name'         =>  'Nova pasta',            
                'icon_left_size'    =>  16,
            )
        );
        $htmlButtonNewFolder = $bootstrap->getHtmlData();
        append($arrReturn['children'],$htmlButtonNewFolder);
        
        return $arrReturn;
    }
    
    private function getFilesScriptData($arrProp = array()){
        
        $jsonFiles = json_encode($arrProp['files'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        
        $strJavscript = '
            window[\'ged_files_'.$arrProp['parent_id'].'\'] = '.$jsonFiles.';'."\n".'
        ';
        
        $template = new Template;
        $arrReturn = array(
            'parent_id' =>  $arrProp['parent_id'],
            'text'      =>  $template->load('jquery',NULL,'Blank_view',array('javascript'=>$strJavscript),TRUE)
        );
        
        return $arrReturn;
        
    }
    
    private function tempFiles(){
        
        return array(
            array(
                'type'  =>  'path',
                'name'  =>  '1',
                'date'  =>  date('D, d M y H:i:s'),
                'size'  =>  '2400000',
                'files' =>  array(
                    array(
                        'type'  =>  'path',
                        'name'  =>  '2',
                        'date'  =>  date('D, d M y H:i:s'),
                        'size'  =>  '2400000',
                        'files' =>  array(
                            array(
                                'type'  =>  'xlsx',
                                'name'  =>  '2',
                                'date'  =>  date('D, d M y 14:50'),
                                'size'  =>  '2',
                            ),
                            array(
                                'type'  =>  'xlsx',
                                'name'  =>  '1',
                                'date'  =>  date('D, d M y 14:50'),
                                'size'  =>  '1',
                            ),
                             
                        )
                    ), 
                ), 
            ),
            array(
                'type'  =>  'path',
                'name'  =>  '2',
                'date'  =>  date('D, d M y H:i:s'),
                'size'  =>  '2400000',
                'files' =>  array(
                    array(
                        'type'  =>  'xlsx',
                        'name'  =>  '2',
                        'date'  =>  date('D, d M y 14:50'),
                        'size'  =>  '2',
                    ),
                    array(
                        'type'  =>  'xlsx',
                        'name'  =>  '1',
                        'date'  =>  date('D, d M y 14:50'),
                        'size'  =>  '1',
                    ),
                     
                )
            ),
            
            array(
                'type'  =>  'xlsx',
                'name'  =>  '2',
                'date'  =>  date('D, d M y 14:50'),
                'size'  =>  '2',
            ),
            array(
                'type'  =>  'xlsx',
                'name'  =>  '1',
                'date'  =>  date('D, d M y 14:50'),
                'size'  =>  '1',
            ),     
            
            
        );
    }
    
    
}
