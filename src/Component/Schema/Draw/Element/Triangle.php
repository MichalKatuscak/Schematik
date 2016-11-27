<?php

namespace Component\Schema\Draw\Element;

class Triangle extends BaseElement
{
    public function __toString()
    {
        $x = $this->x;
        $y = $this->y;
        $color1 = $this->color1;
        $color2 = $this->color2;
        $transforms = $this->transforms;

        $style = "fill:$color2;stroke-width:2;stroke:$color1;";
        $style .= $this->generateStyle($transforms);
        $style .= "transform-origin: ".($x)."px ".($y)."px;";

        $triangle = '<polygon  stroke-linecap="round" stroke-linejoin="round" points="'.($x-15).','.($y+15).' '.($x+15).','.($y+15).' '.($x).','.($y-15).'" style="'.$style.'" />';

        return $triangle . $this->appends;
    }
}