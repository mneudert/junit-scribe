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

        $lines = explode("\n", $writer->formatDocument());

        $this->assertCount(9, $lines);
        $this->assertEquals(
            array(1 => 5, 2 => 2),
            array_count_values(array_values(array_count_values($lines)))
        );
    }
}
