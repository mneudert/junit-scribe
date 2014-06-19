<?php

namespace JUnitScribeTest\Document;

use JUnitScribeTest\Testcase;

class SuiteNodeTest extends Testcase
{
    public function testGetTestsuiteByName()
    {
        $document = $this->getFixtureDocument();

        $this->assertNotNull($document->getTestsuiteByName('JUnitScribe.Suite'));
        $this->assertNull($document->getTestsuiteByName('no one wants to find a testsuite'));
    }
}
