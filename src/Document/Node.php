<?php

namespace JUnitScribe\Document;

abstract class Node
{
    /** @var array */
    protected $attributes = array();

    /** @var int */
    protected $level = 0;

    /** @var Node */
    protected $parent;

    /**
     * Constructor.
     *
     * @param   Node    $parent     (optional) parent node
     */
    public function __construct($parent = null)
    {
        $this->parent = $parent;

        if (null !== $parent) {
            $this->level = 1 + $parent->getLevel();
        }
    }

    /**
     * @param   string  $name
     * @return  mixed
     * @codeCoverageIgnore
     */
    public function getAttribute($name)
    {
        $attributes = $this->getAttributes();

        if (!isset($attributes[$name])) {
            return null;
        }

        return $attributes[$name];
    }

    /**
     * @return  array
     * @codeCoverageIgnore
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return  int
     * @codeCoverageIgnore
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return  Node
     * @codeCoverageIgnore
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param   string  $name
     * @return  $this
     * @codeCoverageIgnore
     */
    public function setName($name)
    {
        $this->attributes['name'] = $name;
        return $this;
    }
}
