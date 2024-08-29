<?php
namespace App\Livewire;
use Livewire\Attributes\Rule; 
use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactUserEmail;

class ContactGeneral extends Component
{
  // public $request_type = 'general';

  #[Rule('required')]
  public $firstname;

  #[Rule('required')]
  public $name;

  #[Rule('required', 'email')]
  public $email;

  public function save()
  {
    $this->validate();
    Notification::route('mail', $this->email)->notify(new ContactUserEmail([
      'name' => $this->name,
      'firstname' => $this->firstname,
    ]));
    session()->flash('status', 'Inquiry was submitted');
    $this->reset();
  }

  public function render()
  {
    return view('livewire.contact-general');
  }

}
