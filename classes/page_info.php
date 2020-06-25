<?php
/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */
require_once 'tafseer_info.php';

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


class verse_mark
{
    public function __construct($chapterNo, $verseNo, $cx, $cy, $r, $trans)
    {
        $this->chapterNo    =   $chapterNo;
        $this->verseNo      =   $verseNo;
        $this->cx           =   $cx;
        $this->cy           =   $cy;
        $this->r            =   $r;
        $this->trans        =   $trans;
    }

    public function save_verse_to_xml($pagexml)
    {
        $versexml = $pagexml->addChild( 'verse' );

        $versexml->addAttribute ('sura', $this->chapterNo);
        $versexml->addAttribute ('aya', $this->verseNo);
        $versexml->addAttribute ('cx', $this->cx);
        $versexml->addAttribute ('cy', $this->cy);
        $versexml->addAttribute ('r', $this->r);
        $versexml->addAttribute ('trans', $this->trans);
   }

    public function read_verse_from_xml($pagexml)
    {
        //foreach ($pagexml->children() as $child) {
         //   $z = $child->attributes();
            foreach ($pagexml->attributes() as $a => $b) {
                $a = htmlentities($a);
                $b = htmlentities($b);

                if ($a == 'sura') $this->chapterNo = intval($b);
                if ($a == 'aya') $this->verseNo = intval($b);
                if ($a == 'cx') $this->cx = doubleval($b);
                if ($a == 'cy') $this->cy = doubleval($b);
                if ($a == 'r') $this->r = doubleval($b);
            }
        //}
    }

    public function get_tafseer(){return $this->trans;}
    public function set_tafseer($trans){$this->trans=$trans;}
    
    public function get_verse_number(){return $this->verseNo;}
    public function get_chapter_number(){return $this->chapterNo;}

    public function get_cx(){return $this->cx;}
    public function get_cy(){return $this->cy;}
    public function get_r(){return $this->r;}

    public function set_verse_number($verseNo){$this->verseNo=intval($verseNo);}
    public function set_chapter_number($chapterNo){$this->chapterNo=intval($chapterNo);}

    public function set_cx($cx){$this->cx=doubleval($cx);}
    public function set_cy($cy){$this->cy=doubleval($cy);}
    public function set_r($r){$this->r=doubleval($r);}

public function echo_me()
{
    echo 'chapterNo'. $this->chapterNo.'<br/>';
    echo 'verseNo'. $this->verseNo.'<br/>';
    echo 'cx'. $this->cx.'<br/>';
    echo 'cy'. $this->cy.'<br/>';
    echo 'r'. $this->r.'<br/>';
}

private $chapterNo;
private $verseNo;
private $cx;
private $cy;
private $r;
private $trans;
}
class sura_border
{
    private $left;
    private $top;
    private $right;
    private $bottom;
    private $index;

    public function enumerate_chapters_indexes($sura_index)
    {
        $sura_index++;
        $this->index=$sura_index;
        return $sura_index;
    }

    public function save_border_to_xml($pagexml)
    {
        $versexml = $pagexml->addChild( 'sborder' );

        $versexml->addAttribute ('index', $this->get_index());
        $versexml->addAttribute ('left', $this->get_left());
        $versexml->addAttribute ('top', $this->get_top());
        $versexml->addAttribute ('right', $this->get_right());
        $versexml->addAttribute ('bottom', $this->get_bottom());
    }

    public function read_border_from_xml($pagebordersxml)
    {
        //foreach ($pagebordersxml->children() as $child) {
          //  $z = $child->attributes();
            //$z->index
            foreach ($pagebordersxml->attributes() as $a => $b)
            {
                $a = htmlentities($a);
                $b = htmlentities($b);

                if ($a == 'index') $this->set_index(intval($b));
                if ($a == 'left') $this->set_left(doubleval($b));
                if ($a == 'top') $this->set_top(doubleval($b));
                if ($a == 'right') $this->set_right(doubleval($b));
                if ($a == 'bottom') $this->set_bottom(doubleval($b));
            }
        //}
    }

    public function echo_me()
    {
        echo 'chapterNo'. $this->index.'<br/>';
        echo 'left'  . $this->left .'<br/>';
        echo 'top'   . $this->top .'<br/>';
        echo 'right' . $this->right .'<br/>';
        echo 'bottom'. $this->bottom .'<br/>';
    }

    public function get_index(){return $this->index;}
    public function set_index($index){$this->index=intval($index);}


    public function get_left(){return $this->left;}
    public function get_top(){return $this->top;}
    public function get_right(){return $this->right;}
    public function get_bottom(){return $this->bottom;}


    public function set_left($left){$this->left=doubleval($left);}
    public function set_top($top){$this->top=doubleval($top);}
    public function set_right($right){$this->right=doubleval($right);}
    public function set_bottom($bottom){$this->bottom=doubleval($bottom);}
}

