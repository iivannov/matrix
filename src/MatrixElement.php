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


    public $status = true;

    public function __construct($structure)
    {
        if(!isset($structure->status) || $structure->status != 'OK') {
            $this->status = false;
            return false;
        }

        $this->distance = $structure->distance->value;
        $this->duration = $structure->duration->value;

        return true;
    }
}