<?php 


class Bot{
    private readonly string $botName;
    private $update;
    
    public function __construct($botName){
        $this->botName = $botName;
    }

    public function start(){
        $this->update = $this->getUpdate();
      
        if (!$this->update) {
          // didn't receive new messages, doesn't do anything
          exit;
        }
        
        if (isset($this->update["message"])) {
          $this->processMessage($this->update["message"]);
        }
    }

    private function getUpdate(){
        $response = file_get_contents('php://input');
        $update = json_decode($response, true);
        return $update;
    }


    private function processMessage($message) {
        $chat_id = $message['chat']['id'];

        if (isset($message['text'])) {
            $text = $message['text'];//text received in message
      
            if (strpos($text, "/start") === 0) {
                $this->sendStartMessage($message);
            }
            else {
                $this->sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "Sorry, I didn't understand the message. :("));
            }
        }
        else { //if your bot will work with other message types, you should remove this
            $this->sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => "Sorry, I only understand text messages. :("));
        }
    }

    private function sendStartMessage($message){
        $chat_id = $message['chat']['id'];

        $startMessage = "Hi, {$message['from']['first_name']}! My name is $this->botName. [Welcome message here]";

        $this->sendMessage("sendMessage", array('chat_id' => $chat_id, "text" => $startMessage));
    }
      
    private function sendMessage($method, $parameters) {
        $options = array(
        'http' => array(
          'method'  => 'POST',
          'content' => json_encode($parameters),
          'header'=>  "Content-Type: application/json\r\n" .
                      "Accept: application/json\r\n"
          )
        );
      
        $context  = stream_context_create( $options );
        file_get_contents(API_URL.$method, false, $context );
    }

    
    public function setWebhook(){
        $method = 'setWebhook';
        $response = file_get_contents(API_URL.$method.'?url='.WEBHOOK_URL);
    
        var_dump($response);
    }

    public function deleteWebhook(){
        $method = 'deleteWebhook';
        $response = file_get_contents(API_URL.$method);
        var_dump($response);
    }

}