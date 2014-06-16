<?php

namespace JUnitScribe\Document;

class Testcase extends Node
{
    /**
     * @return  Testsuite
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param   string  $class
     * @return  $this
     */
    public function setClass($class)
    {
        $this->attributes['class'] = $class;
        return $this;
    }

    /**
     * @param   float|int   $time
     * @return  $this
     */
    public function setTime($time)
    {
        $this->attributes['time'] = (float) $time;
        return $this;
    }
}
