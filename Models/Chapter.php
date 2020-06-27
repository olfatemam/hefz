<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
*/
/*
 *
 *  @author Olfat.Emam
        $config = include('config/app.php');
        $page_xml_file = $config['app_folder'].'/data/chapters_details.xml';
 * 
 * 
 */
require_once 'PageAttributes.php';

class Chapter
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

        foreach($this->cPageInfoArray as $Obj)
        {
            $begin = $Obj->get_begin_verse();
            $end = $Obj->get_end_verse();
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
        //Log_to_file('chapter_name:' . $this->get_chapter_name(). "<br/>");
        //Log_to_file('chapter number:' . $this->get_chapter_number(). "<br/>");
        //Log_to_file( 'chapter verses:' . $this->get_chapter_verses(). "<br/>");
        foreach($this->cPageInfoArray as $element)
        {
            //$element->log_me();
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

        foreach ($xml_chapter->pages->children() as $page)
        {
        
            //foreach ($pages->children() as $page)
            {
                //var_dump($page);
                //echo "<br>";
                //echo "<br>";
                
                $obj = new PageAttributes(0,0,0);
                $obj->read_page_xml($page);
                $this->cPageInfoArray[]= $obj;
            }
        }
    }

}

class Chapters
{
    private $cChapterArray = array();

    public function __construct()
    {

    }
    
    public function read_chapters_from_xml()
    {
        $config = include('config/app.php');
    
        $page_xml_file = $config['app_folder'].'/data/chapters_details.xml';
        
        $root_obj = simplexml_load_file( $page_xml_file );

        foreach ($root_obj as $xml_chapter)
        {
            $pchapter = new Chapter( '', 0, 0 );
            $pchapter->read_chapter_from_xml( $xml_chapter );

            $this->cChapterArray[$pchapter->get_chapter_number() - 1] = $pchapter;
        }
    }

    public function get_chapter_by_number($chapter_number)
    {
        return $this->cChapterArray[$chapter_number - 1];
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
