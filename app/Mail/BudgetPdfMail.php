<?php

namespace App\Mail;

use App\Models\Budget;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BudgetPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Budget $budget,
        public string $pdfContent
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Presupuesto #' . $this->budget->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.budget-pdf',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => $this->pdfContent,
                'presupuesto-' . $this->budget->id . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}