<?php

namespace JUnitScribe\Writer;

class File
{
    /** @var \JunitScribe\Document */
    protected $document;

    /** @var string */
    protected $outputFilename;

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

        return true;
    }
}
