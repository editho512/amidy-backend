<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subject;
    public $vue;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $subject, String $vue, Array $data)
    {
        $this->subject = $subject;
        $this->vue = $vue;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('mail.' . $this->vue)->with($this->data);
    }
}
