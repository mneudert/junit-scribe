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
        $errors     = 0;
        $failures   = 0;
        $time       = 0;

        if (count($this->cases)) {
            foreach ($this->cases as $case) {
                $errors   += $case->getAttribute('errors');
                $failures += $case->getAttribute('failures');
                $time     += (float) $case->getAttribute('time');
            }
        }

        if (count($this->suites)) {
            foreach ($this->suites as $suite) {
                $errors   += $suite->getAttribute('errors');
                $failures += $suite->getAttribute('failures');
                $tests    += $suite->getAttribute('tests');
                $time     += $suite->getAttribute('time');
            }
        }

        if (0 < $errors) {
            $attributes['errors'] = $errors;
        }

        if (0 < $failures) {
            $attributes['failures'] = $failures;
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

    /**
     * Returns a nested testsuite if given name matches.
     *
     * @param   string  $name
     * @return  SuiteNode
     */
    public function getTestsuiteByName($name)
    {
        foreach ($this->suites as $suite) {
            if ($name === $suite->getAttribute('name')) {
                return $suite;
            }
        }

        return null;
    }
}
