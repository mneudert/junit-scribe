# JUnit Scribe

Utility to write JUnit XML Documents.


## Installation

Installation can be done using composer:

```json
{
    "require": {
        "mneudert/junit-scribe": "dev-master"
    }
}
```

Or simply include in using your favorite autoloading solution.


## Usage

```php
use JUnitScribe\Document;
use JUnitScribe\Writer\StringWriter;

$document = new Document();
$document
    ->addSuite()
        ->setName('SuiteAllOk')
        ->addCase()
            ->setName('SomeAssertions')
            ->setAssertions(10)
            ->setTime(0.1236)
            ->getParent()
        ->addCase()
            ->setName('MoreAssertiongs')
            ->setAssertions(7)
            ->setTime(0.2242)
            ->getParent()
        ->getParent()
    ->addSuite()
        ->setName('SuiteNotOk')
        ->addCase()
            ->setName('HasError')
            ->setAssertions(9)
            ->setTime(1.4424)
            ->addError()
                ->setMessage('An Error Occurred.')
                ->setMessageBody('Some lengthy stacktrace or message body for the error.')
                ->getParent()
            ->getParent()
        ->addCase()
            ->setName('HasFailure')
            ->setAssertions(7)
            ->setTime(1.0023)
            ->addFailure()
                ->setMessage('A Failure Occurred.')
                ->setMessageBody('Some lengthy stacktrace or message body for the failure.');

$writer = new StringWriter();
$writer->setDocument($document);

echo $writer->formatDocument();
```


## License

JUnitScribe is licensed under the MIT License - see the `LICENSE` file for details.
