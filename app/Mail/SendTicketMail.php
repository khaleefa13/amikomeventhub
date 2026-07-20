<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    // Menangkap data transaksi dari controller saat pembayaran sukses
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
    {
        return $this->subject('E-Ticket Resmi AmikomEventHub - ' . $this->transaction->event->nama_event)
                    ->view('emails.ticket_notification');
    }
}