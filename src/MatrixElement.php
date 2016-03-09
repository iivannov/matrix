<?php

namespace Iivannov\Matrix;


final class MatrixElement
{
    /**
     * Distance in meters
     * @var int
     */
    public $distance;

    /**
     * Travel time in seconds
     * @var int
     */
    public $duration;

    public function __construct($structure)
    {
        $this->distance = $structure->distance->value;
        $this->duration = $structure->duration->value;
    }
}