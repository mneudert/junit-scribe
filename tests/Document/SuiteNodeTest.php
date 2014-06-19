<?php

namespace JUnitScribeTest\Document;

use JUnitScribeTest\Testcase;

class SuiteNodeTest extends Testcase
{
    public function testGetSuiteByName()
    {
        $document = $this->getFixtureDocument();

        $this->assertNotNull($document->getSuiteByName('JUnitScribe.Suite'));
        $this->assertNull($document->getSuiteByName('no one wants to find a test suite'));
    }
}
