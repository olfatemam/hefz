<?php
/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

  require_once 'sura_info.php';
  require_once 'page_info.php';


class quran_info
{
    private $pages;
    public $suras;

    function __construct()
    {
        $this->pages = new pages;
        $this->suras = new suras;
    }

    public function get_pages()
    {
        return $this->pages;
    }

    public function get_final_page_by_number($path, $page)
    {
        return $this->pages->get_final_page_by_number($path, $page);
    }

    public function get_inital_page_by_number($path, $page)
    {
        return $this->pages->get_inital_page_by_number($path, $page);
    }

    public function read_quran_sura_xml($quran_data_file)
    {
        $this->suras->read_quran_sura_xml($quran_data_file );
    }

    public function read_from_svg_generated_pages_xml($rootpath)
    {
        $this->pages->read_from_svg_generated_pages_xml($rootpath);
    }
}

?>