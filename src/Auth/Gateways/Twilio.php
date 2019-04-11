<?php

namespace PaschalDev\Laravauth\Auth\Gateways;

use PaschalDev\Laravauth\Contracts\TwoFactorSmsGateway;

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
        return app('twilio')->messages->create($to,
            ['from' => env('TWILIO_FROM'), 'body' => $message]);
    }
}
