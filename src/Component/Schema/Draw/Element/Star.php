<?php

namespace Component\Schema\Draw\Element;

class Star extends BaseElement
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

        $star = '<polygon  stroke-linecap="round" stroke-linejoin="round" points="'.($x-10).','.($y+15).' '.($x).','.($y+10).' '.($x+10).','.($y+15).' '.($x+6).','.($y+5).' '.($x+15).','.($y).' '.($x+4).','.($y-3).'  '.($x).','.($y-14).' '.($x-4).','.($y-3).' '.($x-15).','.($y).' '.($x-6).','.($y+5).'" style="'.$style.'" />';

        return $star . $this->appends;
    }
}