<?php

namespace App\Mail;

use App\Models\UserPencari;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailRegisterPencariConfirm extends Mailable
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
    public function __construct(UserPencari $user, String $url)
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
