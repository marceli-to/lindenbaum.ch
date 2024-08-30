<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CooperativeFormRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'shares' => 'required|integer|min:1',
      'name' => 'required|string|max:255',
      'firstname' => 'required|string|max:255',
      'street' => 'required|string|max:255',
      'location' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'phone' => 'required|string|max:255',
      'date_of_birth' => 'required|date',
      'message' => 'required',
      'toc' => 'accepted',
    ];
  }

  public function messages()
  {
    return [
      'shares.required' => 'Die Anzahl der Anteile ist erforderlich',
      'shares.integer' => 'Die Anzahl der Anteile muss eine ganze Zahl sein',
      'shares.min' => 'Die Anzahl der Anteile muss mindestens 1 sein',
      'name.required' => 'Der Name ist erforderlich',
      'firstname.required' => 'Der Vorname ist erforderlich',
      'street.required' => 'Die Strasse ist erforderlich',
      'location.required' => 'Die PLZ/Ort ist erforderlich',
      'email.required' => 'Die E-Mail-Adresse ist erforderlich',
      'phone.required' => 'Die Telefonnummer ist erforderlich',
      'date_of_birth.required' => 'Das Geburtsdatum ist erforderlich',
      'message.required' => 'Eine Nachricht ist erforderlich',
      'toc.accepted' => 'Sie müssen den Datenschutzbestimmungen zustimmen',
    ];
  }
}