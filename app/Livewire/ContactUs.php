<?php

namespace App\Livewire;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;

class ContactUs extends Component
{
    public $name;

    public $email;

    public $message;

    public function submit()
    {
        $validated = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        try {

            $emails = explode(',',settings('order_placed_emails'));

            Mail::to($emails)->send(new ContactMail($validated));

            $this->reset('name', 'email', 'message');

            session()->flash('success', 'Thanks for you contacting us.');

        } catch (\Throwable $th) {
            $this->reset('name', 'email', 'message');
            session()->flash('error', 'Whoops, something went wrong!');
        }

    }

    #[Title('Contact Us')]
    public function render()
    {
        return view('livewire.contact-us');
    }
}