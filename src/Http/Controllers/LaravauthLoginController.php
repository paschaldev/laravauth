<?php 

namespace PaschalDev\Laravauth\Http\Controllers;

use Laravauth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PaschalDev\Laravauth\Http\Requests\LaravauthLoginRequest;

class LaravauthLoginController extends Controller
{
	/**
     * Transfers the login control to the appropriate method
     * depending on the 'auth_method' chosen.
     *
     * @return void
     */
	public function login(LaravauthLoginRequest $request){
        
        return Laravauth::getAuthMethodInstance( $request )->login();
    }

    /**
     * Validates an authentication request, if successful, logs
     * the user in.
     *
     * @return mixed
     */
    public function authenticate(Request $request){

        return Laravauth::getAuthMethodInstance( $request )->auth();
    }

    /**
     * Returns the view after email has been provided when using
     * the email_token auth method.
     *
     * This method rejects & aborts a request if the URL is 
     * accessed directly.
     *
     * @return void
     */
    public function emailResponse(Request $request){

        abort_unless( $request->session()->has('Laravauth_var'), 404);

        return view('Laravauth::email_response');
    }

    /**
     * Returns the view after login when using the two_factor_sms 
     * auth method.
     *
     * This method rejects & aborts a request if the URL is 
     * accessed directly.
     *
     * @return void
     */
    public function smsResponse(Request $request){

        abort_unless( $request->session()->has('Laravauth_var'), 404);

        $request->session()->reflash();

        return view('Laravauth::sms_response');
    }
}