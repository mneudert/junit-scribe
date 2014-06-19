<?php

use JUnitScribe\Document;

$document = new Document();
$document
    ->addSuite()
        ->setName('JUnitScribe.Suite')
        ->addCase()
            ->setName('JUnitScribe.Test')
            ->setAssertions(0)
            ->getParent()
        ->addCase()
            ->setClass('JUnitScribe.Test.Class')
            ->setAssertions(2)
            ->setTime(0.223)
            ->getParent()
        ->addSuite()
            ->addCase()
                ->setAssertions(5)
                ->getParent()
            ->getParent()
        ->getParent()
    ->addSuite()
        ->addCase()
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
        ->addCase()
            ->setAssertions(13)
            ->setTime(1.334)
            ->addFailure()
                ->setMessage('secondary failure attribute')
                ->setMessageBody('secondary failure body');

return $document;