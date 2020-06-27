<?php


/**
 * Description of Page
 *
 * @author Olfat.Emam
 */

require_once 'Border.php';
require_once 'Verse.php';
require_once 'Tafseer.php';
function compare_chapter_boxes($sura_border1, $sura_border2)
{
    return ( $sura_border1->get_bottom() > $sura_border2->get_bottom());
}

function compare_verses($verse1, $verse2)
{
    $x1 = doubleval($verse1->get_cx());
    $y1 = doubleval($verse1->get_cy());
    $x2 = doubleval($verse2->get_cx());
    $y2 = doubleval($verse2->get_cy());

    if (abs($y2-$y1)<10) //same line
    {
        return (($x2-$x1)>0);
    }
    else
        return (($y1-$y2)>0);
}

class Page {
    //put your code here

    private $index;
    private $n_Verses;
    private $available_number_of_verses;

    public $left;
    public $top;
    public $right;
    public $bottom;

    private $verse_mark_array;

    public $sura_burder_array;

    public function __construct()
    {
        $this->index=0;
        $this->n_Verses=0;
        $this->available_number_of_verses=0;
        $this->left=0;
        $this->top=0;
        $this->right=0;
        $this->bottom=0;
        $this->sura_burder_array=array();
    }

    public function reorder_sura_boxes()
    {
        usort($this->sura_burder_array, "compare_chapter_boxes");
    }

    public function enumerate_chapters_indexes($chpter_index)
    {
        foreach($this->sura_burder_array as $key=>$obj)
        {
            $chpter_index= $obj->enumerate_chapters_indexes($chpter_index);
        }
        return $chpter_index;
    }

    public function reorder_verses()
    {
        usort($this->verse_mark_array, "compare_verses");//$sorted_verses=Array();
        //print_r($this->verse_mark_array);
    }

    public function echo_me()
    {
        echo '<br>index='. $this->index.'<br>';
        echo 'n_Verses='. $this->n_Verses.'<br>';
        echo 'available_number_of_verses'. $this->available_number_of_verses.'<br>';
        echo 'left='. $this->left.'<br>';
        echo 'top='. $this->top.'<br>';
        echo 'right='. $this->right.'<br>';
        echo 'bottom='. $this->bottom.'<br>';

        foreach($this->verse_mark_array as $Verse)
        {
            $Verse->echo_me();
        }
        foreach($this->sura_burder_array as $border)
        {
            $border->echo_me();
        }

    }

    public function save2_page_to_final_xml($pagesxml, $tafseer)
    {
        $config = include('config/app.php');
    
        $tafseer = $config['app_folder'].'/data/tafseer/'.$tafseer;
        $tafsseerobj = new Tafseer(null);
        
        $pagexml = $pagesxml->addChild('page');
        $pagexml->addAttribute ('index', $this->index );
        $pagexml->addAttribute ('ttl', $this->n_Verses );

        $pagexml->addAttribute ('left', $this->left );
        $pagexml->addAttribute ('top', $this->top );
        $pagexml->addAttribute ('right', $this->right );
        $pagexml->addAttribute ('bottom', $this->bottom );


        $sbordersxml = $pagexml->addChild('sborders');

        foreach($this->sura_burder_array as $obj)
        {
            $obj->save_border_to_xml($sbordersxml);
        }

        $versesxml = $pagexml->addChild('verses');
        foreach($this->verse_mark_array as $obj)
        {
            $obj->set_tafseer($tafsseerobj->get_aya_text($tafseer, $obj->get_chapter_number(), $obj->get_verse_number()));
            $obj->save_verse_to_xml($versesxml);
        }

        return $pagexml;
    }

    public function save_page_to_final_xml()
    {
        $pagexml = new SimpleXMLElement( '<page/>' );;

        $pagexml->addAttribute ('index', $this->index );
        $pagexml->addAttribute ('ttl', $this->n_Verses );

        $pagexml->addAttribute ('left', $this->left );
        $pagexml->addAttribute ('top', $this->top );
        $pagexml->addAttribute ('right', $this->right );
        $pagexml->addAttribute ('bottom', $this->bottom );


        $sbordersxml = $pagexml->addChild('sborders');

        foreach($this->sura_burder_array as $obj)
        {
            $obj->save_border_to_xml($sbordersxml);
        }

        $versesxml = $pagexml->addChild('verses');
        foreach($this->verse_mark_array as $obj)
        {
            $obj->save_verse_to_xml($versesxml);
        }

        return $pagexml;
    }

