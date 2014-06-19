<?php

namespace JUnitScribeTest\Document;

use JUnitScribeTest\Testcase;

class SuiteNodeTest extends Testcase
{
    public function testFindSuiteByName()
    {
        $document = $this->getFixtureDocument();

        $this->assertNotNull($document->findSuiteByName('JunitScribe.NestedSuite'));
        $this->assertNull($document->findSuiteByName('no one wants to find a test suite'));
    }

    public function testGetSuiteByName()
    {
        $document = $this->getFixtureDocument();

        $this->assertNotNull($document->getSuiteByName('JUnitScribe.Suite'));
        $this->assertNull($document->getSuiteByName('no one wants to find a test suite'));
    }
}
