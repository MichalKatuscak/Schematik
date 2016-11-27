<?php

namespace Component\Schema\Draw\Element;

use Component\Schema\Draw\Transform\Rotate;
use Component\Schema\Draw\Transform\TransformInterface;

abstract class BaseElement implements ElementInterface
{
    /**
     * @var float
     */
    protected $x;

    /**
     * @var float
     */
    protected $y;

    /**
     * @var string
     */
    protected $color1;

    /**
     * @var string
     */
    protected $color2;

    /**
     * @var array|TransformInterface[]
     */
    protected $transforms;

    protected $appends;
    
    protected $parent;

    public function __construct($x, $y, $color1 = "black", $color2 = "white", array $transforms = [], $parent = null)
    {
        $this->x = $x;
        $this->y = $y;
        $this->color1 = $color1;
        $this->color2 = $color2;
        $this->transforms = $transforms;
        $this->appends = "";
        $this->parent = $parent;
    }

    public function appendElement($appendElement)
    {
        $x = $this->x;
        $y = $this->y;
        $color1 = $this->color1;
        $color2 = $this->color2;
        $transforms = $this->transforms;

        $this->appends .= new $appendElement($x, $y, $color1, $color2, $transforms, get_class($this));
    }

    public function generateStyle($transforms)
    {
        $style = "";

        $css = $this->generateCSS($transforms);

        foreach ($css as $css_property => $css_values) {
            $style .= $css_property . ":" . implode(" ", $css_values) . ";";
        }

        if ($this->parent) {
            $style = str_replace("{{ color1 }}", "{{ color2 }}", $style);
        }

        $style = str_replace([
            "{{ color1 }}",
            "{{ color2 }}"
        ], [
            $this->color1,
            $this->color2,
        ], $style);

        return $style;
    }

    public function generateCSS($transforms)
    {
        $css = [];

        foreach ($transforms as $transform) {
            $css_property = $transform->getCSSProperty();
            $css_value = $transform->getCSSValue();

            if (is_array($css_property) && is_array($css_value)) {
                for ($i = 0; $i<count($css_property); $i++) {
                    if (empty($css[$css_property[$i]])) {
                        $css[$css_property[$i]] = [];
                    }

                    $css[$css_property[$i]][] = $css_value[$i];
                }
            } else {
                if (empty($css[$css_property])) {
                    $css[$css_property] = [];
                }

                $css[$css_property][] = $css_value;
            }

        }

        return $css;
    }
}