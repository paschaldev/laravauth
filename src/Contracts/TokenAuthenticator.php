<?php

namespace PaschalDev\Laravauth\Contracts;

use Illuminate\Http\Request;

interface TokenAuthenticator{

	/**
    * Performs the authorization logic and logs the user in.
    *
    * @param \Illuminate\Http\Request $request
    * @return mixed
    */
	function __construct(Request $request);

	/**
    * Performs the authorization logic and logs the user in.
    *
    * @return mixed
    */
	function auth();

	/**
    * Confirms the login.
    *
    * @return mixed
    */
	function login();

	/**
    * Retrieves a single user model
    *
    * @param \Illuminate\Http\Request $request
    * @return void
    */
	function setUser(Request $request);

	/**
    * Retrieves a single user model
    *
    * @return \Illuminate\Database\Eloquent\Model | null
    */
	function getUser();

    /**
    * Token generator
    *
    * @return string
    */
    function generateToken();

    /**
    * Checks if user token hasn't expired.
    *
    * @return bool
    */
    function userTokenIsOK($user, $token);

	/**
    * Inserts the generated token to the user database
    *
    * @return mixed
    */
	function addTokenToUser();

    /**
    * The method that sends additional info to the user
    *
    * @return Response
    */
    function tokenMessenger();

    /**
     * Fetches the user to be authenticated using the token.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    function getUserToAuth();
}