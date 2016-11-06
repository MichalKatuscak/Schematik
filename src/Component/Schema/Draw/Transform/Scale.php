<?php

namespace Component\Schema\Draw\Transform;

class Scale implements TransformInterface
{
    const short_name = 'transform_scale';

    private $value;
    private $css_property;

    public function __construct($value = 0)
    {
        $this->value = (int) $value;
        $this->css_property = "transform";
    }

    public function apply($action)
    {
        $this->$action();
    }

    public function up()
    {
        if ($this->value < 1) {
            $this->value++;
        }
    }

    public function down()
    {
        if ($this->value > -1) {
            $this->value--;
        }
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
        $scale = 1;

        switch ($this->value) {
            case 1:
                $scale += 0.5;
                break;
            case -1:
                $scale -= 0.5;
                break;
        }

        return " scale(".$scale.") ";
    }

    public function __toString()
    {
        return $this->css_property . ":" . $this->getCSSValue() . ";";
    }
}