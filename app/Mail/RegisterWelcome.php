<?php

namespace Test\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterWelcome extends Mailable
{
    use Queueable, SerializesModels;

    private $user_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_user_name)
    {
        $this->user_name=$_user_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.registerwelcome')
                    ->subject('به ترافیک بوست خوش آمدید')
                    ->with([
                      'user_name'=>$this->user_name
                    ]);
    }
}
