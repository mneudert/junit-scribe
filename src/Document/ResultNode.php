<?php

namespace JUnitScribe\Document;

class ResultNode extends Node
{
    /** @var string */
    protected $body;

    /**
     * @param   string  $message
     * @return  $this
     */
    public function setMessage($message)
    {
        $this->attributes['message'] = $message;
        return $this;
    }

    /**
     * @return  string
     */
    public function getMessageBody()
    {
        return $this->body;
    }

    /**
     * @param   string  $body
     * @return  $this
     */
    public function setMessageBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return  CaseNode
     */
    public function getParent()
    {
        return $this->parent;
    }
}
