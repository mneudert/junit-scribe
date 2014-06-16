<?php

namespace JUnitScribe\Document;

class SuiteNode extends Node
{
    /** @var CaseNode[] */
    protected $cases = array();

    /** @var SuiteNode[] */
    protected $suites = array();

    /**
     * Adds a testcase.
     *
     * @return  CaseNode
     */
    public function addTestcase()
    {
        $case          = new CaseNode($this);
        $this->cases[] = $case;

        return $case;
    }

    /**
     * Creates a nested testsuite.
     *
     * @return  SuiteNode
     */
    public function addTestsuite()
    {
        $suite          = new SuiteNode($this);
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
        $time       = 0;

        if (count($this->cases)) {
            foreach ($this->cases as $case) {
                $time += (float) $case->getAttribute('time');
            }
        }

        if (count($this->suites)) {
            foreach ($this->suites as $suite) {
                $tests += $suite->getAttribute('tests');
                $time  += $suite->getAttribute('time');
            }
        }

        if (0 < $tests) {
            $attributes['tests'] = $tests;
        }

        if (0 < $time) {
            $attributes['time'] = $time;
        }

        return $attributes;
    }

    /**
     * @return  SuiteNode
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Returns all testcases.
     *
     * @return  CaseNode[]
     */
    public function getTestcases()
    {
        return $this->cases;
    }

    /**
     * Returns all nested testsuites.
     *
     * @return  SuiteNode[]
     */
    public function getTestsuites()
    {
        return $this->suites;
    }
}
