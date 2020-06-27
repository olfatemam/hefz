<?php


class Border
{
    private $left;
    private $top;
    private $right;
    private $bottom;
    private $index;

    public function enumerate_chapters_indexes($sura_index)
    {
        $sura_index++;
        $this->index=$sura_index;
        return $sura_index;
    }

    public function save_border_to_xml($pagexml)
    {
        $versexml = $pagexml->addChild( 'sborder' );

        $versexml->addAttribute ('index', $this->get_index());
        $versexml->addAttribute ('left', $this->get_left());
        $versexml->addAttribute ('top', $this->get_top());
        $versexml->addAttribute ('right', $this->get_right());
        $versexml->addAttribute ('bottom', $this->get_bottom());
    }

    public function read_border_from_xml($pagebordersxml)
    {
        foreach ($pagebordersxml->attributes() as $a => $b)
        {
            $a = htmlentities($a);
            $b = htmlentities($b);

            if ($a == 'index') $this->set_index(intval($b));
            if ($a == 'left') $this->set_left(doubleval($b));
            if ($a == 'top') $this->set_top(doubleval($b));
            if ($a == 'right') $this->set_right(doubleval($b));
            if ($a == 'bottom') $this->set_bottom(doubleval($b));
        }
    }

    public function echo_me()
    {
        echo 'chapterNo'. $this->index.'<br/>';
        echo 'left'  . $this->left .'<br/>';
        echo 'top'   . $this->top .'<br/>';
        echo 'right' . $this->right .'<br/>';
        echo 'bottom'. $this->bottom .'<br/>';
    }

    public function get_index(){return $this->index;}
    public function set_index($index){$this->index=intval($index);}


    public function get_left(){return $this->left;}
    public function get_top(){return $this->top;}
    public function get_right(){return $this->right;}
    public function get_bottom(){return $this->bottom;}


    public function set_left($left){$this->left=doubleval($left);}
    public function set_top($top){$this->top=doubleval($top);}
    public function set_right($right){$this->right=doubleval($right);}
    public function set_bottom($bottom){$this->bottom=doubleval($bottom);}
}
