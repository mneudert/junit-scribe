<?php

use JUnitScribe\Document;

$document = new Document();
$document
    ->addTestsuite()
        ->setName('JUnitScribe.Suite')
        ->addTestcase()
            ->setName('JUnitScribe.Test')
            ->setAssertions(0)
            ->getParent()
        ->addTestcase()
            ->setClass('JUnitScribe.Test.Class')
            ->setAssertions(2)
            ->setTime(0.223)
            ->getParent()
        ->addTestsuite()
            ->addTestcase()
                ->setAssertions(5)
                ->getParent()
            ->getParent()
        ->getParent()
    ->addTestsuite()
        ->addTestCase()
            ->setAssertions(17)
            ->setTime(2.443)
            ->addError()
                ->setMessage('error message attribute')
                ->setMessageBody('error message body')
                ->getParent()
            ->addFailure()
                ->setMessage('failure message attribute')
                ->setMessageBody('failure message body')
                ->getParent()
            ->getParent()
        ->addTestcase()
            ->setAssertions(13)
            ->setTime(1.334)
            ->addFailure()
                ->setMessage('secondary failure attribute')
                ->setMessageBody('secondary failure body');

return $document;