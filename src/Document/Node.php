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
     * Abstract getParent method to force correct code-completion.
     *
     * @return Node
     */
    abstract function getParent();

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
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return  int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param   string  $name
     * @return  $this
     */
    public function setName($name)
    {
        $this->attributes['name'] = $name;
        return $this;
    }
}
