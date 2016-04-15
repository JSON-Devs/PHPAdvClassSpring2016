<?php
/**
 * Description of Messages
 *
 * @author JAYGAGS
 */
class Message implements IMessage {
    
    protected $message = [];
    public function addMessage($key, $msg) {
        $this->message[$key] = $msg;
    }
    
    public function removeMessage($key) {
        unset($this->message[$key]);
    }
    
    public function getAllMessages() {
        return $this->message;
    }
}
