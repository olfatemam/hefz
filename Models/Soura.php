<?php
/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

require_once 'Models/Html/HtmlGenerator.php';

class Soura
{
    public $index;
    public $type;
    public $rukus;
    public $order;
    public $ename;
    public $tname;
    public $name;
    public $start;
    public $ayas;

    public function __construct($node)
    {
        $this->index = intval($node->index);
        $this->rukus = intval($node->rukus);
        $this->order = intval($node->order);
        $this->start = intval($node->start);
        $this->ayas  = intval($node->ayas);
        $this->name  = $node->name->__toString();
        $this->type  = $node->type->__toString();
        $this->ename = $node->ename->__toString();
        $this->tname = $node->tname->__toString();
    }
    public function gen_as_div($engine)
    {
        //$buf = '<div class="ac-sub">';
        
        $input= $engine->gen_control('input', 
                array(
                new attribute('id', 'ac-'.$this->index), 
                new attribute('name', 'ac-'.$this->index),
                new attribute('class', 'ac-input'),
                new attribute('type', 'checkbox'),
                new attribute('onclick', 'goto_sura('.$this->index.', 1)')), '');
        
        $label= $engine->gen_control('label', 
                array(
                new attribute('for', 'ac-'.$this->index),
                new attribute('class', 'ac-label')), $this->name);
        
        $article = $engine->gen_control('article', array(new attribute('class', 'ac-sub-text')), '<p> Sura Description.</p>');
        
        return $engine->gen_control('div', 
                array(
                new attribute('class', 'ac-sub')), $input.$label.$article); 
        
    }
            
        
    public function gen_html($engine)
    {
        return $engine->gen_control('a', array(new attribute('id', 'sura'.$this->index), 
                new attribute('href', 'javascript:void(0)'),
                new attribute('onclick', 'goto_sura('.$this->index.', 1)')), $this->name);
    }
}

class suras extends HtmlGenerator
{
    private $suras_info=array();

    public function get_sura_by_index($sura_index)
    {
        return $this->suras_info[$sura_index];
    }

    public function read_quran_sura_xml($quran_data_file)
    {
        $root_obj = simplexml_load_file($quran_data_file);
        foreach($root_obj->suras as $node1 )
        {
            foreach($node1 as $node )
            {
                $this->suras_info[intval($node->attributes()->index)]= new Soura($node->attributes());
            }
        }
    }
/*   //construct here the combo box 
    private function form_attr($prop, $val)
    {
        $combind =  ' '. $prop.'="' .$val.'" ';
        return $combind;
    }
  */  

    public function create_menu()
    {
        $this->read_quran_sura_xml('data/quran-data.xml');

        $menu ='<li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn" onclick=show_menu("sura_menu_div")>Goto Surah</a>
                <div id="sura_menu_div" class="dropdown-content">';
        
        foreach($this->suras_info as $suraobj)
        {
            $sura = $suraobj->gen_html($this);
            $menu .= $sura;
        }
        $menu .= '</div></li>';
        return $menu;
    }  
    public function create_list()
    {
        $this->read_quran_sura_xml('data/quran-data.xml');

        $options='';
        foreach($this->suras_info as $suraobj)
        {    
            
            $options = $options . $this->gen_control('option', array(new attribute('value', $suraobj->index),
                                                                    new attribute('Verses', $suraobj->ayas)), 
                                                                    $suraobj->name. '-' . $suraobj->ename);
        }
        
       $combo =  $this->gen_control('select', array(new attribute('name', 'soura'),
                                                        new attribute('id', 'soura'),
                                                        new attribute('dir', 'rtl')), $options); 
        
        return $combo ;
    }  
}
?>
