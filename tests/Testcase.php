<?php

namespace JUnitScribeTest;

class Testcase extends \PHPUnit_Framework_TestCase
{
    protected function getFixtureDocument()
    {
        return require __DIR__ . '/fixtures/document.php';
    }
    protected function getFixtureOutput()
    {
        return join('', file(__DIR__ . '/fixtures/document.xml'));
    }
}
