<?php
/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

  require_once 'Models/Soura.php';
  

class TheBookAttributes
{
    private $pages;
    public $Suras;

    function __construct()
    {
        $this->pages = new pages;
        $this->Suras = new Suras;
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
        $this->Suras->read_quran_sura_xml($quran_data_file );
    }

    public function read_from_svg_generated_pages_xml($rootpath)
    {
        $this->pages->read_from_svg_generated_pages_xml($rootpath);
    }
}

?>