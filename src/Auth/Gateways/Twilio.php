<?php

namespace PaschalDev\Laravauth\Auth\Gateways;

use PaschalDev\Laravauth\Contracts\TwoFactorSmsGateway;
use Twilio\Rest\Client;

class Twilio implements TwoFactorSmsGateway
{

    /**
     * Uses Nexmo API to send texts to user's phone.
     *
     * @param string $to
     * @param string $message
     * @return mixed
     */
    public function send($to, $message)
    {
        $sms = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        return $sms->messages->create($to,
            ['from' => env('TWILIO_NUMBER'), 'body' => $message]);
    }
}
