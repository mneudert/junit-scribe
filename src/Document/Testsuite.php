<?php

namespace JUnitScribe\Document;

class Testsuite extends Node
{
    /** @var Testcase[] */
    protected $cases = array();

    /** @var Testsuite[] */
    protected $suites = array();

    /**
     * Adds a testcase.
     *
     * @return  Testcase
     */
    public function addTestcase()
    {
        $case          = new Testcase($this);
        $this->cases[] = $case;

        return $case;
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
     * Returns node attributes including (lazily) calculated ones.
     *
     * @return  array
     * @see     Node::getAttributes()
     */
    public function getAttributes()
    {
        $attributes = parent::getAttributes();
        $tests      = count($this->cases);

        if (count($this->suites)) {
            foreach ($this->suites as $suite) {
                $tests += $suite->getAttribute('tests');
            }
        }

        if (0 < $tests) {
            $attributes['tests'] = $tests;
        }

        return $attributes;
    }

    /**
     * Returns all testcases.
     *
     * @return  Testcase[]
     */
    public function getTestcases()
    {
        return $this->cases;
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
