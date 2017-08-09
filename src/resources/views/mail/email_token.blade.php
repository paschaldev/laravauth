@component('mail::message')
# Login

Here is the link to login to your {{config('app.name')}} account. This link is valid for {{ intval( config('laravauth.two_factor_sms.lifetime') / 60 ) }} minutes and can only be used once.

@component('mail::button', ['url' => $url])
Login
@endcomponent

If the button is not clickable, copy and paste this in your browser. {{ $url }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
