<?php

class SMSSender
{
    public function sendSMS($to, $message)
    {
        // It can be sent using some gatteway
        // $smsGateway = new SMSGateway('some_key');
        // $smsGateway->sendMessage($to, $message);
    }
}