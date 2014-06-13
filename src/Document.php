<?php

namespace JUnitScribe;

use JUnitScribe\Writer\File as FileWriter;

class Document {
    /**
     * Writes the current document to the given file.
     *
     * @param   string  $filename
     * @return  bool
     */
    public function write($filename)
    {
        $writer = new FileWriter();

        $writer->setDocument($this);

        return $writer->write($filename);
    }
}
