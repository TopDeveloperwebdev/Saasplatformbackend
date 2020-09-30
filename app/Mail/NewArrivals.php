<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewArrivals extends Mailable
{
    use Queueable, SerializesModels;

    protected $new_arrival;
    protected $user;

    public function __construct($user, $new_arrival)
    {
        $this->user = $user;
        $this->new_arrival = $new_arrival;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('sendmail')
                    ->subject($this->new_arrival->title)
                    ->from('scnpinside@gmail.com', 'Wonderful Company')
                    ->with([
                        'new_arrival' => $this->new_arrival,
                    ]);
        
        // return $this->from(env('MAIL_FROM', 'example@gmail.com'))
        //     ->replyTo(env('MAIL_FROM', 'example@gmail.com'))
        //     ->subject($this->new_arrival->title)
        //     ->html($this->new_arrival->body);
          
    }
}
