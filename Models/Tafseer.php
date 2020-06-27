<?php


class Tafseer {

    public $tafsser_tree=array();

    public $index;   
    public $ename;
    public $aname;
    public $filepath;
    public $language;
    
    public function __construct($node)
    {
        $this->index = 0;
        $this->ename  = '';
        $this->aname  = '';
        $this->language= '';
        $this->filepath= '';
        if($node)
        {
            $this->index = intval($node->index);
            $this->ename  = $node->ename->__toString();
            $this->aname  = $node->aname->__toString();
            $this->language= $node->language->__toString();
            $this->filepath= $node->filepath->__toString();
        }
    }

    public function get_sura_tafseer($filepath, $sura_num)
    {
        $this->filepath=$filepath;
        
        $quran_txt = simplexml_load_file($filepath);
        $sura = $quran_txt->sura[$sura_num-1];
        if($sura)
        {
            foreach ($sura->aya as $aya)
            {
                $this->add_aya_text(intval($sura->attributes()->index), 
                        intval($aya['index']), 
                        strval($aya['text'])
                        );
            }
        }        
        }
    public function get_aya_text($filepath, $sura, $aya)
    {
        $buf="";
        if(!array_key_exists($sura, $this->tafsser_tree))
        {
            $this->get_sura_tafseer($filepath, $sura);
        }
        if(array_key_exists($sura, $this->tafsser_tree))
        {$buf = $this->tafsser_tree[$sura][$aya];
        }
        //echo $buf;
        //echo '<br>******************************<br>';
        return $buf;
    }

    public function add_aya_text($sura, $aya, $text)
    {
        if(!array_key_exists($sura, $this->tafsser_tree))
        {
            $this->tafsser_tree[$sura] = array($aya=>$text);
        }
        else 
        {
            $this->tafsser_tree[$sura][$aya]=$text;
        }
        return;
    }
}

