<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QPage
 *
 * @author Olfat.Emam
 */
    //put your code here

require_once 'Models/Html/HtmlGenerator.php';

class QPage extends HtmlGenerator
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

