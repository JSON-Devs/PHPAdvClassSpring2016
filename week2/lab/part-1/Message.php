<?php
/**
 * Description of Messages
 *
 * @author 001349718
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
