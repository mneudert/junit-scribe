<?php

namespace JUnitScribeTest;

use JUnitScribe\Document;

class DocumentTest extends Testcase
{
    public function testInstantiation()
    {
        $document = $this->getFixtureDocument();

        $this->assertEquals('JUnitScribe\\Document', get_class($document));
    }
}
