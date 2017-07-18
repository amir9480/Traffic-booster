<?php

namespace Test\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PassReset extends Mailable
{
    use Queueable, SerializesModels;

    private $username;
    private $name;
    private $user_id;
    private $user_session;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_username,$_name,$_user_id,$_user_session)
    {
        $this->username       =$_username;
        $this->name           =$_name;
        $this->user_id        =$_user_id;
        $this->user_session   =$_user_session;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.passreset')
        ->subject('افزایش ترافیک رایگان سایت - یادآوری رمز عبور')
        ->with([
            'username'=>    $this->username,
            'name'=>        $this->name,
            'user_id'=>     $this->user_id,
            'user_session'=>$this->user_session
        ]);
    }
}
