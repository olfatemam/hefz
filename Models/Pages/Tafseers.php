<?php

require_once 'Models\Html\HtmlGenerator.php';
require_once 'Models\Tafseer.php';


class Tafseers extends HtmlGenerator
{
    private $tafseers_info = array();

    private function read_tafseers_xml()
    {
        $settings = include('config/app.php');        
        
        $t_file=$settings['app_root'].'/data/Tafseers.xml';
        
        $root_obj = simplexml_load_file($t_file);
        foreach($root_obj as $node )
        {
            $this->tafseers_info[intval($node->attributes()->index)]= new Tafseer($node->attributes());
        }
    }

    public function create_list()
    {
        $this->read_tafseers_xml();

        $options='';
        foreach($this->tafseers_info as $tafseerobj)
        {    
            $options= $options . $this->gen_control('option', 
                    array(new attribute('value', $tafseerobj->index),new attribute('filepath', $tafseerobj->filepath)),$tafseerobj->aname);
        }

        $combo =  $this->gen_control('select', array(new attribute('name', 'Tafseers'),
                                                        new attribute('id', 'tafseer'),
                                                        new attribute('class', 'w3-select w3-border'),
                                                        new attribute('style', 'width:100%'),
                                                        //new attribute('dir', 'rtl')
                                                        ), $options); 
        
        return $combo ;
    }  
   //construct here the combo box 
}   

//header('Content-Type: text/html; charset=utf-8');
//$obj = new Tafseer('../data/fafseer/ar.jalalayn.xml', 1);
//print_r($obj->tafsser_tree);

/*
/*$obj->get_aya_text(1, 1);
$obj->get_aya_text(1, 2);
$obj->get_aya_text(1, 3);
$obj->get_aya_text(1, 4);
$obj->get_aya_text(1, 5);
$obj->get_aya_text(1, 6);
*/