<?php 

namespace PaschalDev\Laravauth\Auth\Gateways;

use Aloha\Twilio\Support\Laravel\Facade as TwilioMessenger;
use PaschalDev\Laravauth\Contracts\TwoFactorSmsGateway;

class Twilio implements TwoFactorSmsGateway{

	/**
     * Uses Nexmo API to send texts to user's phone.
     *
     * @return mixed
     */
	public function send($to, $from, $message){

		return TwilioMessenger::message( $to, $message );
	}
}