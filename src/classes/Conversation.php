<?php

/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 14.11.2016
 * Time: 14:05
 */
class Conversation
{
    // conversion_state[] > conversion_id > id
    public $id;

    // conversion_state[] > conversation_state > participant_data[] > fallback_name
    public $participant;

    public $messages = [];
}