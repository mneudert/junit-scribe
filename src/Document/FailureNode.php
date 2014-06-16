<?php

namespace JUnitScribe\Document;

class FailureNode extends ResultNode
{
    /**
     * @return  array
     */
    public function getAttributes()
    {
        $attributes         = parent::getAttributes();
        $attributes['type'] = 'failure';

        return $attributes;
    }
}
