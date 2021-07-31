<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Order;

class TransactionConfirmMail extends Mailable
{
    protected $invoice;
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = Order::with(['orderDetail.product'])
            ->where('invoice', $this->invoice)
            ->first();
        return $this->subject('Konfirmasi Pesanan Anda')
            ->view('email.confirm')
            ->with(['order' => $order]);
    }
}
