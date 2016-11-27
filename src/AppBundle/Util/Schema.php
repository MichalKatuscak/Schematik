<?php

namespace AppBundle\Util;

use Component\Schema\Draw\Element\Circle;
use Component\Schema\Draw\Element\LineHorizontal;
use Component\Schema\Draw\Element\LineVertical;
use Component\Schema\Draw\Element\Rectangle;
use Component\Schema\Draw\Element\Star;
use Component\Schema\Draw\Element\Triangle;
use Component\Schema\Draw\Transform\Inversion;
use Component\Schema\Draw\Transform\Rotate;
use Component\Schema\Draw\Transform\Scale;
use Component\Schema\Generator\RandomeGenerator;

class Schema
{
    private $schema;

    public function __construct($level = 1)
    {
        /**
         * May be use Component\Schema\Draw\Transform or Component\Schema\Draw\Element
         */
        $functions = [
            [Scale::class, "up"],
            [Scale::class, "down"],
            LineHorizontal::class,
            LineVertical::class,
            Inversion::class, //"step_geo"
        ];

        $zastup = [
            "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"
        ];

        $geo = [
            Triangle::class,
            Star::class,
            Rectangle::class,
            Circle::class,
        ];

        if ($level > 1) {
            $functions[] = [Rotate::class, 90];
        }

        $generator = new RandomeGenerator($level, $functions, $zastup, $geo);
        $schema = $generator->render();

        $this->schema = $schema;
    }

    public function __toString()
    {
        return (string) $this->schema["data"];
    }

    public function getSchema()
    {
        return $this->schema;
    }

}
