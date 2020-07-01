<?php

require_once 'Models/Soura.php';
require_once 'Models/Juzz.php';

class NavigationMenu //extends HtmlGenerator
{
    //put your code here
    public function generate()
    {
        $buffer = '<div id="main_menu" class="w3-bar w3-light-grey w3-border w3-padding">';
        
        $buffer .= $this->gen_Suras_menu();
        //$buffer .= $this->gen_juz_menu();
        
        $buffer .='<button class="w3-bar-item w3-button w3-green w3-mobile w3-right" onclick="goto_page()">Go</button>';
        $buffer .= '<input type="number" id="input_page_number" class="w3-bar-item w3-input w3-white w3-mobile w3-right" placeholder="Page Number.." min="1">';
        
        
        $buffer .='</div>';
        return $buffer; 
    }    

    private function gen_juz_menu()
    {
        $juzs_obj = new Juzs();
        $juzslist = $juzs_obj->create_menu();
        return $juzslist;
    }   
    
    private function gen_Suras_menu()
    {
        $souras_obj = new Suras();
        $Suraslist = $souras_obj->create_menu();
        return $Suraslist;
    }   
}
