<?php 

namespace PaschalDev\Laravauth\Lib\SmsRouter;

/**
* Sms router for Laravel Laravauth Package.
*
* @author Ezeugwu Paschal <ezeugwupaschal@gmail.com>
*/
class SmsRouter
{

	/**
     * The Phone number the sms is to be sent to.
     *
     * @var string
     */
	private $to;

	/**
     * The source where the SMS came from.
     *
     * @var string
     */
	private $from;

	/**
     * The text message to be sent.
     *
     * @var string
     */
	private $message;
	

	public function __construct($to, $from, $message)
	{
		$this->setTo($to);
		$this->setFrom($from);
		$this->setMessage($message);
	}

	/**
     * Sets the $to property on this class
     *
     * @param string
     * @return void
     */
	public function setTo($to){

		$this->to = $to;
	}

	/**
     * Returns the $to property
     *
     * @return string
     */
	public function getTo(){

		return $this->to;
	}

	/**
     * Sets the $from property.
     *
     * @param string
     * @return void
     */
	public function setFrom($from){

		$this->from = $from;
	}

	/**
     * Returns the from property
     *
     * @return string
     */
	public function getFrom(){

		return $this->from;
	}

	/**
     * Sets the message property.
     *
     * @param string
     * @return void
     */
	public function setMessage($message){

		$this->message = $message;
	}

	/**
     * Returns the message
     *
     * @return string
     */
	public function getMessage(){

		return $this->message;
	}

	/**
     * Send SMS to user after choosing the appropriate gateway.
     *
     * @return mixed
     */
	public function send(){

		return $this->gateway()->send( $this->getTo(), $this->getFrom(), $this->getMessage() );
	}

	/**
     * Fetches the appropriate gateway to use.
     *
     * @return PaschalDev\Laravauth\Contracts\TwoFactorSmsGateway
     */
	public function gateway(){

		$gateway = laravauth_class_namespace( 'Auth\Gateways', config('laravauth.two_factor_sms.gateway') ) ;

		return new $gateway;
	}
}