class page_info
{
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
        echo 'index='. $this->index.'<br/>';
        echo 'n_Verses='. $this->n_Verses.'<br/>';
        echo 'available_number_of_verses'. $this->available_number_of_verses.'<br/>';
        echo 'left='. $this->left.'<br/>';
        echo 'top='. $this->top.'<br/>';
        echo 'right='. $this->right.'<br/>';
        echo 'bottom='. $this->bottom.'<br/>';

        foreach($this->verse_mark_array as $verse_mark)
        {
            $verse_mark->echo_me();
        }
        foreach($this->sura_burder_array as $border)
        {
            $border->echo_me();
        }

    }

    public function save2_page_to_final_xml($pagesxml, $tafseer)
    {
        //
        $tafsseerobj = new tafseer_info(null);
        
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

        $this->index        = intval(htmlentities($page_attributes->index));
        $this->n_Verses     = intval(htmlentities($page_attributes->ttl));
        $this->left         = doubleval(htmlentities($page_attributes->left));
        $this->top          = doubleval(htmlentities($page_attributes->top));
        $this->right        = doubleval(htmlentities($page_attributes->right));
        $this->bottom       = doubleval(htmlentities($page_attributes->bottom));


        foreach($pagexml->sborders->children() as $obj)
        {
            $sura_border_obj = new sura_border();
            $sura_border_obj->read_border_from_xml($obj);
            $this->sura_burder_array[]= $sura_border_obj;
        }

        foreach($pagexml->verses->children() as $obj)
        {
            $verse_mark_obj = new verse_mark(0,0,0,0,0,0, '');
            $verse_mark_obj->read_verse_from_xml($obj);
            $this->verse_mark_array[]= $verse_mark_obj;
        }
    }

    public function add_chapter_info($chapter_number,$begin_verse, $end_verse)
    {
        //$this->available_number_of_verses = $this->n_Verses;
        $count=0;
        $verse_num=$begin_verse;
        foreach ($this->verse_mark_array as $verse_mark)
        {
            if( $verse_mark->get_chapter_number()>0 )continue;
            if( $this->available_number_of_verses==0)break;
            if($verse_num > $end_verse)break;

            $verse_mark->set_chapter_number($chapter_number);
            $verse_mark->set_verse_number($verse_num);
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
                $sb = new sura_border();
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
                $verse_obj = new verse_mark(0,
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

class pages
{
    private $pages_info = array();

    public function print_data()
    {
        print_r($this->pages_info);
    }
//setup function
    public function save_final_pages_xml_files($path)
    {
        foreach($this->pages_info as $key=>$obj)
        {
            $page_xml_file= $path.str_pad($key, 3, '0', STR_PAD_LEFT).'.xml';
            $xml_file = $obj->save_page_to_final_xml();
            $xml_file->asXML($page_xml_file);
        }
    }

    public function reorder_sura_boxes()
    {
        foreach($this->pages_info as $key=>$obj)
        {
            $obj->reorder_sura_boxes();
        }
    }

    public function enumerate_chapters_indexes()
    {
        $chpter_index=0;
        foreach($this->pages_info as $key=>$obj)
        {
            $chpter_index= $obj->enumerate_chapters_indexes($chpter_index);
        }
        echo '$total chapters count is = '.$chpter_index;
    }

    public function reorder_verses()
    {
        foreach($this->pages_info as $key=>$obj)
        {
            $obj->reorder_verses();
        }
    }
    public function read_final_pages_from_xml_files($rootpath)
    {
        for ($page_num = 1; $page_num <= 604; $page_num++)
        {
            $this->get_final_page_by_number($rootpath, $page_num);
        }
    }

public function get_inital_page_by_number($rootpath, $page_num)
{
    return $this->get_final_page_by_number($rootpath, $page_num);
}

    public function get_final_page_by_number($rootpath, $page_num)
    {
        if ( array_key_exists($page_num, $this->pages_info))
            return $this->pages_info[$page_num];

        $page_xml_file= $rootpath.str_pad($page_num, 3, '0', STR_PAD_LEFT).'.xml';
        $xml_file = simplexml_load_file($page_xml_file);
        $page_obj  = new page_info();
        $page_obj->read_page_from_final_xml($xml_file);
        $this->pages_info[$page_obj->get_index()] = $page_obj;
        return $page_obj;
    }

    public function get_final_page_info($rootpath, $page_num)
    {
        return get_final_page_by_number($rootpath, $page_num);
    }

    public function get_inital_page_info($rootpath, $page_num)
    {
        return get_inital_page_by_number($rootpath, $page_num);
    }


    public function read_from_svg_generated_pages_xml($rootpath)
    {
        for ($page_num = 1; $page_num <= 604; $page_num++)
        {
            $page_xml_file= $rootpath.str_pad($page_num, 3, '0', STR_PAD_LEFT).'.xml';
            $page_obj = new page_info();
            $page_obj->read_from_svg_generated_page_xml($page_xml_file, $page_num);
            $this->pages_info[$page_num] = $page_obj;
        }
    }
}
?>
