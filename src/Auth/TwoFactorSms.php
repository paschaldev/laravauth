<?php 

namespace PaschalDev\Laravauth\Auth;

use Laravauth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PaschalDev\Laravauth\Traits\User;
use PaschalDev\Laravauth\Traits\AuthTokens;
use PaschalDev\Laravauth\Traits\UsesPassword;
use PaschalDev\Laravauth\Lib\SmsRouter\SmsRouter;
use PaschalDev\Laravauth\Contracts\TokenAuthenticator;

class TwoFactorSms implements TokenAuthenticator{

	use User, AuthTokens, UsesPassword;

	/**
     * The request object
     *
     * @var \Illuminate\Http\Request
     */
	private $request;

	/**
     * The token
     *
     * @var string
     */
	private $token;

	/**
     * Handles the first part of the authorization, valid user proceeds
     * to the next action which is the auth.
     *
     * @return mixed
     */
	public function login(){

		// If the user property is null meaning no user could be
		// evaluated from the request or (the user is not null) but
		// the password does not match teh user's in the database,
		// then its a failed attempt.
		// Return the appropriate failed logic.
		if( is_null($this->user) || ! $this->passwordMatch() )
		{
			return $this->userLoginFailed();	
		}

		// Login passed at this point. i.e User is present in 
		// database ans credentials match.
		// Add the user token to the database.
		$this->addTokenToUser();

		// Send the user SMS containing SLT (Short Lived Token).
		$this->tokenMessenger();

		// Data for responses
		$data = [
		'success' => true, 
		'laravauth_var' => route('laravauth_email_response'),
		'user_id' => $this->user->id
		];

		// If the request was expecting a JSON, probably 
		// XMLHttpRequest (Ajax).
		if ($this->request->expectsJson() ) 
		{
			return response()->json($data, 200);
		}

		return redirect()->route('laravauth_sms_response')->with($data);
	}

	/**
     * Fetches the user to be authenticated using the token.
     * Uses a slightly different approach to email_token method.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
	public function getUserToAuth(){

		$this->request->session()->regenerate();

		return Laravauth::getUserModel()->find($this->request->session()->get('user_id'));
	}

	/**
     * Generates a random token
     *
     * @return string
     */
	public function generateToken()
	{
		return str_random( config('laravauth.two_factor_sms.length') );
	}

	/**
     * The token messenger sends the generated token and login link
     * to the user's phone.
     *
     * @return Response
     */
	public function tokenMessenger()
	{
		$to = $this->user->laravauthPhone();
		$message = str_replace( '%validity%', intval( config('laravauth.two_factor_sms.lifetime') / 60 ) , config('laravauth.two_factor_sms.text_prefix') ).$this->user->{config('laravauth.token_column_name')};

		$messenger = new SmsRouter( $to, $message );
		return $messenger->send();
	}

	/**
     * Custom handler for a failed auth attempt
     *
     * @return Response
     */
	public function failedAttempt(){

		$this->request->session()->reflash();

		return redirect()->route('laravauth_sms_response');
	}
}