<?php

namespace JUnitScribe\Writer;

class File
{
    /** @var \JunitScribe\Document */
    protected $document;

    /** @var string */
    protected $outputFilename;

    /** @var resource */
    protected $outputHandle;

    /**
     * @param   \JunitScribe\Document   $document
     * @return  $this
     * @codeCoverageIgnore
     */
    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @param   string  $filename
     * @return  $this
     * @codeCoverageIgnore
     */
    public function setOutputFilename($filename)
    {
        $this->outputFilename = $filename;
        return $this;
    }

    /**
     * Writes the configured document to the configured file.
     *
     * @return  bool
     */
    public function write()
    {
        if (empty($this->document) || empty($this->outputFilename)) {
            return false;
        }

        $this->outputHandle = fopen($this->outputFilename, 'w');

        if (!is_resource($this->outputHandle)) {
            return false;
        }

        return $this->writeDocument();
    }

    /**
     * Writes the document to the opened output file.
     *
     * @return  bool
     */
    protected function writeDocument()
    {
        return (bool) fwrite(
            $this->outputHandle,
            sprintf(
                "%s\n%s",
                '<?xml version="1.0" encoding="utf-8"?>',
                $this->formatTestsuites()
            )
        );
    }

    /**
     * Returns formatted output for Testsuites.
     *
     * @return  string
     */
    protected function formatTestsuites()
    {
        return sprintf(
            "%s\n%s",
            '<testsuites>',
            '</testsuites>'
        );
    }
}
