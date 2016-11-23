<?php

/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 14.11.2016
 * Time: 15:33
 */
class Message
{
    public $text;
    public $timestamp;
    public $sender_id;

    /**
     * Message constructor.
     * @param $text
     * @param $timestamp
     */
    public function __construct($text, $timestamp, $sender_id)
    {
        $this->text = $text;
        $this->timestamp = $timestamp;
        $this->sender_id = $sender_id;
    }


}