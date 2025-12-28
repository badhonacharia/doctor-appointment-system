<?php
require __DIR__ . '/../vendor/twilio/src/Twilio/autoload.php';
require __DIR__ . '/../config/env.php';

use Twilio\Rest\Client;

function sendSMS($to, $message) {
    $sid   = getenv('TWILIO_SID');
    $token = getenv('TWILIO_TOKEN');
    $from  = getenv('TWILIO_FROM');

    try {
        $client = new Client($sid, $token);
        $client->messages->create($to, [
            'from' => $from,
            'body' => $message
        ]);
        return true;
    } catch (Exception $e) {
        return false;
    }
}