<?php
/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

    require_once 'quran_info.php';
    require_once 'chapter_info.php';
    require_once 'svg_box.php';

class quran_info_generator
{
    private $ChapterArray;
    private $g_sura_number;
    private $data_folder;
    public function __construct($data_folder)
    {
        $this->ChapterArray = array();
        $this->g_sura_number =0;
        //$this->data_folder='c:/MAMP/htdocs/ihfaz/data/';
    }

    public function setup_indexes()
    {
        $this->generate_xml_from_svg();
        $this->init_chapters_array();
        $this->create_pages_final_index_files();
        $this->save_chapters_to_xml();
    }

    public function adjust_pages_verses($pages)
    {
        for ($sura_num = 1; $sura_num <= 114; $sura_num++)
        {
            $chapter_obj = $this->ChapterArray[$sura_num - 1];
            $chapter_obj->adjust_pages($pages);
        }
    }


    public function save_chapters_to_xml()
    {
        $newxml = new SimpleXMLElement( "<chapters/>" );

        for ($sura_num = 1; $sura_num <= 114; $sura_num++)
        {
            $chapterxml = $newxml->addChild( 'chapter' );
            $this->ChapterArray[$sura_num - 1]->save_chapter_to_xml($chapterxml);
        }
        
        $newxml->asXML( $this->data_folder.'chapters_details.xml' );
    }


    private function generate_xml_from_svg()
    {
        $this->g_sura_number=0;
        print_r($this->g_sura_number);
        for ($pagen_um = 1; $pagen_um <= 604; $pagen_um++) {
            $this->generate_page_info_xml($pagen_um);
        }
        print_r($this->g_sura_number);
    }

    public function add_border($newxml, $border_tag, $x, $y, $f_sura_border)
    {
        $pathSegmentPattern = '/[a-z][^a-z]*/i';

        preg_match_all($pathSegmentPattern, $y, $pathSegments);

        $box1 = new svg_box($pathSegments[0], 0);
        if( $pathSegments[0][6]== 'M' || $pathSegments[0][6]== 'm' )
            $box2 = new svg_box($pathSegments[0], 6);
        else
            $box2=$box1;

        if($f_sura_border==true && ( $box1->bottom==0 || $box2->bottom==0 ) ) {
            return;
        }

        $border = $newxml->addChild($border_tag);
        if($f_sura_border==true)
        {
            $this->g_sura_number++;
            $border->addAttribute('index', $this->g_sura_number);
        }
        if ($box1->left < $box2->left && $box1->top < $box2->top)
        {
            //take box2
            $this->add_border_coordinates($border, $box2);
        }
        else
        {
            $this->add_border_coordinates($border, $box1);
        }
    }

    public function generate_page_info_xml($page_num)
    {
        $first_aya = 0;

        $svg_file = $this->data_folder .'pages/svg/' . str_pad($page_num, 3, '0', STR_PAD_LEFT) . '.svg';
        $new_file = $this->data_folder . 'pages/xml/' . str_pad($page_num, 3, '0', STR_PAD_LEFT) . '.xml';
        echo $svg_file;
        $xml_file = simplexml_load_file($svg_file);

        $newxml = new SimpleXMLElement('<page/>');
        $aya_counter = 0;
        $sura_borders=null;
        foreach ($xml_file as $main)
        {
            if ($main->getName() == 'g')
            {
                $z = $main->attributes();
                foreach ($z as $a => $b)
                {
                    if ($a == 'id' && $b == "Border")
                    {
                        //$verses_element = $newxml->addChild('border');
                        foreach ($main->path->attributes() as $x => $y)
                        {
                            if ($x == 'd')
                            {
                                $this->add_border($newxml, 'border', $x, $y, false);
                            }
                        }
                        foreach($main->g as $g)
                        {

                            foreach ($g->path->attributes() as $x => $y) {
                                if ($x == 'd')
                                {
                                    if($sura_borders==null)
                                        $sura_borders = $newxml->addChild('sborders');
                                    $this->add_border($sura_borders, 'sborder', $x, $y, true);
                                }
                            }
                        }
                    }
                    if ($a == 'id' && $b == "Aya_x5F_Number")
                    {
                        $verses_element = $newxml->addChild('verses');
                        if( $main->g[0]  == null || count( $main->g[0] )==0)
                        {
                            //print_r($main->circle);
                            if($main->circle != null)
                            {
                                $verse_element = $verses_element->addChild('verse');
                                $aya_counter++;
                                foreach ($main->circle->attributes() as $x => $y) {
                                    $verse_element->addChild($x, $y);
                                }
                            }
                        }
                        else foreach ($main->g[0] as $child)
                        {
                            $verse_element = $verses_element->addChild('verse');
                            $aya_counter++;
                            foreach ($child->attributes() as $x => $y) {
                                $verse_element->addChild($x, $y);
                            }
                        }
                        break;
                    }
                }
            }
        }
        $newchild = $newxml->addChild('totalverses', $aya_counter);
        $newxml->asXML($new_file);
    }

