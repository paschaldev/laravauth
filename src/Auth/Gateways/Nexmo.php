<?php 

namespace PaschalDev\Laravauth\Auth\Gateways;

use Nexmo\Laravel\Facade\Nexmo as NexmoMessenger;
use PaschalDev\Laravauth\Contracts\TwoFactorSmsGateway;

class Nexmo implements TwoFactorSmsGateway{

	/**
     * Uses Nexmo API to send texts to user's phone.
     *
     * @param string $to 
     * @param string $message
     * @return mixed
     */
	public function send($to, $message){

		return NexmoMessenger::message()->send([

				'to' => $to,
				'from' => env('NEXMO_FROM', config('app.name')),
				'text' => $message
			]);
	}
}