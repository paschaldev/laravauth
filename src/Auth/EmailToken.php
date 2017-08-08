<?php 

namespace PaschalDev\Laravauth\Auth;

use Mail;
use Laravauth;
use Illuminate\Http\Request;
use PaschalDev\Laravauth\Traits\User;
use PaschalDev\Laravauth\Traits\AuthTokens;
use PaschalDev\Laravauth\Mail\EmailTokenSent;
use PaschalDev\Laravauth\Contracts\TokenAuthenticator;

class EmailToken implements TokenAuthenticator{

	use User, AuthTokens;

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
	public function login()
	{
		// If the user property is empty meaning no user could be
		// evaluated from the request then its a failed attempt.
		// Return the appropriate failed logic.
		if( is_null($this->user) )
		{
			return $this->userLoginFailed();	
		}

		// Login passed at this point. i.e User is present in 
		// database.
		// Add the user token to the database.
		$this->addTokenToUser();

		// Send the user email containing login link.
		$this->tokenMessenger();

		// Data for responses
		$data = [
		'success' => true, 
		'laravauth_var' => route('laravauth_email_response')
		];

		// If the request was expecting a JSON, probably 
		// XMLHttpRequest (Ajax).
		if ($this->request->expectsJson() ) 
		{
			return response()->json($data, 200);
		}

		return redirect()->route('laravauth_email_response')->with($data);
	}

	/**
     * Fetches the user to be authenticated using the token.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
	public function getUserToAuth(){

		return Laravauth::getUserModel()
			->where( config('laravauth.token_column_name'), $this->token )
			->where( config('laravauth.token_type_column_name'), config('laravauth.auth_method') )
			->first();
	}

	/**
     * Generates a secure token
     *
     * Check http://php.net/manual/en/function.hash-hmac.php 
     * for more info about the hash_mac PHP function.
     *
     * @return string
     */
	public function generateToken()
	{
		return hash_hmac( config('laravauth.email_token.algorithm') , 
			str_random( config('laravauth.email_token.length') ), config('app.key') );
	}

	/**
     * The token messenger sends the generated token and login link
     * to the user's email. Uses Laravel Queue system.
     *
     * @return Response
     */
	public function tokenMessenger()
	{
		return Mail::to( $this->user )->queue( new EmailTokenSent($this->user) );
	}
}