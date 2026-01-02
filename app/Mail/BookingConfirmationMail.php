<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $pdf;
    public $mailData;
    public $emailSubject;

    public function __construct($booking, $pdf, array $mailData, $subject = null)
    {
        $this->booking = $booking;
        $this->pdf = $pdf;
        $this->mailData = $mailData;
        $this->emailSubject = $subject ?? 'Booking Confirmed - ' . $booking->booking_reference;
    }

    public function build()
    {
        $email = $this->subject($this->emailSubject)
            ->view('emails.booking-confirmed')
            ->with($this->mailData);

        // Attach travel itinerary PDF
        if ($this->pdf) {
            $email->attachData(
                $this->pdf->output(),
                'Travel-Itinerary-' . $this->booking->booking_reference . '.pdf',
                ['mime' => 'application/pdf']
            );
        }

        return $email;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Confirmation - ' . $this->booking->booking_reference,
        );
    }

    public function attachments(): array
    {
        return [];
    }
}