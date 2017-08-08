<?php

namespace PaschalDev\Laravauth\Traits;

use Laravauth;
use Illuminate\Http\Request;

trait User{

	/**
     * The single user model
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
	private $user;
    
	/**
     * Sets the user property.
     *
     * @param \Illuminate\Http\Request
     * @return void
     */
	function setUser(Request $request)
	{
		$this->user = Laravauth::getSingleUserModel( 
            $request->{Laravauth::getLoginID()} );
	}

	/**
     * Gets the user property on this object
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
	function getUser()
	{
		return $this->user;
	}
    
	/**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function userLoginFailed()
    {
        $errors = [Laravauth::getLoginID() => trans('auth.failed')];

        if ($this->request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($this->request->only(Laravauth::getLoginID(), 'remember'))
            ->withErrors($errors);
    }
}