<?php

require_once 'Models\Soura.php';
require_once 'Models\Juzz.php';

class NavigationMenu //extends HtmlGenerator
{
    //put your code here
    public function generate()
    {
     $var = '<ul>
                
                <li class="dropdown">
                  <a href="javascript:void(0)" class="dropbtn">Dropdown1</a>
                  <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                  </div>
                </li>
              </ul>';   
        
        $buffer = '<ul>';
        $buffer .= $this->gen_suras_menu();
        $buffer .= $this->gen_juz_menu();
        $buffer .='</ul>';
        //file_put_contents("hefz.log", $buffer);

        //$buffer .=  '</div>';
        return $buffer; 
    }    

    private function gen_juz_menu()
    {
        $juzs_obj = new juzs();
        $juzslist = $juzs_obj->create_menu();
        return $juzslist;
    }   
    
    private function gen_suras_menu()
    {
        $souras_obj = new suras();
        $suraslist = $souras_obj->create_menu();
        return $suraslist;
    }   
}
