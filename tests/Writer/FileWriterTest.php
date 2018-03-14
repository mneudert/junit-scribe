<?php

namespace JUnitScribeTest\Writer;

use JUnitScribe\Document;
use JUnitScribe\Writer\FileWriter;
use JUnitScribeTest\TestCase;

class FileWriterTest extends TestCase
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
        $writer->setDocument($this->getFixtureDocument());

        $this->assertTrue($writer->write());
        $this->assertTrue(file_exists($tempname));

        unlink($tempname);
    }

    public function testDocumentWithoutSuites()
    {
        $tempname = tempnam(sys_get_temp_dir(), 'junit-scribe-');
        $writer   = new FileWriter();
        $writer->setOutputFileName($tempname);
        $writer->setDocument($this->getFixtureDocument());

        $this->assertTrue($writer->write());
        $this->assertEquals($this->getFixtureOutput(), join('', file($tempname)));

        unlink($tempname);
    }
}
