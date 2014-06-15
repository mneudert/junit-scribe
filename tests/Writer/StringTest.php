<?php

namespace JUnitScribeTest\Writer;

use JUnitScribe\Document as JUnitDocument;
use JUnitScribe\Writer\String as StringWriter;

class StringTest extends \PHPUnit_Framework_TestCase
{
    public function testDocumentWithNestedTestsuites()
    {
        $writer   = new StringWriter();
        $document = new JUnitDocument();

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
        $document = new JUnitDocument();

        $document
            ->addTestsuite()
                ->addTestcase();

        $writer->setDocument($document);

        $this->assertCount(7, explode("\n", $writer->formatDocument()));
    }

    public function testAttributeClass()
    {
        $writer   = new StringWriter();
        $document = new JUnitDocument();
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
        $document  = new JUnitDocument();
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
        $document = new JUnitDocument();

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
}
