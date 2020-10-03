<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewArrivals extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $body;
   


    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
     
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM', 'example@gmail.com'))
            ->replyTo(env('MAIL_FROM', 'example@gmail.com'))
            ->subject($this->title)
            ->view('sendmail')
            ->with([
                'emailTemplate' => $this->body                
            ]);
    }
}
