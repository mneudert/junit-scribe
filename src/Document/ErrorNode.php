<?php

namespace JUnitScribe\Document;

class ErrorNode extends ResultNode
{
    /**
     * @return  array
     */
    public function getAttributes()
    {
        $attributes         = parent::getAttributes();
        $attributes['type'] = 'error';

        return $attributes;
    }
}
