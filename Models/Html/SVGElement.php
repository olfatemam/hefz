<?php

/**
 *
 * @author Olfat.emam@gmail.com
 * https://www.upwork.com/freelancers/~011afaac378ad2d181
 */

class SVGElement
{
    public $left;
    public $top;
    public $right;
    public $bottom;
    public function __construct($pathSegment, $index)
    {
        $x = Array();
        $y = Array();
        $start_point = explode(',', $pathSegment[$index]);
        if(count($start_point) < 2 )
        {
            $start_point = explode('-', $pathSegment[$index]);
            $y[0] = 0;//-1 * floatval($start_point[1]);
            $this->top=$this->bottom=0;
            return;
        }
        else
        {
            $y[0] = floatval($start_point[1]);
        }

        $start_point[0][0]=' ';
        $x[0] = floatval($start_point[0]);
        $j=1;
        $k=1;

        for($i=$index+1;$i<=$index+4;$i++)
        {
            if ($pathSegment[$i][0] == 'H' || $pathSegment[$i][0] == 'h') {
                $pathSegment[$i][0] =' ';
                $x[$j]=floatval($pathSegment[$i]);
                $j++;
            }
            else if ($pathSegment[$i][0] == 'V' || $pathSegment[$i][0] == 'v')
            {
                $pathSegment[$i][0] =' ';
                $y[$k] =floatval($pathSegment[$i]);
                $k++;
            }
        }

        sort($x, SORT_NUMERIC);
        sort($y, SORT_NUMERIC);
        $this->left=$x[0];
        $this->right=$x[count($x)-1];

        $this->top=$y[0];
        $this->bottom=$y[count($y)-1];
    }
}

