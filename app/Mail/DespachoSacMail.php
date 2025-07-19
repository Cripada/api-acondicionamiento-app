<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DespachoSacMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filePath;

    /**
     * Crear una nueva instancia de mensaje.
     * @param  string  $filePath
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Construir el mensaje.
     *
     * @return $this
     */
    public function build()
    {
        $fullPath = storage_path('app/private/' . $this->filePath);

        if (!empty($this->filePath) && file_exists($fullPath)) {
            return $this->subject('PDF de Guías de Despacho')
                        ->view('emails.despacho-sac')
                        ->attach($fullPath, [
                            'as' => basename($this->filePath),
                            'mime' => 'application/pdf',
                        ]);
        } else {
            //\Log::error("Archivo no encontrado o inaccesible: " . $fullPath);
            return $this->subject('PDF de Guías de Despacho')
                        ->view('emails.despacho-sac');
        }

    }
}
