<?php

namespace JUnitScribe\Document;

class SuiteNode extends Node
{
    /** @var CaseNode[] */
    protected $cases = array();

    /** @var SuiteNode[] */
    protected $suites = array();

    /**
     * Adds a test case.
     *
     * @return  CaseNode
     */
    public function addCase()
    {
        $case          = new CaseNode($this);
        $this->cases[] = $case;

        return $case;
    }

    /**
     * Creates a nested test suite.
     *
     * @return  SuiteNode
     */
    public function addSuite()
    {
        $suite          = new SuiteNode($this);
        $this->suites[] = $suite;

        return $suite;
    }

    /**
     * Finds the first test suite having the given name.
     *
     * @param   string  $name
     * @return  SuiteNode
     */
    public function findSuiteByName($name)
    {
        $suite = $this->getSuiteByName($name);

        if (null !== $suite) {
            return $suite;
        }

        foreach ($this->suites as $nested) {
            $suite = $nested->getSuiteByName($name);

            if (null !== $suite) {
                break;
            }
        }

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
     * Returns all test cases.
     *
     * @return  CaseNode[]
     */
    public function getCases()
    {
        return $this->cases;
    }

    /**
     * Returns a nested test case if given name matches.
     *
     * @param   string  $name
     * @return  CaseNode
     */
    public function getCaseByName($name)
    {
        foreach ($this->cases as $case) {
            if ($name === $case->getAttribute('name')) {
                return $case;
            }
        }

        return null;
    }

    /**
     * Returns all nested test suites.
     *
     * @return  SuiteNode[]
     */
    public function getSuites()
    {
        return $this->suites;
    }

    /**
     * Returns a nested test suite if given name matches.
     *
     * @param   string  $name
     * @return  SuiteNode
     */
    public function getSuiteByName($name)
    {
        foreach ($this->suites as $suite) {
            if ($name === $suite->getAttribute('name')) {
                return $suite;
            }
        }

        return null;
    }
}
