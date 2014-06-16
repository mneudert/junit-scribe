<?php

namespace JUnitScribeTest;

use JUnitScribe\Document;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiation()
    {
        $document = new Document();

        $this->assertEquals('JUnitScribe\\Document', get_class($document));
    }
}
