<?php

namespace Component\Schema\Draw\Transform;

class Rotate implements TransformInterface
{
    const short_name = 'transform_rotate';

    private $value;
    private $css_property;
    
    public function __construct($value = 0)
    {
        $this->value = (int) $value;
        $this->css_property = "transform";
    }

    public function apply($action = 90)
    {
        $this->value += $action;
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
        return " rotate(".$this->value."deg) ";
    }

    public function __toString()
    {
        return $this->css_property . ":" . $this->getCSSValue() . ";";
    }
}