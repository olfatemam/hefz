<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

class Attribute
{
    public function __construct($name, $value)
    {
        $this->name=$name;
        $this->value=$value;
    }
    public $name;
    public $value;
}

class HtmlGenerator {
    //put your code here

    
    protected function add_Attributes($tag_str, $attribs)
    {
        if($attribs == null)return $tag_str;
        
        foreach($attribs as $atr)
        {
            $tag_str = $this->add_Attribute($tag_str, $atr);
        }
        return $tag_str;
    }

    protected function add_Attribute($tag_str, $attrib)
    {
        if(!$attrib || $attrib==null)    return $tag_str;
        
        if($attrib->value!='')
            $tag_str  = $tag_str . ' '. $attrib->name . '="' . $attrib->value . '" ';
        
        return $tag_str ;
    }
    
    public function gen_open_tag($tag, $attribs)
    {
        $tag_str = '<'.$tag .' ';
        if($attribs!=null)
            $tag_str = $this->add_Attributes($tag_str, $attribs);
        
        $tag_str = $tag_str .  '>' ;
        
        return $tag_str;
     }
    
    protected function gen_select_tag_tbl_row($combo, $for, $text, $extracell)
    {
        $buffer = '<tr style="">';

        $buffer .= $this->fill_container('td ', 
                array(new Attribute('class', 'titlename1')), 
                $this->gen_control('label', array(new Attribute('class','_label1'), new Attribute('for',$for)), $text));
        
        $buffer .= $this->fill_container('td', null, $combo.$extracell);

        if($extracell!='')
        {
            //$buffer .= $this->fill_container('td ', null, $extracell);
        }
        
        $buffer .= '</tr>';
        
        return $buffer;
    }
      
  
    protected function gen_entity_row($tag, $label_attribs, $labeltext, $tagattribs)
    {
        $str = '<tr style="height:35px;">';
        $str .= $this->fill_container('td', array(new Attribute('class', 'titlename')), $this->gen_control('label', $label_attribs, $labeltext));
        $str .= $this->fill_container('td', null, $this->gen_control($tag, $tagattribs, null));
        
        $str .= '</tr>';
        return $str;
    }
    
    public function gen_control($tag, $attribs, $text)
    {
        if($text==null)
            $text='';
        
        $tag_str = '<'.$tag .' ';
        
        $tag_str = $this->add_Attributes($tag_str, $attribs);
        
        $tag_str = $tag_str .  '>' ;
        
        
        if($tag != 'input')
            $tag_str= $tag_str. $text . '</' . $tag . '>';
        
        return $tag_str;
    }
        
    protected function label_cell($attribs, $text)
    {
        return $this->fill_container('td', array(new Attribute('class', 'titlename')), $this->gen_control('label', $attribs, $text));
    }


    protected function fill_container($tag, $tag_attribs, $tag_content)
    {
        return  $this->gen_open_tag($tag, $tag_attribs) . $tag_content. '</' . $tag.'>';
    }
    
    protected function fill_cell($cellattribs, $cellcontent)
    {
        return  $this->fill_container('td', $cellattribs, $cellcontent);
    }
}
