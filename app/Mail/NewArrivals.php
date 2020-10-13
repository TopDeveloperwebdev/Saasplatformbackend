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
     protected $name;


    public function __construct($title, $body, $instanceEmail , $name)
    {
        $this->title = $title;
        $this->body = $body;
        $this->instanceEmail = $instanceEmail;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->instanceEmail, $this->name)
            ->replyTo($this->instanceEmail)
            ->subject($this->title)
            ->view('sendmail')
            ->with([
                'emailTemplate' => $this->body
            ]);
    }
}
