<?php

namespace JUnitScribeTest\Document;

use JUnitScribeTest\Testcase;

class CaseNodeTest extends Testcase
{
    public function testGetTestsuiteByName()
    {
        /** @var \JUnitScribe\Document\SuiteNode $testsuite */
        $document  = $this->getFixtureDocument();
        $testsuite = $document->getTestsuites()[0];

        $this->assertNotNull($testsuite->getTestcaseByName('JUnitScribe.Test'));
        $this->assertNull($testsuite->getTestcaseByName('no one wants to find a testcase'));
    }
}
