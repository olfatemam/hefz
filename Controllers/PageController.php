<?php


require_once 'Models/Chapter.php';
require_once 'Models/Pages/Pages.php';

class PageController
{    
    
    private $soura;
    private $reciter;
    private $tafseer;
    private $from;
    private $to;
    private $repeat;
    private $page_num;
    
    private $pages_array=array();
    private $update_trans;
    private $page_list;

    public function __construct()
    {
        $this->read_input();
    }

    
    public function Process_request()
    {
        if( $this->reciter != null )
        {
            $chapters = new Chapters();
            $chapters->read_chapters_from_xml();
            $this->pages_array = $chapters->get_verses_pages($this->soura, $this->from, $this->to);
        }
        else if( $this->page_num!=null )
        {
            $this->init_pages_array_from_string(strval($this->page_num));
        }
        else if($this->update_trans==true)
        {
            $this->init_pages_array_from_string($this->page_list);
        }
        else 
        {
            $this->init_pages_array_from_string(htmlentities('%5B1%5D'));
        }
        
        echo $this->get_requested_pages($this->pages_array);
    }
    
    private static function read_variable($key)
    {
        return (isset($_GET[$key] )) ? $_GET[$key] :null;
    }
    

    private function init_pages_array_from_string($page_list)
    {
        $temp_array = explode( ',', $page_list);
        for($i=0;$i<count($temp_array);$i++)
        {
            $this->pages_array[] = new PageAttributes($temp_array[$i], 1, 1);
        }
    }
    
    private function read_input()
    {
        $this->soura = self::read_variable('soura'); 
        $this->reciter = self::read_variable('reciter');
        
        $this->tafseer = self::read_variable('tafseer');
        if(!$this->tafseer)
            $this->tafseer = 'ar.jalalayn.xml';
        
        $this->from = self::read_variable('from');
        $this->to = self::read_variable('to');
        $this->repeat = self::read_variable('repeat');
        $this->page_num = self::read_variable('page_num');
        $this->pages_array=null;
        $this->update_trans = self::read_variable('update_trans');

        if($this->update_trans!=null)
        {
            $this->page_list = self::read_variable('pages_list');
        }
    }
    private function get_requested_pages()
    {         
        header('content-type: application/json; charset=utf-8');
        return (new Pages())->get_requested($this->pages_array, $this->tafseer);
    }
}
