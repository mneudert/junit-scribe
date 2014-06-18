<?php

use JUnitScribe\Document;

$document = new Document();
$document
    ->addTestsuite()
        ->addTestcase()->getParent()
        ->addTestcase()->getParent()
        ->addTestsuite()
            ->addTestcase()->getParent()
        ->getParent()
    ->getParent()
    ->addTestsuite()
        ->addTestCase()->getParent();

return $document;