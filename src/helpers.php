<?php

function laravauth_token_var_name(){

	return config('laravauth.token_var');
}

function laravauth_class_format($string){

	return ucfirst( camel_case( $string ) );
}

function laravauth_class_namespace($namespace_prefix, $class){

	$full_namespace = 'PaschalDev\Laravauth\\'.$namespace_prefix.'\\'.laravauth_class_format($class);

	if( ! class_exists($full_namespace) )
	{
		throw new \Exception("Laravauth: An error occured. Could not instantiate a required class. Make sure your configurations are correct.", 1);
	}

	return $full_namespace;
}