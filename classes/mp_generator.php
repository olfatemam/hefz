<?php
/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

require_once 'sura_info.php';
require_once 'reciter_info.php';
require_once 'tafseer_info.php';

require_once 'html_generator.php';
require_once 'custom_audio.php';
//require_once 'menu_gen.php';
require_once 'navigation_menu.php';


define("TOP_BANNER", 1, true);
define("LEFT_BANNER", 2, true);
define("RIGHT_BANNER", 3, true);
define("TOP_LEFT_BANNER", 4, true);


class Quran_page_block extends html_generator
{
    public function __construct()
    {
    }
    function get_visits_counter()
    {
        $data = file_get_contents("counter.txt");
        $x= intval($data);
        $x++;
        file_put_contents("counter.txt", $x);
        $out = str_pad(strval($x), 7, "0", STR_PAD_LEFT);  
        return $out;
    }
    
/*    public function get_visits_counter()
    {
        $errorPath = ini_get('error_log');
        $fp = fopen("counter.txt", "r+");
        if(!$fp)return 100;
        while(!flock($fp, LOCK_EX)) {  // acquire an exclusive lock
        // waiting to lock the file
        }
        $data="";
        $data .= fread($fp, 100);
        $temp = $data;//'500S';
        try
        {
        $x = intval($temp);
        }
        catch(Exception $e)
        {
            echo 'Message: ' .$e->getMessage();
        }
        $x++;

        ftruncate($fp, 0);      // truncate file
        fwrite($fp, $x);  // set your data
        fflush($fp);            // flush output before releasing the lock
        flock($fp, LOCK_UN);    // release the lock
        fclose($fp);
        
        return $x;
    }
*/
    public function generate()
    {
        //$buffer = '<div id="margin_column" class="margin_column" ></div>';
        $buffer = $this->gen_control('div', array(new attribute('id', 'margin_column'), new attribute('class', 'margin_column')),'');
        
       
        $canvas = $this->gen_control('canvas',              array(new attribute('id', 'pages_canvas'),
                                                            new attribute('width', '650'), 
                                                            new attribute('height', '842'),
                                                            new attribute('onclick', 'click_verse(event)'),
                                                            //new attribute('ontab',  'click_verse(event)'),
                                                            new attribute('ondblclick', 'dblclick_verse(event)'), 
                                                            //new attribute('ondbltap', 'dblclick_verse(event)'), 
                                                            new attribute('onmouseover', 'hover_verse(event)'), 
                                                            new attribute('onmouseout', 'clear_verse(event)')), '');
        
 
        $canvas_div = $this->gen_control('div', array(new attribute('class', 'canvas_div')), $canvas);


        $buffer .= $this->gen_control('div',  array(new attribute('id', 'content_block'), new attribute('class', 'content-column')), $canvas_div);
        
        $buffer .= '<a id="go_next" onclick="next()" class ="next_page" href="javascript:void(0);">'
                . '<img border="0" alt="next" src="images/nextpage.png" width="20" height="20"></a>';

        $buffer .= '<a onclick="prev()" class="prev_page" href="javascript:void(0);">'
                . '<img border="0" alt="prev" src="images/previous.png" width="20" height="20"></a>';

        $buffer .= $this->gen_control('span', array(new attribute('class', 'visit_counter')), $this->get_visits_counter());
        

        return $buffer;
    }
    
}

class control_block extends html_generator
{
    public function __construct()
    {
    }
    private function gen_goto_div()
    {
        $goto =  '<table><tr><td style="display:inline-table;margin-top:10px;">';
        $goto .=  $this->gen_control('label', array(new attribute('class','inlinelabel'), new attribute('for', "input_page_number")), 'Goto Page');

        $goto .=  $this->gen_control('input', array(new attribute('class','goto_page_input'), new attribute('type','number'),new attribute('id', "input_page_number"),
                                                    new attribute('min', '1'), new attribute('max', '604')), '');

        $goto .=  $this->gen_control('button', array(new attribute('class','goto_page_btn'), new attribute('id', "goto_page_btn"),new attribute('onclick', 'goto_page()')), 'Go');

        $goto .='</td></tr></table>';
        return $goto;
    }
        
    public function generate()
    {
        $buffer = $this->gen_open_tag('div', array(new attribute('class', 'control-column')), '');

        //here olfat
        
        $navmen= new navigation_menu();
        $goto=$this->gen_goto_div();
        
        $menu= $navmen->generate();
        
        $buffer .= $this->fill_container('div', array(new attribute('class', 'controlls_head')), $menu.$goto);
        
        //$buffer .= $this->fill_container('div', array(new attribute('class', 'controlls_head')), $goto);
        
        $buffer .= $this->fill_container('div', array(new attribute('class', 'left_control_box')), $this->gen_left_side_data_block());
        
        $buffer .= '</div>';

        return $buffer;
    
        return '';
    }
    
