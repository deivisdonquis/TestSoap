<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailPagoNotificacion extends Mailable
{
    use Queueable, SerializesModels;

    public $idsesion;
    public $token;
    public $monto;

    public function __construct($idsesion,$token,$monto)
    {
        $this->idsesion= $idsesion;
        $this->token= $token;
        $this->monto= $monto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notificacion de Pago (Billetera Virtual)')->view('mails.EmailPagoNotificacion');
    }
}
