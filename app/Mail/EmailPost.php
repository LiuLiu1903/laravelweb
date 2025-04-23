<?php
 
 namespace App\Mail;
 
 use Illuminate\Bus\Queueable;
 use Illuminate\Contracts\Queue\ShouldQueue;
 use Illuminate\Mail\Mailable;
 use Illuminate\Mail\Mailables\Content;
 use Illuminate\Mail\Mailables\Envelope;
 use Illuminate\Queue\SerializesModels;
 
 class EmailPost extends Mailable
 {
     use Queueable, SerializesModels;
 
     /**
      * Create a new message instance.
      */
     public $title;
     public $slug;
     public function __construct($title,$slug)
     {
         //
         $this->title = $title;
         $this->slug = $slug;
     }
   
 
     /**
      * Get the message envelope.
      */
     public function envelope(): Envelope
     {
         return new Envelope(
             subject: "Thông báo duyệt bài viết: " . $this->title,
         );
     }
 
     /**
      * Get the message content definition.
      */
     public function content(): Content
     {
         return new Content(
             view: 'emails.emailPost',
             with: [
                 'slug' => $this->slug,
             ],
         );
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