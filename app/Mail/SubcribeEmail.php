<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubcribeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $title;
    public $content;

    public function __construct($email, $title, $content)
    {
        $this->title = $title;
        $this->email = $email;
        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         // subject: 'Subcribe my blog',
    //         subject: $this->title,
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'emails.suscribe' ,
    //     );
    // }

    function build() {
        return $this->subject($this->title)->view('emails.suscribe');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
