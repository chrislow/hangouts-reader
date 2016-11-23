<?php
require_once ("Conversation.php");
require_once ("Message.php");

/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 14.11.2016
 * Time: 14:07
 */
class HangoutReader
{
    private $user_id;
    private $conversations = [];

    /**
     * HangoutReader constructor.
     * @param $conversations
     */
    public function __construct()
    {
        // read the file content
        $content = $this->readFile();

        // convert the json string to an array
        // find conversations
        $this->findConversations(json_decode($content));

        $this->storeConversations($this->conversations);
    }

    /**
     * Reads the hangouts json file and returns its contents
     * @return bool|string
     */
    private function readFile(){
        $file = file_get_contents($_SERVER['DOCUMENT_ROOT']."/hangout-reader/json/Hangouts.json");
        if($file === false){
            return false;
        }
        return $file;
    }

    /**
     * Returns all conversations and its messages
     * @return bool|string
     */
    public function getConversations()
    {
        return $this->conversations;
    }


    /**
     * Fills the conversation[] with conversations.
     * @param $conversations
     * @internal param $content [] array parsed from json string
     */
    private function findConversations($conversations){

        foreach ($conversations->conversation_state as $conversation){
            $this->user_id = $conversation->conversation_state->conversation->self_conversation_state->self_read_state->participant_id->gaia_id;

            // Create and fill the conversation object
            $c = new Conversation();
            $c->id = $conversation->conversation_id->id;
            $c->participant = $conversation->conversation_state->conversation->participant_data[0]->fallback_name;

            // Find messages of a conversation
            $c->messages = $this->findMessages($conversation);

            array_push($this->conversations, $c);
        }
    }

    /**
     * Finds all messages sent in a conversation
     * @param $conversation
     * @return array
     */
    private function findMessages($conversation){
        $messages = [];
        // Find all messages for a conversation
        foreach($conversation->conversation_state->event as $event){
            if($event->event_type === "REGULAR_CHAT_MESSAGE"){
                $text = $event->chat_message->message_content->segment[0]->text;
                $timestamp = $event->timestamp;
                $sender_id = $event->sender_id->gaia_id;
                array_push($messages, new Message($text, $timestamp, $sender_id));
            }
        }
        return $messages;
    }

    /**
     * Saves all conversations into a new .json file
     */
    private function storeConversations(){
        $fp = fopen($_SERVER['DOCUMENT_ROOT']."/hangout-reader/json/built/conversations.json", "w");
        fwrite($fp, json_encode([
            "user_id" => $this->user_id,
            "conversations" => $this->conversations
        ]));
        fclose($fp);
    }
}