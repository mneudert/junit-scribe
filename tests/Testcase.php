<?php

namespace JUnitScribeTest;

class Testcase extends \PHPUnit_Framework_TestCase
{
    protected function getFixtureDocument()
    {
        return require __DIR__ . '/fixtures/document.php';
    }
}
