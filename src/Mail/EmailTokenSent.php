<?php

namespace PaschalDev\Laravauth\Mail;

use Laravauth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailTokenSent extends Mailable
{
    use Queueable, SerializesModels;

    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->url = Laravauth::getValidatorURI().$user->{config('laravauth.token_column_name')};
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('laravauth::mail.email_token')
            ->subject( str_replace('%appname%', config('app.name'), config('laravauth.email_token.mail_subject')) );
    }
}
