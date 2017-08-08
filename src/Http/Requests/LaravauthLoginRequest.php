<?php

namespace PaschalDev\Laravauth\Http\Requests;

use Auth;
use Laravauth;
use Illuminate\Foundation\Http\FormRequest;

class LaravauthLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Return true if no user is logged in
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if( config('laravauth.auth_method') == 'email_token')
        {
            return [
                Laravauth::getLoginID() => 'required|string|email'
            ];
        }

        return [
            Laravauth::getLoginID() => 'required',
            Laravauth::getPasswordID() => 'required|string'
        ];
    }
}
