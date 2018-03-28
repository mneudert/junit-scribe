<?php

namespace JUnitScribeTest\Document;

use JUnitScribeTest\TestCase;

class CaseNodeTest extends TestCase
{
    public function testGetSuiteByName()
    {
        /** @var \JUnitScribe\Document\SuiteNode $suite */
        $document = $this->getFixtureDocument();
        $suites   = $document->getSuites();
        $suite    = $suites[0];

        $this->assertNotNull($suite->getCaseByName('JUnitScribe.Test'));
        $this->assertNull($suite->getCaseByName('no one wants to find a test case'));
    }
}
