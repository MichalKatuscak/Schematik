<?php

namespace Component\Schema\Draw\Element;

class Rectangle extends BaseElement
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

        $rect = '<rect  x="'.($x-15).'" y="'.($y-15).'" width="30" height="30" style="'.$style.'"/>';

        return $rect . $this->appends;
    }
}