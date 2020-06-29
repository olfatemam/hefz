<?php
/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

//require_once 'Models\Html\HtmlGenerator.php';

class Juzz {
    public $index;
    public $name;
    public $sura_num;
    public $aya;
    public $start;

    public function __construct($node)
    {
        $this->index = intval($node->index);
        $this->name  = $node->name->__toString();
        $this->sura_num  = intval($node->sura);
        $this->aya = intval($node->aya);
        $this->start = ($node->start);
    }
    
    public function generate_anchor($engine)
    {
        
        //$text = '<span>'.$this->id</span>'.$this->name . ':'.  $this->start;
        $id =  $engine->gen_control('div', array(new attribute('class', 'w3-col m1 w3-right')), $this->index);
        $name =  $engine->gen_control('div', array(new attribute('class', 'w3-col m4 w3-right')), $this->name);
        $start =  $engine->gen_control('div', array(new attribute('class', 'w3-col m6 w3-right')), $this->start);
        
        
        $a =  $engine->gen_control('a', array(new attribute('id', 'juz'.$this->index), 
                new attribute('class', 'w3-large '),
                new attribute('style', 'width:100%'),
                new attribute('onclick', 'goto_sura('.$this->sura_num.','. $this->aya.')')),  $id.$name.$start);
    
        return $a;
    }
}
class Juzs extends HtmlGenerator
{
    private $juzs_array = array();

    public function init_juzzs_array_from_xml()
    {
        $config = include('config/app.php');
        $root_obj = simplexml_load_file($config['app_root'].'/data/juz_data.xml');
        
        foreach($root_obj as $node )
        {
            $this->juzs_array[]= new Juzz($node->attributes());
        }
    }

    public function generate_ul_list()
    {
        $this->init_juzzs_array_from_xml();
        
        $menu ='<ul class="w3-ul w3-card-4 w3-right w3-right-align">';
        
        foreach($this->juzs_array as $juzz)
        {
            $menu .="<li class='w3-right w3-bar' style='width:100%'>". $juzz->generate_anchor($this).'</li>';
        }
        $menu .='</ul>';
        return $menu;
    }  
}
