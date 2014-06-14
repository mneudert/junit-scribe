<?php

namespace JUnitScribe\Document;

abstract class Node
{
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
}
