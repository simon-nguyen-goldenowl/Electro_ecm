<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $data;
    public $key;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $key)
    {
        $this->data = $data;
        $this->key = $key;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'electro.it@gmail.com';
        $name = 'Electro Admin';
        return $this->view('Pages.SendResetMail')
                    ->from($address, $name)
                    ->to($this->data->email, $this->data->username)
                    ->subject('Reset Email')
                    ->with([
                        'user_name' => $this->data->username,
                        'links' => 'http://127.0.0.1:8000/password/reset/' . $this->data->id . '?key=' . $this->key
                    ]);
    }
}