    private function gen_error_label()
    {        
        return  $this->gen_control('label', array(new attribute('id', 'ehfaz_error'), new attribute('style', 'color:red;')), null) . '<br>';
    }
    
    
    private function gen_tafseer_list()
    {
        $tafseer_obj = new tafseers();
        $tafseerslist = $tafseer_obj->create_list();

        $img = $this->gen_control('img',        array(new attribute('src','images/refresh.png'), 
                                                    new attribute('width','20'),new attribute('height','20'),
                                                    new attribute('alt','refresh'), 
                                                    new attribute('class','refresh_img')),'');

        $anchor= $this->gen_control('a', 
                            array(
                                    //new attribute('class','refresh_btn'), 
                                    new attribute('onclick','on_refresh_translation()'), 
                                    new attribute('href','javascript:void(0);'), 
                                    new attribute('id','refresh_translation') ) ,$img );
        
        return $this->gen_select_tag_tbl_row($tafseerslist, 'tafseer', 'Translation:', '');//$anchor);
    }
    
    private function gen_reciters_list()
    {
        $reciters_obj = new reciters();
        $reciterslist = $reciters_obj->create_list();
        return $this->gen_select_tag_tbl_row($reciterslist, 'reciter', 'Reciter:', '');
    }
    private function gen_suras_list()
    {
        $souras_obj = new suras();
        $suraslist = $souras_obj->create_list();
        return $this->gen_select_tag_tbl_row($suraslist, 'soura', 'Surah:', '');
    }   
    private function gen_from_list()        
    {        
        return $this->gen_entity_row('select', array(new attribute('for','from_list')), 'From:',array(new attribute('id','from_list'), new attribute('onchange', 'on_from_changed()')));
    }
    private function gen_to_list()        
    {        
        return $this->gen_entity_row('select', array(new attribute('for','to_list')), 'To:', array(  new attribute('id','to_list'),new attribute('onchange', 'on_to_changed()')));
    }
    
    private function gen_repeat_all_number()
    {
        return $this->gen_entity_row('input', array(new attribute('for','repeat_all')), 'Repeat Range:', array(new attribute('id','repeat_all'), new attribute('value', '1'), new attribute('type', 'number')));
    }
    
    private function gen_left_side_data_block()
    {

        $buffer =  $this->gen_error_label();
        $buffer .= $this->gen_open_tag('table', array(new attribute('class', 'control_table')));
        $buffer .= $this->gen_reciters_list();
        $buffer .= $this->gen_suras_list();
        $buffer .= $this->gen_tafseer_list();
        $buffer .= $this->gen_from_list();
        $buffer .= $this->gen_to_list();
        $buffer .= $this->gen_repeat_all_number();
        $buffer .= '</table>';
        $buffer .= $this->generate_repeat_each_div();
        
        
        $custm_audio = new custom_audio();
        //$buffer .= '<tr>';
        $buffer .= $this->gen_control('div', array(new attribute('class', 'audio_block')), $custm_audio->generate());//array(new attribute('class', 'titlename')), '');
                
        $buffer .= $this->fill_container('div', array(new attribute('class', 'tafseer_block')), 
                
                '<span id="tafseer_title" class="tafseer_title"></span>'.
                '<span id="tafseer_text" class="tafseer_text"></span>'
                );


        
        return $buffer;
    }
    private function gen_ra_div_content()
    {
        $buffer =  '<div>';
        $buffer .= $this->gen_control('input', 
            array(new attribute('type', 'checkbox'),
                new attribute('id', 'r3'), 
                new attribute('value', '3'), 
                new attribute('onclick', 'on_repeatition_click(this, r5, r7)')), 
            null);

        $buffer .= $this->gen_control('label', 
            array(new attribute('class','_label'), 

                new attribute('for', "r3")), '3');


        $buffer .= $this->gen_control('input', 
                   array(new attribute('type', 'checkbox'),
                    new attribute('id', 'r5'), 
                    new attribute('value', '5'), 
                    new attribute('onclick', 'on_repeatition_click(this, r3, r7)')),
                    null);

        $buffer .= $this->gen_control('label', array(new attribute('class','_label'), new attribute('for', "r5")), '5');


        $buffer .= $this->gen_control('input', array(
                        new attribute('type', 'checkbox'),
                        new attribute('id', 'r7'), 
                        new attribute('value', '7'), 
                        new attribute('onclick', 'on_repeatition_click(this, r3, r5)')), 
                    null);

        $buffer .= $this->gen_control('label', array(new attribute('class','_label'), new attribute('for', "r7")), '7');
        
        $buffer .= '</div>';
        
        return $buffer;

    }

