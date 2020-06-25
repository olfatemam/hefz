<?php

require_once 'html_generator.php';

class tafseer_info {

    public $tafsser_tree=array();

    public $index;   
    public $ename;
    public $aname;
    public $filepath;
    public $language;
    
    public function __construct($node)
    {
        $this->index = 0;
        $this->ename  = '';
        $this->aname  = '';
        $this->language= '';
        $this->filepath= '';
        if($node)
        {
            $this->index = intval($node->index);
            $this->ename  = $node->ename->__toString();
            $this->aname  = $node->aname->__toString();
            $this->language= $node->language->__toString();
            $this->filepath= $node->filepath->__toString();
        }
    }

    public function get_sura_tafseer($filepath, $sura_num)
    {
        $this->filepath=$filepath;
        
        $quran_txt = simplexml_load_file($filepath);
        $sura = $quran_txt->sura[$sura_num-1];
        if($sura)
        {
            foreach ($sura->aya as $aya)
            {
                $this->add_aya_text(intval($sura->attributes()->index), 
                        intval($aya['index']), 
                        strval($aya['text'])
                        );
            }
        }        
        }
    public function get_aya_text($filepath, $sura, $aya)
    {
        if(!array_key_exists($sura, $this->tafsser_tree))
        {
            $this->get_sura_tafseer($filepath, $sura);
        }
        
        $buf = $this->tafsser_tree[$sura][$aya];
       
        //echo $buf;
        //echo '<br>******************************<br>';
        return $buf;
    }

    public function add_aya_text($sura, $aya, $text)
    {
        if(!array_key_exists($sura, $this->tafsser_tree))
        {
            $this->tafsser_tree[$sura] = array($aya=>$text);
        }
        else 
        {
            $this->tafsser_tree[$sura][$aya]=$text;
        }
        return;
    }
}

class tafseers extends html_generator
{
    private $tafseers_info = array();

    private function read_tafseers_xml()
    {
        $root_obj = simplexml_load_file('data/tafseers.xml');
        foreach($root_obj as $node )
        {
            $this->tafseers_info[intval($node->attributes()->index)]= new tafseer_info($node->attributes());
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

        $combo =  $this->gen_control('select', array(new attribute('name', 'tafseers'),
                                                        new attribute('id', 'tafseer'),
                                                        new attribute('dir', 'rtl')), $options); 
        
        return $combo ;
    }  
   //construct here the combo box 
}   

//header('Content-Type: text/html; charset=utf-8');
//$obj = new tafseer_info('../data/fafseer/ar.jalalayn.xml', 1);
//print_r($obj->tafsser_tree);

/*
/*$obj->get_aya_text(1, 1);
$obj->get_aya_text(1, 2);
$obj->get_aya_text(1, 3);
$obj->get_aya_text(1, 4);
$obj->get_aya_text(1, 5);
$obj->get_aya_text(1, 6);
*/