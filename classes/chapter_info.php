<?php
/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

function reset_Log_file($msg)
{
    //file_put_contents("log.html", $msg);
    //file_put_contents("log.html", "\r\n****************************************************************************\r\n", FILE_APPEND);
}

function Log_to_file($msg)
{
    //file_put_contents("log.html", "\r\n****************************************************************************\r\n", FILE_APPEND);
    //file_put_contents("log.html", $msg, FILE_APPEND);
}

class CPageInfo
{
    private $page_num;
    private $begin_verse;
    private $end_verse;

    public function __construct($page_num, $begin_verse, $end_verse)
    {
        $this->page_num = $page_num;
        $this->end_verse = $end_verse;
        $this->begin_verse = $begin_verse;
    }

    public function get_page_number(){return $this->page_num;}
    public function get_begin_verse(){return $this->begin_verse;}
    public function get_end_verse(){return $this->end_verse;}

    public function set_page_number($page_num){$this->page_num=$page_num;}
    public function set_begin_verse($begin_verse){$this->begin_verse=$begin_verse;}
    public function set_end_verse($end_verse){$this->end_verse=$end_verse;}


    public function add_page_to_xml($pages)
    {
        $page = $pages->addChild( 'page' );
        $page->addChild( 'page_num', $this->page_num );
        $page->addChild( 'begin_verse', $this->begin_verse );
        $page->addChild( 'end_verse', $this->end_verse );
    }

    public function read_page_xml($page)
    {
        //Log_to_file(print_r($page,true));
        $this->set_page_number( htmlentities($page->page_num));
        $this->set_begin_verse( htmlentities($page->begin_verse));
        $this->set_end_verse( htmlentities($page->end_verse) );
    }

    public function log_me()
    {
        Log_to_file(' page number:'.$this->get_page_number()."<br/>");
        Log_to_file(' begin verse:'.$this->get_begin_verse()."<br/>");
        Log_to_file(' end verse:'.$this->get_end_verse()."<br/>");
    }

    public function get_info_text($chapter)
    {
        return $this->get_page_number().'#'.$chapter.'#'.$this->get_begin_verse().'#'.$this->get_end_verse();
    }
}

class CChapter
{
    private $chapter_number;
    private $chapter_verses;
    private $unprocessed_verses;
    private $chapter_name;
    private $cPageInfoArray=array();

    public function __construct($chapter_name, $chapter_number, $chapter_verses)
    {
        $this->set_chapter_name( $chapter_name );
        $this->set_chapter_number( $chapter_number );
        $this->set_chapter_verses( $chapter_verses );
        $this->unprocessed_verses= $chapter_verses;
    }

    //setup construction function
    public function adjust_pages($pages_obj)
    {

        foreach($this->cPageInfoArray as $element)
        {
            $page_obj =$pages_obj->get_inital_page_by_number('data/xml/', $element->get_page_number());
            $page_obj->add_chapter_info(
                                    $this->get_chapter_number(),
                                    $element->get_begin_verse(),
                                    $element->get_end_verse()
                                );
        }
    }

    public function add_page($obj)
    {
        $this->cPageInfoArray[] = $obj;
    }

    public function get_display_pages($aya1_index, $aya2_index)
    {
        $page_array = array();
        $aya=$aya1_index;
        reset_Log_file($this->get_chapter_name());

        foreach($this->cPageInfoArray as $Obj)
        {
            $begin = $Obj->get_begin_verse();
            $end = $Obj->get_end_verse();
            Log_to_file('aya='.$aya . 'begin='.$begin . 'end='. $end);
            if( $aya <= $aya2_index)
            {
                if ($aya >= $begin && $aya <= $end) {
                    $page_array[] = $Obj;
                    $aya = $end + 1;
                }
            }
        }
        return $page_array;
    }

    public function get_chapter_name()
    {
        return $this->chapter_name;
    }

    public function get_chapter_number()
    {
        return $this->chapter_number;
    }

    public function get_chapter_verses()
    {
        return $this->chapter_verses;
    }

    public function get_unprocessed_verses()
    {
        return $this->unprocessed_verses;
    }

    public function set_chapter_name($chapter_name)
    {
        $this->chapter_name = $chapter_name;
    }

    public function set_chapter_number($chapter_number)
    {
        $this->chapter_number = $chapter_number;
    }

    public function set_chapter_verses($chapter_verses)
    {
        $this->chapter_verses = $chapter_verses;
    }

    public function set_unprocessed_verses($unprocessed_verses)
    {
        echo 'unprocessed_verses='. $this->unprocessed_verses.'<br/>';
        $this->unprocessed_verses = $unprocessed_verses;
    }


    public function log_me()
    {
        Log_to_file('chapter_name:' . $this->get_chapter_name(). "<br/>");
        Log_to_file('chapter number:' . $this->get_chapter_number(). "<br/>");
        Log_to_file( 'chapter verses:' . $this->get_chapter_verses(). "<br/>");
        foreach($this->cPageInfoArray as $element)
        {
            $element->log_me();

        }
    }
    public function save_chapter_to_xml($chapterxml)
    {
        $chapterxml->addAttribute('number', $this->chapter_number);
        $chapterxml->addAttribute('n_verses', $this->chapter_verses);
        $chapterxml->addAttribute('name', $this->chapter_name);

        $pages= $chapterxml->addChild('pages');

        foreach($this->cPageInfoArray as $aPageInfoObj)
        {
            $aPageInfoObj->add_page_to_xml($pages);
        }
    }

    public function read_chapter_from_xml($xml_chapter)
    {
        $arr = $xml_chapter->attributes();
        $this->set_chapter_number(htmlentities($arr["number"]));
        $this->set_chapter_name(htmlentities($arr["name"]));
        $this->set_chapter_verses(htmlentities($arr["n_verses"]));

        foreach ($xml_chapter->pages as $pages)
            foreach ($pages->children() as $page)
        {
            $obj = new CPageInfo(0,0,0);
            $obj->read_page_xml($page);
            $this->cPageInfoArray[]= $obj;
        }
    }

}


class CChapters
{
    private $cChapterArray = array();

    public function __construct()
    {

    }

    public function get_chapter_by_number($chapter_number)
    {
        return $this->cChapterArray[$chapter_number - 1];
    }

    public function read_chapters_from_xml($page_xml_file)
    {
        $root_obj = simplexml_load_file( $page_xml_file );

        foreach ($root_obj as $xml_chapter)
        {
            $pchapter = new CChapter( '', 0, 0 );
            $pchapter->read_chapter_from_xml( $xml_chapter );

            $this->cChapterArray[$pchapter->get_chapter_number() - 1] = $pchapter;
        }
    }

    public function get_verses_pages($sura_index, $aya1_index, $aya2_index)
    {
        $chapter = $this->get_chapter_by_number( $sura_index );
        $page_array = $chapter->get_display_pages( $aya1_index, $aya2_index );
        return $page_array;
    }

    public function get_display_pages($sura_index, $aya1_index, $aya2_index)
    {
        $chapter = $this->get_chapter_by_number( $sura_index );
        $page_array = $chapter->get_display_pages( $aya1_index, $aya2_index );

        $index = 0;
        $output_buffer = '';

        foreach ($page_array as $page_obj)
        {
            if ($index > 0) $output_buffer = $output_buffer . ',';
            $output_buffer = $output_buffer . $page_obj->get_info_text( $sura_index );
            $index++;
        }
        return $output_buffer;
    }
}
?>
