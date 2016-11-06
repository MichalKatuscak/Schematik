<?php

namespace Component\Schema\Draw\Element;

class Circle extends BaseElement
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
        $style .= "transform-origin: 50% 50%;";

        $circle = '<circle  cx="'.($x).'" cy="'.($y).'" r="15"  style="'.$style.'" />';

        return $circle . $this->appends;
    }
}