<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;


class commentMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;

        // return $this->details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return  [
            $this->subject($this->details['object']['document_id'] . '# COMMENT RECEVIED'),
            $this->from('vms.vistag@gmail.com', 'Vista Global Consult'),
            $this->to($this->details['emailTo']),
            $this->markdown('emails.commentMail', [
                'sendBy' =>  Auth::user()->name,
                'document_id' =>  $this->details['object']['document_id'],
                'message' =>  $this->details['comment'],
            ]),
        ];
    }
}
