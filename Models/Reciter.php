<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */


require_once 'Models/Html/HtmlGenerator.php';

class Reciter
{
    public $index;   
    public $ename;
    public $aname;
    public $audiopath;
    
    
    public function __construct($node)
    {
        $this->index = intval($node->index);
        $this->ename  = $node->ename->__toString();
        $this->aname  = $node->aname->__toString();
        $this->audiopath = $node->audiopath->__toString();
    }

}

class reciters extends HtmlGenerator
{
    private $reciters_info = array();

    private function read_reciters_xml()
    {
        $root_obj = simplexml_load_file('data/reciters.xml');
        foreach($root_obj as $node )
        {
            $this->reciters_info[intval($node->attributes()->index)]= new Reciter($node->attributes());
        }
    }
    
    public function create_list()
    {
        $this->read_reciters_xml();

        $options='';
        foreach($this->reciters_info as $reciterobj)
        {    
            $options= $options . $this->gen_control('option', array(new attribute('value', $reciterobj->index),
                                                                    new attribute('audiopath', $reciterobj->audiopath)), 
                                                                    $reciterobj->ename);
        }
       
       $combo =  $this->gen_control('select', array(new attribute('name', 'reciters'),
                                                        new attribute('class', 'w3-select'),
                                                        new attribute('id', 'reciter'),
                                                        //new attribute('dir', 'rtl')
                                                        ), $options); 
        return $combo ;
    }  
   //construct here the combo box 
}