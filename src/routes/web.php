<?php 

if( ! config('laravauth.soft_disable') )
{
	Route::group(['middleware' => ['web']], function () {

		$login_route = config('laravauth.login_route');
		$validator_route = config('laravauth.validator_route');

		Route::post($login_route, 'PaschalDev\Laravauth\Http\Controllers\LaravauthLoginController@login')->middleware('guest');
		Route::match(['GET', 'POST'], $validator_route, 'PaschalDev\Laravauth\Http\Controllers\LaravauthLoginController@authenticate')->middleware('guest');

		Route::get($login_route.'/email', 'PaschalDev\Laravauth\Http\Controllers\LaravauthLoginController@emailResponse')->middleware('guest')->name('laravauth_email_response');

		Route::get($login_route.'/sms', 'PaschalDev\Laravauth\Http\Controllers\LaravauthLoginController@smsResponse')->middleware('guest')->name('laravauth_sms_response');
	});
}