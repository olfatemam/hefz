<?php


class PageAttributes
{
    private $page_num;
    private $begin_verse;
    private $end_verse;

    public function __construct($page_num, $begin_verse=1, $end_verse=1)
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
        $this->set_page_number(($page->page_num));
        $this->set_begin_verse( ($page->begin_verse));
        $this->set_end_verse( ($page->end_verse) );
        
        $this->log_me();
    }

    public function log_me()
    {
//        Log_to_file("\r\n********olfat*********************\r\n");
//        Log_to_file('\r\n page number:'.$this->get_page_number()."\r\n");
//        Log_to_file('\r\n begin verse:'.$this->get_begin_verse()."\r\n");
//        Log_to_file('\r\n end verse:'.$this->get_end_verse()."\r\n");
    }

    public function get_info_text($chapter)
    {
        return $this->get_page_number().'#'.$chapter.'#'.$this->get_begin_verse().'#'.$this->get_end_verse();
    }
}
