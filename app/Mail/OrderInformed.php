<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderInformed extends Mailable
{
    use Queueable, SerializesModels;
    public $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject('Subject: New order is placed.')->view('emails.orders.informed')->with('content', $this->content);
    }
}
