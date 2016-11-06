<?php

namespace Component\Schema\Generator;

interface GeneratorInterface
{
    public function __construct($level, array $functions, array $zastup, array $geo);

    public function render();
}