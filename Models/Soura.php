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
            
        
    public function generate_list_item($engine)
    {
        $span1 =  $engine->gen_control('p', array(new attribute('class', '')),$this->index);
        $span2 =  $engine->gen_control('p', array(new attribute('class', '')),$this->name);
        
                
        $a =  $engine->gen_control('a', array(new attribute('id', 'sura'.$this->index), 
                
                new attribute('class', 'w3-large w3-center'),
                new attribute('style', 'padding-left:0;padding-right:0;width:100%'),
                new attribute('onclick', 'goto_sura('.$this->index.', 1)')), $span1.$span2);
    
        return "<li class='w3-col m4 l3 s4 w3-border w3-center w3-right' style='padding-left:0;padding-right:0'>".$a."</li>";
    }
}

class Suras extends HtmlGenerator
{
    private $Suras_info=array();
    
public function __construct() {
    
    $this->Suras_info=array();
    
    $config = include('config/app.php');
    
    $this->read_quran_sura_xml($config['app_root'].'/data/quran-data.xml');
}
    public function get_sura_by_index($sura_index)
    {
        return $this->Suras_info[$sura_index];
    }

    public function read_quran_sura_xml($quran_data_file)
    {
        $root_obj = simplexml_load_file($quran_data_file);
        
        foreach($root_obj->suras as $node1 )
        {
            foreach($node1 as $node )
            {
                $this->Suras_info[intval($node->attributes()->index)]= new Soura($node->attributes());
            }
        }
    }
    
    public function generate_ul_list()
    {
        $ul = '<ul class="w3-ul" style="width:100%;height: 850px;overflow-y: scroll; ">';
        
        foreach($this->Suras_info as $suraobj)
        {
            $sura = $suraobj->generate_list_item($this);
            $ul .= $sura;
        }
        $ul .='</ul>';
        
        return $ul;
    }  
    
    
    public function create_menu()
    {
        
        
    $menu = '<div class="q_menu_dropdown w3-dropdown-hover">'
        . '<button class="w3-button ">Goto Soura</button>'
        . '<div class="q_menu_content w3-dropdown-content w3-card-4 w3-padding" style="width:50%">'
        . '<ul class="w3-ul " >';

//$menu.='</div></div>';

        foreach($this->Suras_info as $suraobj)
        {
            $sura = $suraobj->gen_html($this);
            $menu .= $sura;
        }
        $menu .='</ul></div></div>';
        return $menu;
    }  
    public function create_list()
    {
        $options='';
        foreach($this->Suras_info as $suraobj)
        {    
            
            $options = $options . $this->gen_control('option', array(new attribute('value', $suraobj->index),
                                                                    new attribute('Verses', $suraobj->ayas)), 
                                                                    $suraobj->name. '-' . $suraobj->ename);
        }
        
       $combo =  $this->gen_control('select', array(new attribute('name', 'soura'),
                                                        new attribute('class', 'w3-select w3-border'),
                                                        new attribute('id', 'soura'),
                                                        //new attribute('dir', 'rtl')
           ), $options); 
        
        return $combo ;
    }  
}
?>
