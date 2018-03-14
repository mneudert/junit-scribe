<?php

namespace JUnitScribe\Writer;

class FileWriter extends StringWriter
{
    /** @var string */
    protected $outputFilename;

    /** @var resource */
    protected $outputHandle;

    /**
     * @param   string  $filename
     * @return  $this
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

        return (bool) fwrite(
            $this->outputHandle,
            $this->formatDocument()
        );
    }
}
