<?php

namespace Component\Schema\Draw\Element;

class LineHorizontal extends BaseElement
{
    const short_name = 'element_linehorizontal';

    public function __toString()
    {
        $x = $this->x;
        $y = $this->y;
        $color1 = $this->color1;
        $color2 = $this->color2;
        $transforms = $this->transforms;
        $width = 30;

        if (Triangle::class === $this->parent) {
            $width = 16;
        }
        dump($this->parent.": ".$width);

        $style = "stroke:$color1;";
        $style .= $this->generateStyle($transforms);
        $style .= "transform-origin: 50% 50%;stroke-width:2;";

        return '<line data-name="hori" stroke-linecap="round" stroke-linejoin="round" x1="'.($x+($width/2-1)).'" y1="'.($y).'" x2="'.($x-($width/2-1)).'" y2="'.($y).'" style="'.$style.'" />';
    }
}