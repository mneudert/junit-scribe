<?php

namespace JUnitScribeTest\Writer;

use JUnitScribe\Document;
use JUnitScribe\Writer\StringWriter;
use JUnitScribeTest\TestCase;

class StringWriterTest extends TestCase
{
    public function testDocumentOutput()
    {
        $writer = new StringWriter();
        $writer->setDocument($this->getFixtureDocument());

        $this->assertEquals(strlen($this->getFixtureOutput()), strlen($writer->formatDocument()));
    }

    public function testDocumentWithResults()
    {
        $writer = new StringWriter();
        $writer->setDocument($this->getFixtureDocument());

        $output = $writer->formatDocument();

        $this->assertNotFalse(strpos($output, 'message="error message attribute"'));
        $this->assertNotFalse(strpos($output, '>error message body<'));
        $this->assertNotFalse(strpos($output, 'errors="1"'));
        $this->assertNotFalse(strpos($output, 'message="failure message attribute"'));
        $this->assertNotFalse(strpos($output, '>failure message body<'));
        $this->assertNotFalse(strpos($output, 'failures="2"'));
    }

    public function testAttributeAssertions()
    {
        $writer = new StringWriter();
        $writer->setDocument($this->getFixtureDocument());

        $this->assertNotFalse(strpos($writer->formatDocument(), 'assertions="17"'));
    }

    public function testAttributeClass()
    {
        $writer = new StringWriter();
        $writer->setDocument($this->getFixtureDocument());

        $this->assertNotFalse(strpos($writer->formatDocument(), 'class="JUnitScribe.Test.Class"'));
    }

    public function testAttributeFile()
    {
        $writer = new StringWriter();
        $writer->setDocument($this->getFixtureDocument());

        $this->assertNotFalse(strpos($writer->formatDocument(), 'file="./tests/fixtures/document.php"'));
    }

    public function testAttributeLine()
    {
        $writer = new StringWriter();
        $writer->setDocument($this->getFixtureDocument());

        $this->assertNotFalse(strpos($writer->formatDocument(), 'line="29"'));
        $this->assertNotFalse(strpos($writer->formatDocument(), 'line="43"'));
    }

    public function testAttributeName()
    {
        $writer = new StringWriter();
        $writer->setDocument($this->getFixtureDocument());

        $output = $writer->formatDocument();

        $this->assertNotFalse(strpos($output, 'name="JUnitScribe.Suite"'));
        $this->assertNotFalse(strpos($output, 'name="JUnitScribe.Test"'));
    }

    public function testAttributeTests()
    {
        $writer = new StringWriter();
        $writer->setDocument($this->getFixtureDocument());

        $this->assertNotFalse(strpos($writer->formatDocument(), 'tests="5"'));
    }

    public function testAttributeTime()
    {
        $writer = new StringWriter();
        $writer->setDocument($this->getFixtureDocument());

        $output = $writer->formatDocument();

        $this->assertNotFalse(strpos($output, '0.223'));
        $this->assertNotFalse(strpos($output, '3.777'));
        $this->assertNotFalse(strpos($output, '4.000'));
    }
}
