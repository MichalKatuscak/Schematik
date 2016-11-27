<?php

namespace Component\Schema\Draw\Element;

use Component\Schema\Draw\Transform\Rotate;

class LineVertical extends BaseElement
{
    const short_name = 'element_linevertical';

    public function __toString()
    {
        $x = $this->x;
        $y = $this->y;
        $color1 = $this->color1;
        $color2 = $this->color2;
        $transforms = $this->transforms;

        if (empty($transforms[Rotate::short_name])) {
            $transforms[Rotate::short_name] = new Rotate();
        } else {
            $transforms[Rotate::short_name] = clone $transforms[Rotate::short_name];
        }
        $transforms[Rotate::short_name]->apply(90);

        $x1 = 14;
        if (Star::class === $this->parent) {
            $x1 = 10;
        }

        $style = "stroke:$color1;";
        $style .= $this->generateStyle($transforms);
        $style .= "transform-origin: ".($x)."px ".($y)."px;stroke-width:2;";

        return '<line data-name="vert" stroke-linecap="round" stroke-linejoin="round" x1="'.($x+$x1).'" y1="'.($y).'" x2="'.($x-$x1).'" y2="'.($y).'"  style="'.$style.'" />';
    }
}