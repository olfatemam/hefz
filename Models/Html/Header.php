<?php

require_once 'Models/Html/HtmlGenerator.php';

class Header extends HtmlGenerator
{
    
    public function generate_page_header()
   {
        $header = '<head>';
        
        $header .= '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
        $header .= '<meta name="viewport" content="width=device-width,user-scalable=yes" />';
        $header .= '<title>Al Murattal</title>';

        $header .= '<link rel="stylesheet" type="text/css" href="css/w3.css" />';
        $header .= '<link rel="stylesheet" type="text/css" href="css/left7.css" />';
        $header .= '<link rel="stylesheet" type="text/css" href="css/audio7.css" />';
        $header .= '<link rel="stylesheet" type="text/css" href="css/menu8.css" />';
        $header .= '<link rel="stylesheet" type="text/css" href="css/style7.css" />';
        $header .= '<link rel="stylesheet" type="text/css" href="css/nested_list.css" />';
        
        $header .= '<script src="js/ihfaz7.js"></script>';
        $header .= '<script src="js/verserect12.js"></script>';
        $header .= '<script src="js/verse8.js"></script>';
        $header .= '<script src="js/pages8.js"></script>';
        $header .= '<script src="js/media8.js"></script>';
        $header .= '<script src="js/process8.js"></script>';

        $header .= '</head>';
        return $header;
   }

   public function generate($add_banner)
    {
        $header_class = 'header';
        if($add_banner==TOP_BANNER)
            $header_class='header_banner';
        else if($add_banner==LEFT_BANNER)
            $header_class='left-banner-column';
        else if($add_banner==RIGHT_BANNER)
            $header_class='right-banner-column';
        
        return $this->gen_control('div', array(new attribute('class', $header_class)), '');

    }
}
