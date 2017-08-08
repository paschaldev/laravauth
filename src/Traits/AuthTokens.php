<?php

namespace PaschalDev\Laravauth\Traits;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait AuthTokens{

    /**
     * Constructor. 
     * Sets the user property & request on this object.
     *
     * @param \Illuminate\Http\Request
     */
    public function __construct(Request $request)
    {   
        $this->request = $request;
        $this->token = $this->request->{laravauth_token_var_name()};
        $this->setUser( $this->request );
    }

    /**
     * Adds a token to the user model DB
     *
     * @return mixed
     */
    public function addTokenToUser(){

        $this->user->{config('laravauth.token_column_name')} = $this->generateToken();
        $this->user->{config('laravauth.token_type_column_name')} = config('laravauth.auth_method');
        $this->user->{config('laravauth.token_column_name').'_created_at'} = Carbon::now();

        return $this->user->save();
    }

    /**
     * Remove token from user
     *
     * @return mixed
     */
    public function removeTokenFromUser($user){

        $user->{config('laravauth.token_column_name')} = null;
        $user->{config('laravauth.token_type_column_name')} = null;
        $user->{config('laravauth.token_column_name').'_created_at'} = null;

        return $user->save();
    }

    /**
     * Determines if the user token is still active for use. 
     *
     * @return bool
     */
    public function userTokenIsOK($user, $token)
    {   
        $tokenCreated = Carbon::parse( $user->{config('laravauth.token_column_name').'_created_at'} );

        return $user->{config('laravauth.token_column_name')} == $token 
            && Carbon::now()->diffInSeconds( $tokenCreated ) < config('laravauth.'.config('laravauth.auth_method').'.lifetime');
    }

    /**
     * The main Login logic. Handles incoming token request, 
     * validates the token and logs the user in.
     *
     * @return Response
     */
    public function auth()
    {
        //Fetch user model from token
        $user = $this->getUserToAuth();

        // If the $user variable is null or the token is 
        // inavlid \ expired. Show the false_token page.
        if( ! $user || ! $this->userTokenIsOK( $user, $this->token ) )
        {
            return method_exists($this, 'failedAttempt') ? 
                $this->failedAttempt() : response()->view('laravauth::false_token');
        }

        // All good. $user variable is not null and the token is valid
        // Proceed to log in the user. 
        Auth::login($user);

        // Clear the tokens
        $this->removeTokenFromUser( $user );

        return redirect( config('laravauth.auth_redirect') );
    }
}