    public function read_page_from_final_xml($pagexml)
    {
        //$pagexml = $mainpagexml->page;
        $page_attributes = $pagexml->attributes();
        //var_dump($pagexml);
        $this->index        = intval(htmlentities($page_attributes->index));
        $this->n_Verses     = intval(htmlentities($page_attributes->ttl));
        $this->left         = doubleval(htmlentities($page_attributes->left));
        $this->top          = doubleval(htmlentities($page_attributes->top));
        $this->right        = doubleval(htmlentities($page_attributes->right));
        $this->bottom       = doubleval(htmlentities($page_attributes->bottom));

        if($pagexml && $pagexml->sborders )
        foreach($pagexml->sborders->children() as $obj)
        {
            $sura_border_obj = new Border();
            $sura_border_obj->read_border_from_xml($obj);
            $this->sura_burder_array[]= $sura_border_obj;
        }
        if($pagexml && $pagexml->verses)
        foreach($pagexml->verses->children() as $obj)
        {
            $verse_mark_obj = new Verse(0,0,0,0,0,0, '');
            $verse_mark_obj->read_verse_from_xml($obj);
            $this->verse_mark_array[]= $verse_mark_obj;
        }
    }

    public function add_chapter_info($chapter_number,$begin_verse, $end_verse)
    {
        //$this->available_number_of_verses = $this->n_Verses;
        $count=0;
        $verse_num=$begin_verse;
        foreach ($this->verse_mark_array as $Verse)
        {
            if( $Verse->get_chapter_number()>0 )continue;
            if( $this->available_number_of_verses==0)break;
            if($verse_num > $end_verse)break;

            $Verse->set_chapter_number($chapter_number);
            $Verse->set_verse_number($verse_num);
            $verse_num++;
            $this->available_number_of_verses--;
        }
    }

    public function get_index(){return $this->index;}
    public function set_index($index){$this->index=$index;}


    public function get_available_number_of_verses(){return $this->available_number_of_verses;}
    public function get_number_of_verses(){return $this->n_Verses;}
    public function set_available_number_of_verses($num){$this->available_number_of_verses=$num;}
    public function set_number_of_verses($n){$this->n_Verses=$n;}

    //setup generation function
    public function read_from_svg_generated_page_xml($page_xml_file, $page_num)
    {
        $root_obj = simplexml_load_file($page_xml_file);
        $this->index=$page_num;
        $this->verse_mark_array=array();
        $this->sura_burder_array = array();
        foreach($root_obj->border as $border)
        {

            $this->left  = htmlentities($border->attributes()->left);
            $this->top  = htmlentities($border->attributes()->top);
            $this->right  = htmlentities($border->attributes()->right);
            $this->bottom  = htmlentities($border->attributes()->bottom);
            break;
        }
        foreach($root_obj->sborders as $sborders) {
            foreach ($sborders->sborder as $key2 => $sborder) {
                $sb = new Border();
                $sb->set_left(htmlentities($sborder->attributes()->left));
                $sb->set_top(htmlentities($sborder->attributes()->top));
                $sb->set_right(htmlentities($sborder->attributes()->right));
                $sb->set_bottom(htmlentities($sborder->attributes()->bottom));
                $this->sura_burder_array[] = $sb;
            }
        }
        foreach($root_obj->verses as $obj)
        {
            foreach ($obj->verse as $obj1 => $value)
            {
                $verse_obj = new Verse(0,
                                            0,
                                            doubleval(htmlentities($value->cx)),
                                            doubleval(htmlentities($value->cy)),
                                            doubleval(htmlentities($value->r)), '');

                $this->verse_mark_array[] = $verse_obj;
            }
        }
        foreach ($root_obj->totalverses as $value)
        {
            $this->n_Verses= intval(htmlentities($value));
            $this->available_number_of_verses=$this->n_Verses;
            break;
        }
    }
}

