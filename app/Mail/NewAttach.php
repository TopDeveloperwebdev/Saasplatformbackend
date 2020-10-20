<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewAttach extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
 
    protected $attachments_file;


    public function __construct($title, $attachments_file)
    {
        $this->title = $title;     
        $this->attachments_file = $attachments_file;     
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mail@base.care') 
        ->replyTo('mail@base.care')          
        ->subject($this->title)
        ->view('sendattach')
        ->attachData(base64_decode($this->attachments_file), "verordnung.pdf", [
            'mime' => 'application/pdf',
        ]);
        
    }
}
