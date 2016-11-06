<?php

namespace Component\Schema\Draw\Transform;

class Inversion implements TransformInterface
{
    const short_name = 'transform_inversion';
    
    private $value;
    private $css_property;

    public function __construct($default = false)
    {
        $this->value = (bool) $default;
        $this->css_property = [
            "stroke", "fill"
        ];
    }

    public function apply($null = null)
    {
        $this->value = !$this->value;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getCSSProperty()
    {
        return $this->css_property;
    }

    public function getCSSValue()
    {
        if ($this->value) {
            return ["{{ color2 }}", "{{ color1 }}"];
        }
        return ["{{ color1 }}", "{{ color2 }}"];
    }

    public function __toString()
    {
        return $this->css_property[0] . ":" . $this->getCSSValue()[0] . ";"
             . $this->css_property[1] . ":" . $this->getCSSValue()[1] . ";";
    }
}