<?php

namespace App\Mail;

use App\Models\UserPemilik;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class MailRegisterPemilikConfirm extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Pendaftaran Infokos';
    public $user;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserPemilik $user, String $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('register.confirmation', [
            'url' => $this->url,
            'user' => $this->user,
        ]);
    }
}
