<?php

namespace JUnitScribeTest\Writer;

use JUnitScribe\Document;
use JUnitScribe\Writer\String as StringWriter;

class StringTest extends \PHPUnit_Framework_TestCase
{
    public function testDocumentWithNestedTestsuites()
    {
        $writer   = new StringWriter();
        $document = new Document();

        $document
            ->addTestsuite()
                ->addTestsuite()
                    ->getParent()
                ->addTestsuite();

        $writer->setDocument($document);

        $this->assertCount(9, explode("\n", $writer->formatDocument()));
    }

    public function testDocumentWithTestcase()
    {
        $writer   = new StringWriter();
        $document = new Document();

        $document
            ->addTestsuite()
                ->addTestcase();

        $writer->setDocument($document);

        $this->assertCount(7, explode("\n", $writer->formatDocument()));
    }

    public function testDocumentWithResults()
    {
        $writer   = new StringWriter();
        $document = new Document();

        $document
            ->addTestsuite()
                ->addTestcase()
                    ->addFailure()
                        ->getParent()
                    ->getParent()
                ->addTestcase()
                    ->addError()
                        ->setMessage('error message attribute')
                        ->setMessageBody('error message body')
                        ->getParent()
                    ->addFailure()
                        ->setMessage('failure message attribute')
                        ->setMessageBody('failure message body');

        $writer->setDocument($document);

        $output = $writer->formatDocument();

        $this->assertNotFalse(strpos($output, 'error message attribute'));
        $this->assertNotFalse(strpos($output, 'error message body'));
        $this->assertNotFalse(strpos($output, 'errors="1"'));
        $this->assertNotFalse(strpos($output, 'failure message attribute'));
        $this->assertNotFalse(strpos($output, 'failure message body'));
        $this->assertNotFalse(strpos($output, 'failures="2"'));
    }

    public function testAttributeAssertions()
    {
        $writer   = new StringWriter();
        $document = new Document();

        $document
            ->addTestsuite()
                ->addTestcase()
                    ->setAssertions(27);

        $writer->setDocument($document);

        $this->assertNotFalse(strpos($writer->formatDocument(), '27'));
    }

    public function testAttributeClass()
    {
        $writer   = new StringWriter();
        $document = new Document();
        $class    = uniqid();

        $document
            ->addTestsuite()
                ->addTestcase()
                    ->setClass($class);

        $writer->setDocument($document);

        $this->assertNotFalse(strpos($writer->formatDocument(), $class));
    }

    public function testAttributeName()
    {
        $writer    = new StringWriter();
        $document  = new Document();
        $suiteName = uniqid();
        $caseName  = uniqid();

        $document
            ->addTestsuite()
                ->setName($suiteName)
                ->addTestcase()
                    ->setName($caseName);

        $writer->setDocument($document);

        $output = $writer->formatDocument();

        $this->assertNotFalse(strpos($output, $suiteName));
        $this->assertNotFalse(strpos($output, $caseName));
    }

    public function testAttributeTests()
    {
        $writer   = new StringWriter();
        $document = new Document();

        $document
            ->addTestsuite()
                ->addTestcase()->getParent()
                ->addTestcase()->getParent()
                ->addTestsuite()
                    ->addTestcase()->getParent()
                    ->getParent()
                ->getParent()
            ->addTestsuite()
                ->addTestCase()->getParent();

        $writer->setDocument($document);

        $output = $writer->formatDocument();

        $this->assertNotFalse(strpos($output, '4'));
        $this->assertNotFalse(strpos($output, '3'));
        $this->assertNotFalse(strpos($output, '1'));
    }

    public function testAttributeTime()
    {
        $writer   = new StringWriter();
        $document = new Document();

        $document
            ->addTestsuite()
                ->addTestcase()
                    ->setTime(5)
                    ->getParent()
                ->addTestcase()
                    ->setTime(0.234)
                    ->getParent()
                ->getParent()
            ->addTestsuite()
                ->addTestcase()
                    ->setTime(4.766);

        $writer->setDocument($document);

        $output = $writer->formatDocument();

        $this->assertNotFalse(strpos($output,  '5.000'));
        $this->assertNotFalse(strpos($output,  '0.234'));
        $this->assertNotFalse(strpos($output,  '5.234'));
        $this->assertNotFalse(strpos($output,  '4.766'));
        $this->assertNotFalse(strpos($output, '10.000'));
    }
}
