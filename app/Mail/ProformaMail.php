<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProformaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filePath;
    public $proforma;

    /**
     * Crear una nueva instancia de mensaje.
     * @param  string  $filePath
     * @return void
     */
    public function __construct($filePath, $proforma)
    {
        $this->filePath = $filePath;
        $this->proforma = $proforma;
    }

    /**
     * Construir el mensaje.
     *
     * @return $this
     */
    public function build()
    {
        $fullPath = storage_path('app/private/' . $this->filePath);
        $email = $this->subject('Proforma de servicios – CRIPADA S.A.')
            ->view('emails.proformas')
            ->from('apps@cripada.com', 'CRIPADA S.A. - SERVICIO AL CLIENTE')
            ->replyTo('apps@cripada.com')
            ->with([
                'cliente' => $this->proforma->cliente->nombre_comercial,
                'proforma' => $this->proforma,
            ]);

        if (!empty($this->filePath) && file_exists($fullPath)) {
            $email->attach($fullPath, [
                'as' => basename($this->filePath),
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}
