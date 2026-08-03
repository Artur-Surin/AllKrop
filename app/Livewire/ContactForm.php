<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Mail\ContactRequestSubmitted;
use App\Models\ContactRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ContactForm extends Component
{
    #[Rule('required|string|max:100')]
    public string $name = '';

    #[Rule('required|email|max:150')]
    public string $email = '';

    #[Rule('required|string|in:general,news,ads,place,other')]
    public string $subject = 'general';

    #[Rule('required|string|min:10|max:3000')]
    public string $message = '';

    // Anti-bot honeypot field (must stay empty)
    public string $website = '';

    public bool $submitted = false;

    public function submit(): void
    {
        // Honeypot check
        if (! empty($this->website)) {
            // Quietly ignore bot submission
            $this->submitted = true;

            return;
        }

        $this->validate();

        $contactRequest = ContactRequest::create([
            'name' => trim($this->name),
            'email' => trim($this->email),
            'subject' => $this->subject,
            'message' => trim($this->message),
            'ip_address' => request()->ip(),
            'status' => 'new',
        ]);

        // Send Email notification to site admin
        try {
            $recipient = config('mail.from.address', 'hello@kropyvnytskyi.city');
            Mail::to($recipient)->send(new ContactRequestSubmitted($contactRequest));
        } catch (\Throwable $e) {
            Log::error('Failed to send contact request email: '.$e->getMessage());
        }

        $this->reset(['name', 'email', 'message', 'website']);
        $this->subject = 'general';
        $this->submitted = true;
    }

    public function sendAnother(): void
    {
        $this->submitted = false;
    }

    public function render()
    {
        return view('livewire.contact-form', [
            'subjects' => ContactRequest::SUBJECTS,
        ]);
    }
}
