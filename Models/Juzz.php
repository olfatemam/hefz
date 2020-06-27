<?php
/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

require_once 'Models\Html\HtmlGenerator.php';

class Juzz {
    public $index;
    public $name;
    public $sura_num;
    public $aya;

    public function __construct($node)
    {
        $this->index = intval($node->index);
        $this->name  = $node->name->__toString();
        $this->sura_num  = intval($node->sura);
        $this->aya = intval($node->aya);
    }
    
    public function gen_juzz_html($engine, $souras_obj, $nextsura, $nextaya)
    {
        
        $input= $engine->gen_control('input', 
                array(
                new attribute('id', 'jac-'.$this->index), 
                new attribute('name', 'jac-'.$this->index),
                new attribute('class', 'ac-input'),
                new attribute('type', 'checkbox'),
                new attribute('onclick', '')), '');
        
        $label= $engine->gen_control('label', 
                array(
                new attribute('for', 'jac-'.$this->index),
                new attribute('class', 'ac-label')), $this->name);
        
        $article = $engine->gen_control('article', array(new attribute('class', 'ac-text')), '');
        
        $buffer =  $engine->gen_control('div', array(new attribute('class', 'ac')), $input.$label.$article); 
        //$souras_obj get all suras in this juzz
        return $buffer;
    }

    public function gen_juzz_html0($htmlgen)
    {
        return $htmlgen->gen_control('a', array(new attribute('id', 'juz'.$this->index), 
                new attribute('href', 'javascript:void(0)'),
                new attribute('onclick', 'goto_sura('.$this->sura_num.','.$this->aya.')')),$this->index);
    

    }
    
}
class juzs extends HtmlGenerator
{
    private $juzs_array = array();

    public function read_from_xml()
    {
        $root_obj = simplexml_load_file('data/juz_data.xml');
        foreach($root_obj as $node )
        {
            $this->juzs_array[]= new Juzz($node->attributes());
        }
    }

    public function create_menu()
    {
        $this->read_from_xml();
        $souras_obj = new suras();
        $menu ='<li class="dropdown" style="float:right;">'.
                 '<a href="javascript:void(0)" class="dropbtn" onclick=show_menu("juzz_menu_div")>Goto Juzz</a>'.
                 '<div id="juzz_menu_div" class="dropdown-content">';
        $nextaya=0;
        $nextsura=0;
        $nJuzzs = count($this->juzs_array);
        for($i=0; $i<$nJuzzs;$i++ )
        {
            if(($i+1) < $nJuzzs)
            {
                $nextsura = $this->juzs_array[$i+1]->sura_num;
                $nextaya = $this->juzs_array[$i+1]->aya;
            }
            $menu .=$this->juzs_array[$i]->gen_juzz_html($this, $souras_obj, $nextsura, $nextsura);
        }
        $menu .= '</div></li>';
        
        return $menu;
    }  
}
