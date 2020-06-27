<?php

/**
 * Description of Pages
 *
 * @author Olfat.Emam
 */
require_once 'Models/Page.php';

class Pages
{
    private $pages_info = array();

    public function print_data()
    {
        print_r($this->pages_info);
    }

    
    public function get_requested($sura_pages_arry, $tafseer)
        {
            $pagesxml= new SimpleXMLElement( '<pages/>' );

            foreach($sura_pages_arry as $temp)
            {
                $page_info_obj = $this->get_final_page_by_number($temp->get_page_number());
                $page_info_obj->save2_page_to_final_xml($pagesxml, $tafseer);
            }
            return $pagesxml->asXML();
        }

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

    public function get_final_page_by_number($page_num)
    {
        $page_num=intVal($page_num);
        $config = include('config/app.php');
    
        $folder=$config['app_folder'].'/data/pages/final_xml/';
        
        if ( array_key_exists($page_num, $this->pages_info))
            return $this->pages_info[$page_num];

        $page_xml_file= $folder . str_pad(strval($page_num), 3, '0', STR_PAD_LEFT).'.xml';
        
        
        $xml_file = simplexml_load_file($page_xml_file);
        
        $page_obj  = new Page();
        $page_obj->read_page_from_final_xml($xml_file);
        $this->pages_info[$page_obj->get_index()] = $page_obj;
        
        return $page_obj;
    }

    public function get_final_page_info($page_num)
    {
        return get_final_page_by_number($page_num);
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
            $page_obj = new Page();
            $page_obj->read_from_svg_generated_page_xml($page_xml_file, $page_num);
            $this->pages_info[$page_num] = $page_obj;
        }
    }
}
