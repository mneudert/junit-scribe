<?php

namespace JUnitScribe\Writer;

use JUnitScribe\Document as Document;
use JUnitScribe\Document\CaseNode;
use JUnitScribe\Document\Node;
use JUnitScribe\Document\ResultNode;
use JUnitScribe\Document\SuiteNode;

class StringWriter
{
    const INDENTATION = '  ';

    /** @var Document */
    protected $document;

    /**
     * @param   Document    $document
     * @return  $this
     */
    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * Returns formatted output for a node attribute.
     *
     * @param   string  $key
     * @param   mixed   $value
     * @return  string
     */
    public function formatAttribute($key, $value)
    {
        if (is_float($value)) {
            $value = sprintf('%.3f', $value);
        }

        return sprintf('%s="%s"', $key, $value);
    }

    /**
     * Returns formatted output for node attributes.
     *
     * @param   Node    $node
     * @return  string
     */
    public function formatAttributes($node)
    {
        $attrOutput = join(
            ' ',
            array_map(
                array($this, 'formatAttribute'),
                array_keys($node->getAttributes()),
                $node->getAttributes()
            )
        );

        if (strlen($attrOutput)) {
            $attrOutput = ' ' . $attrOutput;
        }

        return $attrOutput;
    }

    /**
     * Returns document as formatted string.
     *
     * @return  string
     */
    public function formatDocument()
    {
        return sprintf(
            "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n%s",
            $this->formatSuites()
        );
    }

    /**
     * Returns an indentation string for the test suites nesting level.
     *
     * @param   Node    $node
     * @return  string
     */
    public function formatLevelIndent($node)
    {
        return str_repeat(self::INDENTATION, $node->getLevel());
    }

    /**
     * Returns formatted output for a test case.
     *
     * @param   CaseNode    $case
     * @return  string
     */
    public function formatCase($case)
    {
        $indent     = $this->formatLevelIndent($case);
        $attributes = $this->formatAttributes($case);
        $errors     = $this->reduceResults($case->getErrors());
        $failures   = $this->reduceResults($case->getFailures());

        return sprintf(
            "%s<testcase%s>\n%s%s%s</testcase>",
            $indent,
            $attributes,
            $errors,
            $failures,
            $indent
        );
    }

    /**
     * Returns formatted output for a test result.
     *
     * @param   ResultNode  $result
     * @return  string
     */
    public function formatResult($result)
    {
        $indent      = $this->formatLevelIndent($result);
        $attributes  = $this->formatAttributes($result);
        $type        = $result->getAttribute('type');
        $messageBody = $result->getMessageBody();

        return sprintf(
            "%s<%s%s>%s</%s>",
            $indent,
            $type,
            $attributes,
            $messageBody,
            $type
        );
    }

    /**
     * Returns formatted output for a test suite.
     *
     * @param   SuiteNode   $suite
     * @return  string
     */
    public function formatSuite($suite)
    {
        $indent     = $this->formatLevelIndent($suite);
        $attributes = $this->formatAttributes($suite);
        $cases      = $this->reduceCases($suite->getCases());
        $suites     = $this->reduceSuites($suite->getSuites());

        return sprintf(
            "%s<testsuite%s>\n%s%s%s</testsuite>",
            $indent,
            $attributes,
            $cases,
            $suites,
            $indent
        );
    }

    /**
     * Returns formatted output for all test suites.
     *
     * @return  string
     */
    public function formatSuites()
    {
        $attributes = $this->formatAttributes($this->document);
        $suites     = $this->reduceSuites($this->document->getSuites());

        return sprintf(
            "<testsuites%s>\n%s</testsuites>",
            $attributes,
            $suites
        );
    }

    /**
     * Reduction trigger for test cases.
     *
     * @param   CaseNode[]  $cases
     * @return  string
     */
    protected function reduceCases($cases)
    {
        if (!count($cases)) {
            return '';
        }

        return array_reduce(
            $cases,
            array($this, 'reduceFormatCase'),
            ''
        );
    }

    /**
     * Reduction trigger for test results.
     *
     * @param   ResultNode[]    $results
     * @return  string
     */
    protected function reduceResults($results)
    {
        if (!count($results)) {
            return '';
        }

        return array_reduce(
            $results,
            array($this, 'reduceFormatResult'),
            ''
        );
    }

    /**
     * Reduction trigger for test suites.
     *
     * @param   SuiteNode[]     $suites
     * @return  string
     */
    protected function reduceSuites($suites)
    {
        if (!count($suites)) {
            return '';
        }

        return array_reduce(
            $suites,
            array($this, 'reduceFormatSuite'),
            ''
        );
    }

    /**
     * Reduction method to format a test case.
     *
     * @param   string      $output
     * @param   CaseNode    $case
     * @return  string
     */
    protected function reduceFormatCase($output, $case)
    {
        $caseOutput = $this->formatCase($case);

        if (strlen($caseOutput)) {
            $caseOutput .= "\n";
        }

        return $output . $caseOutput;
    }

    /**
     * Reduction method to format a test result.
     *
     * @param   string      $output
     * @param   ResultNode  $result
     * @return  string
     */
    protected function reduceFormatResult($output, $result)
    {
        $resultOutput = $this->formatResult($result);

        if (strlen($resultOutput)) {
            $resultOutput .= "\n";
        }

        return $output . $resultOutput;
    }

    /**
     * Reduction method to format a test suite.
     *
     * @param   string      $output
     * @param   SuiteNode   $suite
     * @return  string
     */
    protected function reduceFormatSuite($output, $suite)
    {
        $suiteOutput = $this->formatSuite($suite);

        if (strlen($suiteOutput)) {
            $suiteOutput .= "\n";
        }

        return $output . $suiteOutput;
    }
}
