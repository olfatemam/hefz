<?php

/**
 * Description of Verse
 *
 * @author Olfat.Emam
 */
class Verse 
{
    private $chapterNo;
    private $verseNo;
    private $cx;
    private $cy;
    private $r;
    private $trans;

    public function __construct($chapterNo, $verseNo, $cx, $cy, $r, $trans)
    {
        $this->chapterNo    =   $chapterNo;
        $this->verseNo      =   $verseNo;
        $this->cx           =   $cx;
        $this->cy           =   $cy;
        $this->r            =   $r;
        $this->trans        =   $trans;
    }

    public function save_verse_to_xml($pagexml)
    {
        $versexml = $pagexml->addChild( 'verse' );

        $versexml->addAttribute ('sura', $this->chapterNo);
        $versexml->addAttribute ('aya', $this->verseNo);
        $versexml->addAttribute ('cx', $this->cx);
        $versexml->addAttribute ('cy', $this->cy);
        $versexml->addAttribute ('r', $this->r);
        $versexml->addAttribute ('trans', $this->trans);
   }

    public function read_verse_from_xml($pagexml)
    {
            foreach ($pagexml->attributes() as $a => $b) {
                $a = htmlentities($a);
                $b = htmlentities($b);
                if ($a == 'sura') $this->chapterNo = intval($b);
                if ($a == 'aya') $this->verseNo = intval($b);
                if ($a == 'cx') $this->cx = doubleval($b);
                if ($a == 'cy') $this->cy = doubleval($b);
                if ($a == 'r') $this->r = doubleval($b);
            }
        //}
    }

    public function get_tafseer(){return $this->trans;}
    public function set_tafseer($trans){$this->trans=$trans;}
    
    public function get_verse_number(){return $this->verseNo;}
    public function get_chapter_number(){return $this->chapterNo;}

    public function get_cx(){return $this->cx;}
    public function get_cy(){return $this->cy;}
    public function get_r(){return $this->r;}

    public function set_verse_number($verseNo){$this->verseNo=intval($verseNo);}
    public function set_chapter_number($chapterNo){$this->chapterNo=intval($chapterNo);}

    public function set_cx($cx){$this->cx=doubleval($cx);}
    public function set_cy($cy){$this->cy=doubleval($cy);}
    public function set_r($r){$this->r=doubleval($r);}

public function echo_me()
{
    echo 'chapterNo'. $this->chapterNo.'<br/>';
    echo 'verseNo'. $this->verseNo.'<br/>';
    echo 'cx'. $this->cx.'<br/>';
    echo 'cy'. $this->cy.'<br/>';
    echo 'r'. $this->r.'<br/>';
}

}
