<?php

namespace JUnitScribeTest\Document;

use JUnitScribeTest\Testcase;

class CaseNodeTest extends Testcase
{
    public function testGetSuiteByName()
    {
        /** @var \JUnitScribe\Document\SuiteNode $suite */
        $document = $this->getFixtureDocument();
        $suite    = $document->getSuites()[0];

        $this->assertNotNull($suite->getCaseByName('JUnitScribe.Test'));
        $this->assertNull($suite->getCaseByName('no one wants to find a test case'));
    }
}
