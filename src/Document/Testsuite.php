<?php

namespace JUnitScribe\Document;

class Testsuite
{
    /** @var int */
    protected $level = 0;

    /** @var Testsuite */
    protected $parent;

    /** @var Testsuite[] */
    protected $suites = array();

    /**
     * Constructor.
     *
     * @param   Testsuite   $parent     (optional) parent testsuite
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
     * @return  Testsuite
     * @codeCoverageIgnore
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Creates a nested testsuite.
     *
     * @return  Testsuite
     */
    public function addTestsuite()
    {
        $suite          = new Testsuite($this);
        $this->suites[] = $suite;

        return $suite;
    }

    /**
     * Returns all nested testsuites.
     *
     * @return  Testsuite[]
     */
    public function getTestsuites()
    {
        return $this->suites;
    }
}
