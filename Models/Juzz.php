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
    
    public function generate_table_row($engine)
    {
        
        //$classes=['w3-col m1', 'w3-col m1', 'w3-col m1', 'w3-col m1', 'w3-col m8'];
        $row='<tr onclick="goto_sura('.$this->sura_num. ','. $this->aya. ')">';
        
        $row.=  $engine->gen_control('td', array(new attribute('class', 'w3-right w3-right-align w3-col m1')), $this->index);

        $row.=  $engine->gen_control('td', array(new attribute('class', 'w3-right w3-right-align w3-col m2')), $this->name);
        $row.=  $engine->gen_control('td', array(new attribute('class', 'w3-right w3-right-align w3-col m2')), $this->sura_num);
        
        $row.=  $engine->gen_control('td', array(new attribute('class', 'w3-right-align w3-right w3-col m1')), $this->aya);
        $row.=  $engine->gen_control('td', array(new attribute('class', 'w3-large  w3-right w3-right-align w3-col m6')), $this->start);
        $row.="</tr>";
        
        
        return $row;
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

    public function generate_table()
    {
        $this->init_juzzs_array_from_xml();
        $header=['جزء', 'سورة','رقم السورة','آية','بداية الجزء'];
        
        $classes=['w3-col m1', 'w3-col m2', 'w3-col m2', 'w3-col m1', 'w3-col m6'];
        
//$menu ='<ul class="w3-ul  -align" style="width:100%">';
        $table ='<style>.pane {display: inline-block;overflow-y: scroll;max-height:850px;width:100%;}</style>'
                . '<div class="pane" >'
                . '<table '
                . ' class="w3-table w3-table-all w3-right-align w3-right w3-hoverable" '
                . ' style="width:100%;"><tbody>';
        
        $row='<tr class="w3-right w3-right-align" style="width:100%">';
        
        foreach($header as $key=>$celltext)
        {
            $row .= '<th class="w3-right w3-right-align '.$classes[$key].' ">'.$celltext.'</th>';
        }
        $row .='</tr>';
        
        $table .=$row;
        
        foreach($this->juzs_array as $juzz)
        {
            $table .=$juzz->generate_table_row($this);
        }
        $table .='</table></div></tbody>';
        return $table;
    }  
}
