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
    protected $instanceEmail;


    public function __construct($title, $body, $instanceEmail)
    {
        $this->title = $title;
        $this->body = $body;
        $this->instanceEmail = $instanceEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->instanceEmail, $this->instanceEmail)
            ->replyTo($this->instanceEmail)
            ->subject($this->title)
            ->view('sendmail')
            ->with([
                'emailTemplate' => $this->body
            ]);
    }
}
