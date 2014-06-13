<?php

namespace JUnitScribeTest;

use JUnitScribe\Document as JUnitDocument;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiation()
    {
        $document = new JUnitDocument();

        $this->assertEquals('JUnitScribe\\Document', get_class($document));
    }
}
