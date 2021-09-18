<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
class Mtr extends Mailable
{
      use Queueable, SerializesModels;

    private $file_pah;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file_pah)
    {
        $this->file_pah = $file_pah;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = date('Y-m-d');
        $user = Auth::user();
        $this->subject('Balanço '.$date);
        $contato = $user->contato;
        $this->to($contato->email, $user->name);
        return $this->view(
            'emailMtr',
            [
                'user' => $user,
                'contato' => $contato,
            ]
        )->attach('https://www.apis.enginydigitaleco.com/systematic_review/public/storage/'.$this->file_pah);
    }
}
