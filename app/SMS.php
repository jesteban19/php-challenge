<?php
namespace App;


class SMS
{

    private $from;
    private $to;
    private $body;

    function __construct($from,$to,$body){
        $this->from = $from;
        $this->to = $to;
        $this->body = $body;

    }
    public function getTo(){
        return $this->to;
    }
    public function send(){
        return !empty($this->to);
    }

}