    private function generate_repeat_each_div()
    {
        $buffer = $this->gen_control('div', array(new attribute('class','center_label')), 'Repeat Each Verse:');
        $buffer .= $this->gen_control('div', array(new attribute('class','center_label')), $this->gen_ra_div_content());
        return $buffer;
    }
}
class header_footer extends html_generator
{
    
    public function gen_page_header()
   {
        $header = '<head>';
        
        $header .= '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
        $header .= '<meta name="viewport" content="width=device-width,user-scalable=yes" />';
        $header .= '<title>Al Murattal</title>';

        $header .= '<link rel="stylesheet" type="text/css" href="css/left7.css" />';
        $header .= '<link rel="stylesheet" type="text/css" href="css/audio7.css" />';
        $header .= '<link rel="stylesheet" type="text/css" href="css/menu8.css" />';
        $header .= '<link rel="stylesheet" type="text/css" href="css/style7.css" />';
        $header .= '<link rel="stylesheet" type="text/css" href="css/nested_list.css" />';
        
        $header .= '<script src="js/ihfaz7.js"></script>';
        $header .= '<script src="js/verserect7.js"></script>';
        $header .= '<script src="js/verse8.js"></script>';
        $header .= '<script src="js/pages7.js"></script>';
        $header .= '<script src="js/media8.js"></script>';
        $header .= '<script src="js/process8.js"></script>';

        $header .= '</head>';
        return $header;
   }

   public function generate_header($add_banner)
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
    
    public function generate_footer()
    {
        //return $this->fill_container('div', array(new attribute('class', 'footer')), '');
        return '';
    }
    
}
class mp_generator extends html_generator
{
    public function __construct()
    {
        $this->buffer='';
    }
    private $buffer="";
    
    
    private function is_mobile_agent()
    {
    $useragent=$_SERVER['HTTP_USER_AGENT'];

        if( preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)
                ||
            preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent,0,4)))
                        return false;
    
        return false;
    }
        //$ismobile=$this->is_mobile_agent();
        //new attribute('id', 'borderimg'), 

    public function generate($add_banner)
    {
        
        $header_obj=new header_footer();
        $control_block_obj=new control_block();
        $Quran_page_obj = new Quran_page_block();

        $this->buffer = $header_obj->gen_page_header();
        $this->buffer .= '<body unselectable="on">';
        $this->buffer .= $this->gen_open_tag('div', array(new attribute('class', 'container')), '');
        
        $this->buffer .= $header_obj->generate_header($add_banner);
        
        $this->buffer .= $control_block_obj->generate();
        
        $this->buffer .= $Quran_page_obj->generate();

        $this->buffer .= '</div></body>';

        //$this->buffer .= $this->gen_footer();

        return $this->buffer;
    }
    
    
    
}


/*
 * #primary_nav_wrap
{
    margin-left:0px;
    margin-top:0px;
    z-index: 1000;
    overflow: visible;
}

#primary_nav_wrap ul
{
    list-style:none;
    margin:0;
    padding:5x;
    z-index: 1000;
    overflow: visible;
}

#primary_nav_wrap ul a
{
    z-index: 1000;
    color:#333;
    margin: 0px;
    text-decoration:none;
    text-align: right;
    font-weight: bold;
    font-size:12px;
    font-family:"HelveticaNeue","Helvetica Neue",Helvetica,Arial,sans-serif;
    overflow: visible;
}

#primary_nav_wrap ul li
{
    z-index: 1000;
    margin:0;
    padding: 5px;
    overflow: visible;
}

#primary_nav_wrap ul li.current-menu-item
{
    background:#ddd;
    z-index: 1000;
    overflow: visible;
}

#primary_nav_wrap ul li:hover
{
background:#f6f6f6
}

#primary_nav_wrap ul ul
{
    display:none;
    background:#fff;
    padding:0;
}

#primary_nav_wrap ul ul li
{
	float:none;
	width:auto;
}

#primary_nav_wrap ul ul a
{
	line-height:auto;
	padding:0;
}

#primary_nav_wrap ul ul ul
{
	top:0;
	left:100%
}

#primary_nav_wrap ul li:hover > ul
{
	display:inline-block;
}




#juz_menu {
    
    overflow: visible;
    
    height: 200px; 
    -webkit-column-count: 5;
       -moz-column-count: 5;
            column-count: 5; 

}
#juz_menu li {
    display: inline-block; 
    overflow: visible;
}


#sura_menu {
    
    overflow: visible;
    height: 700px; 
    -webkit-column-count: 5;
       -moz-column-count: 5;
            column-count: 5; 
}
#sura_menu li {
    overflow: visible;
    display: inline-block; }
*/


/*$obj = new Quran_page_block();
$obj->get_visits_counter();
*/