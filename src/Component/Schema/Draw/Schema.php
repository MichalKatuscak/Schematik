<?php

namespace Component\Schema\Draw;

use Component\Schema\Draw\Element\ElementInterface;
use Component\Schema\Draw\Transform\Rotate;
use Component\Schema\Draw\Transform\TransformInterface;

final class Schema
{
    private $schema;
    private $size;
    private $lines;
    private $geo;
    private $zastup;
    private $functions;
    /**
     * @var array
     */
    private $points;

    public function __construct(array $size, array $lines, array $points, array $geo, array $zastup, array $functions)
    {
        $schema = [];
        foreach ($points as $point) {
            $schema[$point[0]."_".$point[1]] = $point[2];
        }

        $this->schema = $schema;
        $this->size = $size;
        $this->lines = $lines;
        $this->geo = $geo;
        $this->zastup = $zastup;
        $this->functions = $functions;
        $this->points = $points;
    }
    
    public function getSVG()
    {
        $schema = $this->schema;
        $size = $this->size;
        $lines = $this->lines;
        $geo = $this->geo;
        $zastup = $this->zastup;
        $functions = $this->functions;
        $points = $this->points;

        $svg = "";
        $s = 100;

        $svg .='<svg viewBox="0 0 '.((1+$size[1])*$s+45).' '.((1+$size[0])*$s+45).'" style="width:100%;height:auto">';
        foreach ($lines as $key=>$line) {
            $x1 = $line[0][0]+0.16;
            $x2 = $line[1][0]+0.16;
            $y1 = $line[0][1]+0.16;
            $y2 = $line[1][1]+0.16;

            $element_before = $geo[rand(0,count($geo)-1)];
            $element_after = $element_before;

            $value = [];
            $value_on_start = $value;
            if ($x1 == $x2) { // X
                $use = 0;
            } else { // Y
                $use = 1;
            }
            
            $append_elements = [];
            for($i=1;$i<=$size[(int)!$use];$i++) {

                if (!$use) {
                    $is_exists = $line[0][0]."_".$i;
                } else {
                    $is_exists = $i."_".$line[1][1];
                }
                
                if (isset($schema[$is_exists])) {
                    $id = $schema[$is_exists];

                    if (is_array($functions[$id])) {
                        $transform_name = $functions[$id][0];
                        $transform_action = $functions[$id][1];
                    } else {
                        $transform_name = $functions[$id];
                        $transform_action = null;
                    }

                    if (in_array(TransformInterface::class, class_implements($transform_name))) {
                        if (empty($value[$transform_name])) {
                            $value[$transform_name::short_name] = new $transform_name;
                        }

                        $value[$transform_name::short_name]->apply($transform_action);
                    } elseif (in_array(ElementInterface::class, class_implements($transform_name))) {
                        $append_elements[$transform_name::short_name] = $transform_name;
                    }
                }
            }

            $svg .='<line x1="'.( $x1 * $s ).'" y1="'.($y1 * $s).'" x2="'.($x2 * $s).'" y2="'.($y2 * $s).'" style="stroke:#367fa9;stroke-width:2" />';


            $svg .= new $element_before($x1*$s, $y1*$s, "#367fa9", "white", $value_on_start);
            
            $element = new $element_after($x2*$s, $y2*$s, "#367fa9", "white", $value);
            foreach ($append_elements as $append_element) {
                $element->appendElement($append_element);
            }

            $svg .= $element;
            
            

            if ($use) {
                $svg .='<polyline fill="none" stroke="#367fa9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="
	'.($x1*$s+55).','.($y1*$s-10).' '.($x1*$s+70).','.($y1*$s).' '.($x1*$s+55).','.($y1*$s+10).'"/>';

                $svg .='<polyline fill="none" stroke="#367fa9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="
	'.($x2*$s-60).','.($y2*$s-10).' '.($x2*$s-45).','.($y2*$s).' '.($x2*$s-60).','.($y2*$s+10).'"/>';
            } else {
                $svg .='<polyline fill="none" stroke="#367fa9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="
	'.($x1*$s-10).','.($y1*$s+55).' '.($x1*$s).','.($y1*$s+70).' '.($x1*$s+10).','.($y1*$s+55).'"/>';

                $svg .='<polyline fill="none" stroke="#367fa9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="
	'.($x2*$s-10).','.($y2*$s-60).' '.($x2*$s).','.($y2*$s-45).' '.($x2*$s+10).','.($y2*$s-60).'"/>';
            }
        }

        foreach ($points as $key=>$point) {
            $svg .='<circle cx="'.($point[0]*$s+15).'" cy="'.($point[1]*$s+15).'" r="15" stroke="#367fa9" stroke-width="2" fill="white" />';
            $svg .='<text text-anchor="middle" x="'.($point[0]*$s+15).'" y="'.($point[1]*$s+20).'" fill="#367fa9" style="font-weight:bold">'.$zastup[$point[2]].'</text>';
        }

        $svg .="</svg>";
        
        return $svg;
    }

    function step_geo(&$data){
        global $geo;
        $data["geo"]++;
        if ($data["geo"] >= count($geo)) {
            $data["geo"] = 0;
        }
    }
}