<?php

namespace Component\Schema\Draw\Transform;

interface TransformInterface
{
    public function __construct($value);
    public function __toString();
    public function getValue();
    public function getCSSValue();
    public function getCSSProperty();
    public function apply($action);
}