    public function init_chapters_array() {
        
        $q_info = new quran_info;

        $this->ChapterArray = array();
        $q_info->read_quran_sura_xml( $this->data_folder.'quran-data.xml' );
        $q_info->read_from_svg_generated_pages_xml( $this->data_folder.'pages/xml/' );

        $page_num = 1;

        for ($sura_num = 1; $sura_num <= 114; $sura_num++)
        {
            $sura = $q_info->suras->get_sura_by_index( $sura_num );
            $pchapter = new CChapter( $sura->name, $sura_num, $sura->ayas );
            $page_num = $this->setup_chapter_paging($q_info, $pchapter, $page_num);
            $this->ChapterArray[$sura_num - 1] = $pchapter;
        }
    }

    public function create_pages_final_index_files() {

        $q_info = new quran_info();

         $q_info->read_quran_sura_xml( $this->data_folder.'quran-data.xml' );
        $q_info->read_from_svg_generated_pages_xml( $this->data_folder.'pages/xml/' );

        $q_info->get_pages()->reorder_verses();
        $q_info->get_pages()->reorder_sura_boxes();
        $q_info->get_pages()->enumerate_chapters_indexes();
        $this->adjust_pages_verses($q_info->get_pages());

        $q_info->get_pages()->save_final_pages_xml_files($this->data_folder.'pages/final_xml/');
    }

    public function setup_chapter_paging($quran_info, $pchapter, $begin_at_page)
    {
        $pchapter->set_unprocessed_verses($pchapter->get_chapter_verses());

        $begin=0;
        $end=0;
        $page= $begin_at_page;

        while( $page <= 604 && $pchapter->get_unprocessed_verses()>0 )
        {
            $master_page = $quran_info->get_inital_page_by_number('data/xml/', $page);
            $page_size = $master_page->get_available_number_of_verses($page);
            $remainder= $pchapter->get_unprocessed_verses()- $page_size;
            $begin=$end+1;
            if($remainder==0)
            {
                $master_page->set_available_number_of_verses(0);
                $end=$begin+$page_size-1;
                $obj = new CPageInfo($page,$begin, $pchapter->get_chapter_verses());
                $pchapter->add_page($obj);
                $pchapter->set_unprocessed_verses(0);
                return $page+1;
            }
            if($remainder>0)
            {
                $end=$begin+$page_size-1;
                $master_page->set_available_number_of_verses(0);
                $obj = new CPageInfo($page,$begin, $end);
                $pchapter->add_page($obj);
                $pchapter->set_unprocessed_verses($pchapter->get_unprocessed_verses()- $page_size);
            }
            else
            {
                $end=$begin+$pchapter->get_unprocessed_verses()-1;
                $obj = new CPageInfo($page,$begin, $pchapter->get_chapter_verses());
                $pchapter->add_page($obj);
                $master_page->set_available_number_of_verses($page_size-$pchapter->get_unprocessed_verses());
                $pchapter->set_unprocessed_verses(0);
                return $page;
            }
            $page=$page+1;
        }
        return $page;
    }

    public function add_border_coordinates($border, $box)
    {
            
        $border->addAttribute('left', $box->left);
        $border->addAttribute('top', $box->top);
        $border->addAttribute('right', $box->right);
        $border->addAttribute('bottom', $box->bottom);
    }

}


