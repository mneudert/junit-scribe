<?php

namespace JUnitScribeTest\Writer;

use JUnitScribe\Document;
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
        $writer->setDocument(new Document());

        $this->assertFalse($writer->write());
    }

    public function testFileCreatedUponWrite()
    {
        $tempname = tempnam(sys_get_temp_dir(), 'junit-scribe-');
        $writer   = new FileWriter();
        $writer->setOutputFileName($tempname);
        $writer->setDocument(new Document());

        $this->assertTrue($writer->write());
        $this->assertTrue(file_exists($tempname));

        unlink($tempname);
    }

    public function testDocumentWithoutTestsuites()
    {
        $tempname = tempnam(sys_get_temp_dir(), 'junit-scribe-');
        $writer   = new FileWriter();
        $writer->setOutputFileName($tempname);
        $writer->setDocument(new Document());

        $this->assertTrue($writer->write());
        $this->assertCount(3, file($tempname));

        unlink($tempname);
    }
}
