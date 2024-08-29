<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class GeneralFormRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'name' => 'required|string|max:255',
      'firstname' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'phone' => 'required|string|max:255',
      'message' => 'required',
      'toc' => 'accepted',
    ];
  }

  public function messages()
  {
    return [
      'name.required' => 'Name is required',
      'firstname.required' => 'Vorname is required',
      'email.required' => 'Email is required',
      'phone.required' => 'Telefon is required',
      'message.required' => 'Nachricht is required',
      'toc.accepted' => 'Datenschutz is required',
    ];
  }
}