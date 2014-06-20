<?php

namespace JUnitScribe\Document;

class CaseNode extends Node
{
    /** @var ErrorNode[] */
    protected $errors = array();

    /** @var FailureNode[] */
    protected $failures = array();

    /**
     * @return  ErrorNode
     */
    public function addError()
    {
        $error          = new ErrorNode($this);
        $this->errors[] = $error;

        return $error;
    }

    /**
     * @return  FailureNode
     */
    public function addFailure()
    {
        $failure          = new FailureNode($this);
        $this->failures[] = $failure;

        return $failure;
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
        $errors     = count($this->errors);
        $failures   = count($this->failures);

        if (0 < $errors) {
            $attributes['errors'] = $errors;
        }

        if (0 < $failures) {
            $attributes['failures'] = $failures;
        }

        return $attributes;
    }

    /**
     * @return  ErrorNode[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return  FailureNode[]
     */
    public function getFailures()
    {
        return $this->failures;
    }

    /**
     * @return  SuiteNode
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param   int     $assertions
     * @return  $this
     */
    public function setAssertions($assertions)
    {
        $this->attributes['assertions'] = (int) $assertions;
        return $this;
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
     * @param   int     $line
     * @return  $this
     */
    public function setLine($line)
    {
        $this->attributes['line'] = (int) $line;
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
