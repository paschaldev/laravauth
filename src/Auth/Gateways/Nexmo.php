<?php 

namespace PaschalDev\Laravauth\Auth\Gateways;

use Nexmo\Laravel\Facade\Nexmo as NexmoMessenger;
use PaschalDev\Laravauth\Contracts\TwoFactorSmsGateway;

class Nexmo implements TwoFactorSmsGateway{

	/**
     * Uses Nexmo API to send texts to user's phone.
     *
     * @return mixed
     */
	public function send($to, $from, $message){

		return NexmoMessenger::message()->send([

				'to' => $to,
				'from' => $from,
				'text' => $message
			]);
	}
}