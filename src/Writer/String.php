<?php

namespace JUnitScribe\Writer;

use JUnitScribe\Document as JUnitDocument;
use JUnitScribe\Document\Testcase as JUnitTestcase;
use JUnitScribe\Document\Testsuite as JUnitTestsuite;

class String
{
    /** @var JUnitDocument */
    protected $document;

    /**
     * @param   JUnitDocument   $document
     * @return  $this
     * @codeCoverageIgnore
     */
    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * Returns document as formatted string.
     *
     * @returns string
     */
    public function formatDocument()
    {
        return sprintf(
            "%s\n%s",
            '<?xml version="1.0" encoding="utf-8"?>',
            $this->formatTestsuites()
        );
    }

    /**
     * Returns an indentation string for the testsuites nesting level.
     *
     * @param   JUnitTestsuite  $testsuite
     * @return  string
     */
    protected function formatLevelIndent($testsuite)
    {
        return str_repeat('  ', $testsuite->getLevel());
    }

    /**
     * Returns formatted output for a testcase.
     *
     * @param   JUnitTestcase   $testcase
     * @return  string
     */
    protected function formatTestcase($testcase)
    {
        $indent = $this->formatLevelIndent($testcase);

        return sprintf(
            "%s\n%s",
            $indent . '<testcase>',
            $indent . '</testcase>'
        );
    }

    /**
     * Returns formatted output for a testsuite.
     *
     * @param   JUnitTestsuite  $testsuite
     * @return  string
     */
    protected function formatTestsuite($testsuite)
    {
        $indent = $this->formatLevelIndent($testsuite);

        return sprintf(
            "%s\n%s%s%s",
            $indent . '<testsuite>',
            $this->reduceTestcases($testsuite->getTestcases()),
            $this->reduceTestsuites($testsuite->getTestsuites()),
            $indent . '</testsuite>'
        );
    }

    /**
     * Returns formatted output for all testsuites.
     *
     * @return  string
     */
    protected function formatTestsuites()
    {
        return sprintf(
            "%s\n%s%s",
            '<testsuites>',
            $this->reduceTestsuites($this->document->getTestsuites()),
            '</testsuites>'
        );
    }

    /**
     * Reduction trigger for testcases.
     *
     * @param   JunitTestcase[]     $testcases
     * @return  string
     */
    protected function reduceTestcases($testcases)
    {
        if (!count($testcases)) {
            return '';
        }

        return array_reduce(
            $testcases,
            array($this, 'reduceFormatTestcase'),
            ''
        );
    }

    /**
     * Reduction trigger for testsuites.
     *
     * @param   JUnitTestsuite[]    $testsuites
     * @return  string
     */
    protected function reduceTestsuites($testsuites)
    {
        if (!count($testsuites)) {
            return '';
        }

        return array_reduce(
            $testsuites,
            array($this, 'reduceFormatTestsuite'),
            ''
        );
    }

    /**
     * Reduction method to format a testcase.
     *
     * @param   string          $output
     * @param   JunitTestcase   $testcase
     * @return  string
     */
    protected function reduceFormatTestcase($output, $testcase)
    {
        $caseOutput = $this->formatTestcase($testcase);

        if (strlen($caseOutput)) {
            $caseOutput .= "\n";
        }

        return $output . $caseOutput;
    }

    /**
     * Reduction method to format a testsuite.
     *
     * @param   string          $output
     * @param   JUnitTestsuite  $testsuite
     * @return  string
     */
    protected function reduceFormatTestsuite($output, $testsuite)
    {
        $suiteOutput = $this->formatTestsuite($testsuite);

        if (strlen($suiteOutput)) {
            $suiteOutput .= "\n";
        }

        return $output . $suiteOutput;
    }
}
