<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuenMatKhau extends Mailable
{
    use Queueable, SerializesModels;

    protected $link;

    public function __construct($link)
    {
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject('Khôi phục tài khoản của bạn')
                    ->view('client.mail.quen_mat_khau', [
                        'link'  => $this->link
                    ]);
    }
}
