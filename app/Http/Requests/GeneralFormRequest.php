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
      'name.required' => 'Der Name ist erforderlich',
      'firstname.required' => 'Der Vorname ist erforderlich',
      'email.required' => 'Die E-Mail-Adresse ist erforderlich',
      'phone.required' => 'Die Telefonnummer ist erforderlich',
      'message.required' => 'Eine Nachricht ist erforderlich',
      'toc.accepted' => 'Sie müssen den Datenschutzbestimmungen zustimmen',
    ];
  }
}