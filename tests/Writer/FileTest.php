<?php

namespace JUnitScribeTest\Writer;

use JUnitScribe\Document as JUnitDocument;
use JUnitScribe\Writer\File as FileWriter;

class FileTest extends \PHPUnit_Framework_TestCase
{
    public function testNeverSuccesfulWithoutDocument()
    {
        $writer = new FileWriter();
        $writer->setOutputFilename('ignored');

        $this->assertFalse($writer->write());
    }

    public function testNeverSuccessfulWithoutOutputFilename()
    {
        $writer = new FileWriter();
        $writer->setDocument(new JUnitDocument());

        $this->assertFalse($writer->write());
    }
}
