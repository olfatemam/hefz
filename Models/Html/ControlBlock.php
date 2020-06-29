<?php
require_once 'Models/Html/HtmlGenerator.php';

class ControlBlock extends HtmlGenerator
{
    public function __construct()
    {
    }
    public function gen_goto_div()
    {
        $goto =  '<table><tr><td style="display:inline-table;margin-top:10px;">';
        $goto .=  $this->gen_control('label', array(new attribute('class','inlinelabel'), new attribute('for', "input_page_number")), 'Goto Page');

        $goto .=  $this->gen_control('input', array(new attribute('class','goto_page_input'), new attribute('type','number'),new attribute('id', "input_page_number"),
                                                    new attribute('min', '1'), new attribute('max', '604')), '');

        $goto .=  $this->gen_control('button', array(new attribute('class','goto_page_btn'), new attribute('id', "goto_page_btn"),new attribute('onclick', 'goto_page()')), 'Go');

        $goto .='</td></tr></table>';
        return $goto;
    }
    
    public function generate_body()
    {
        $buffer = $this->gen_open_tag('div', array(new attribute('class', 'control-column')), '');

        //here olfat
        
        //$navmen= new NavigationMenu();
        $goto=$this->gen_goto_div();
        
        //$menu= $navmen->generate();
        
        //$buffer .= $this->fill_container('div', array(new attribute('class', 'controlls_head')), $menu.$goto);
        
        $buffer .= $this->fill_container('div', array(new attribute('class', 'controlls_head')), $goto);
        
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
        $tafseer_obj = new Tafseers();
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
    private function gen_Suras_list()
    {
        $souras_obj = new Suras();
        $Suraslist = $souras_obj->create_list();
        return $this->gen_select_tag_tbl_row($Suraslist, 'soura', 'Surah:', '');
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
        $buffer .= $this->gen_Suras_list();
        $buffer .= $this->gen_tafseer_list();
        $buffer .= $this->gen_from_list();
        $buffer .= $this->gen_to_list();
        $buffer .= $this->gen_repeat_all_number();
        $buffer .= '</table>';
        $buffer .= $this->generate_repeat_each_div();
        
        
        $custm_audio = new AudioControl();
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
