<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use \Datetime;
use Illuminate\Support\Str;

class ForgetPassword extends Mailable
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
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $now = new DateTime();
        return  [
            $this->subject('CHANGE YOUR ACCOUNT PASSWORD'),
            $this->from('vimmixticket@gmail.com', 'Vista Global Consult'),
            $this->to($this->details['emailTo']),
            $this->markdown('emails.ForgetEmail', [
                'object' =>  $this->details['object'],
                // 'password_url' => 'http://localhost:8080/login?password=' . $this->details['expireTime'],
                'password_url' => 'http://localhost:8080/forget_password?uId=' . Str::random(120) . '&fId=' . $this->details['passwordToken'] . '&upId=' . $this->details['expireTime'] * 850 . '&pId=' . $this->details['expireTime'] . '&uId=' . $this->details['expireTime'] * 150 . '&ulsId=' . $this->details['expireTime'] * 450 . '&wId=' . Str::random(220) . '&zId=' . Str::random(120),
            ]),
        ];
    }
}
