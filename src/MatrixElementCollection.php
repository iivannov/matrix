<?php

namespace Iivannov\Matrix;

use ArrayIterator;
use Traversable;

class MatrixElementCollection implements \Countable, \IteratorAggregate
{
    /**
     * Pointer to the current element
     * @var int
     */
    protected $index = 0;

    /**
     * Array of MatrixElement
     * @var array
     */
    protected $elements;


    public static function make($response)
    {
        $instance = new self();

        foreach ($response->rows as $row) {
            foreach ($row->elements as $element) {
                $instance->elements[] = new MatrixElement($element);
            }
        }

        return $instance;
    }


    /**
     * Returns the current element and moves the pointer to the next one
     * @return mixed
     */
    public function next()
    {
        return $this->elements[$this->index++];
    }

    /**
     * Sets the iteration index to the firs element
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * Get the first item from the collection.
     * @return mixed
     */
    public function first()
    {
        return current($this->elements);
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->elements);
    }

}