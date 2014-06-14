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
}
