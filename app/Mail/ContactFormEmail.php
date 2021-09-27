<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $message;
    
    protected $contactName;
    
    protected $contactEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactEmail, $contactName, $message)
    {
        $this->contactEmail = $contactEmail;
        $this->contactName = $contactName;
        $this->message = $message;    
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from(config('mail.username'), $this->contactName)
            ->replyTo($this->contactEmail)
            ->subject('New message from contact form on blog');
        
        
        return $this->view('front.emails.contact_form')
            ->with([
                'contactName' => $this->contactName,
                'contactMessage' => $this->message,
            ]);
    }
}
