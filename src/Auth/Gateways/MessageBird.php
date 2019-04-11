<?php

namespace PaschalDev\Laravauth\Auth\Gateways;

use PaschalDev\Laravauth\Contracts\TwoFactorSmsGateway;

class MessageBird implements TwoFactorSmsGateway
{
    /**
     * Uses MessageBird's API to send texts to user's phone.
     *
     * @param string $to
     * @param string $message
     * @return mixed
     */
    public function send($to, $message)
    {
        return app('messagebird')->messages->create([
            'originator' => env('MESSAGEBIRD_FROM'),
            'recipients' => [$to],
            'body' => $message
        ]);
    }
}
