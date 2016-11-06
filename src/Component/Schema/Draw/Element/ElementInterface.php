<?php

namespace Component\Schema\Draw\Element;

interface ElementInterface
{
    public function __construct($x, $y, $color1, $color2, array $transforms);
    public function __toString();
}