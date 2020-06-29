<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

require_once 'HtmlGenerator.php';

class AudioControl extends HtmlGenerator{
    //put your code here
    
    public function generate()
    {
        
        
        $td_attrrs= array(new attribute('class','cell'), new attribute('valign', 'middle'), new attribute('style', 'display:inline-block;'));
        $audiobuffer=                       
                $this->gen_play_button() . 
                $this->gen_stop_button() .
                $this->gen_progress_bar().
                $this->gen_vol_button() .
                $this->gen_vol_bar();

        $buffer = $this->gen_control('div', $td_attrrs, $audiobuffer);

        
        $buffer .= '<table class="audiotable" valign="middle"><tr>';
        $buffer .= $this->gen_control('td', null, '<audio id="audio"></audio>');
        
        $buffer .= '</tr></table>';
        return $buffer;
    }

    private function gen_play_button()
    {
        return $this->gen_control('button', array(new attribute('id', 'pButton'), new attribute('style', 'display:inline-block;'), new attribute('onclick', 'playAudio()')), null);
    }
    private function gen_stop_button()
    {
        return $this->gen_control('button', array(new attribute('id', 'stopbutton'), new attribute('style', 'display:inline-block;'), new attribute('onclick', 'stopAudio()')), null);
    }

    private function gen_vol_button()
    {
        return $this->gen_control('button', array(new attribute('id', 'img_volume'),   new attribute('style', 'display:inline-block;'),
            //new attribute('style', 'float:right;padding: 0;'), 
            new attribute('onclick', 'volume_clicked()')), null);
    }

    private function gen_vol_bar()
    {
        $buffer = $this->gen_control('input', 
                                            array(new attribute('type', 'range'), 
                                            new attribute('id', 'volume_slider'), 
                                                new attribute('style', 'display:inline-block;'),
                                            //new attribute('orient', 'vertical'),
                                            //new attribute('style',"display: none"),
                                            new attribute('min','0'),
                                            new attribute('max','100'),
                                            new attribute('step', '1'),
                                            new attribute('value', '100'),
                                            new attribute('onfocusout', 'on_vol_lose_focus()'),
                                            new attribute('onchange', 'setVolume(this.value/100.0)')), '');
        
        return $buffer;
    }

    private function gen_progress_bar()
    {
        return $this->gen_control('progress', array(new attribute('id', 'seekbar'), new attribute('style', 'display:inline-block;'),
                                            new attribute('value', '0'), 
                                            new attribute('max', '1')), null);
    }
    
}
