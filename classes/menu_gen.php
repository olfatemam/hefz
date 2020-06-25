<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */
require_once 'html_generator.php';

class mobile_control_slider extends html_generator{
    //put your code here
    public function genenerate($menu_html)
    {
    
        $menu_str = '<link rel="stylesheet" type="text/css" href="css/slidemenu.css" />';
        
        $menu_str .= '<div id="main">' . 
                '<span id="togglebutton" style="font-size:15px;cursor:pointer" onclick="togglemenu()">Hide Settings</span>' . 
                '</div>';
    
        $menu_str .= '<div id="mySidenav" class="sidenav">' ; 
        $menu_str .= $menu_html;
        $menu_str .= '</div>';
        
        $menu_str .= $this->gen_js();
        
    return $menu_str; 
 /*&#9776;*/   
    
    }    
    private function gen_js()
    {
    return 
        '<script>
         var menu_visible=true;
        function togglemenu() 
        {
            if(menu_visible == false)
            {
                menu_visible=true;
                document.getElementById("togglebutton").textContent="Hide Settings";
                document.getElementById("mySidenav").style.width = "420px";
                document.getElementById("main").style.marginLeft = "0";
                document.getElementById("content_block").style.display="inline-block";
            }
            else
            {
                menu_visible=false;
                document.getElementById("togglebutton").textContent="Show Settings";
                document.getElementById("content_block").style.display="block";
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("main").style.marginLeft= "0";
            }
        }
        </script>';
    }    
}
