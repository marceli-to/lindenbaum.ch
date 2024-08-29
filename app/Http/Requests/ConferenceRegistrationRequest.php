<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ConferenceRegistrationRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'event_id' => 'required',
    ];
  }

  // add message
  public function messages()
  {
    return [
      'name.required' => 'Name is required',
      'email.required' => 'Email is required',
      'event_id.required' => 'Event ID is required',
    ];
  }
}