<?php

namespace JUnitScribe\Writer;

use JUnitScribe\Document as Document;
use JUnitScribe\Document\CaseNode;
use JUnitScribe\Document\Node;
use JUnitScribe\Document\ResultNode;
use JUnitScribe\Document\SuiteNode;

class String
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
                function($key, $value) {
                    if (is_float($value)) {
                        $value = sprintf('%.3f', $value);
                    }

                    return sprintf('%s="%s"', $key, $value);
                },
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
            $this->formatTestsuites()
        );
    }

    /**
     * Returns an indentation string for the testsuites nesting level.
     *
     * @param   Node    $node
     * @return  string
     */
    public function formatLevelIndent($node)
    {
        return str_repeat(self::INDENTATION, $node->getLevel());
    }

    /**
     * Returns formatted output for a testcase.
     *
     * @param   CaseNode    $testcase
     * @return  string
     */
    public function formatTestcase($testcase)
    {
        $indent     = $this->formatLevelIndent($testcase);
        $attributes = $this->formatAttributes($testcase);
        $errors     = $this->reduceTestresults($testcase->getErrors());
        $failures   = $this->reduceTestresults($testcase->getFailures());

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
     * Returns formatted output for a testresult.
     *
     * @param   ResultNode  $testresult
     * @return  string
     */
    public function formatTestresult($testresult)
    {
        $indent      = $this->formatLevelIndent($testresult);
        $attributes  = $this->formatAttributes($testresult);
        $type        = $testresult->getAttribute('type');
        $messageBody = $testresult->getMessageBody();

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
     * Returns formatted output for a testsuite.
     *
     * @param   SuiteNode   $testsuite
     * @return  string
     */
    public function formatTestsuite($testsuite)
    {
        $indent     = $this->formatLevelIndent($testsuite);
        $attributes = $this->formatAttributes($testsuite);
        $testcases  = $this->reduceTestcases($testsuite->getTestcases());
        $testsuites = $this->reduceTestsuites($testsuite->getTestsuites());

        return sprintf(
            "%s<testsuite%s>\n%s%s%s</testsuite>",
            $indent,
            $attributes,
            $testcases,
            $testsuites,
            $indent
        );
    }

    /**
     * Returns formatted output for all testsuites.
     *
     * @return  string
     */
    public function formatTestsuites()
    {
        $attributes = $this->formatAttributes($this->document);
        $testsuites = $this->reduceTestsuites($this->document->getTestsuites());

        return sprintf(
            "<testsuites%s>\n%s</testsuites>",
            $attributes,
            $testsuites
        );
    }

    /**
     * Reduction trigger for testcases.
     *
     * @param   CaseNode[]  $testcases
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
     * Reduction trigger for testresults.
     *
     * @param   ResultNode[]    $testresults
     * @return  string
     */
    protected function reduceTestresults($testresults)
    {
        if (!count($testresults)) {
            return '';
        }

        return array_reduce(
            $testresults,
            array($this, 'reduceFormatTestresult'),
            ''
        );
    }

    /**
     * Reduction trigger for testsuites.
     *
     * @param   SuiteNode[]     $testsuites
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
     * @param   string      $output
     * @param   CaseNode    $testcase
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
     * Reduction method to format a testresult.
     *
     * @param   string      $output
     * @param   ResultNode  $testresult
     * @return  string
     */
    protected function reduceFormatTestresult($output, $testresult)
    {
        $resultOutput = $this->formatTestresult($testresult);

        if (strlen($resultOutput)) {
            $resultOutput .= "\n";
        }

        return $output . $resultOutput;
    }

    /**
     * Reduction method to format a testsuite.
     *
     * @param   string      $output
     * @param   SuiteNode   $testsuite
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
