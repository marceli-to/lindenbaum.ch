<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class RoomFormRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'firstname' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'phone' => 'required|string|max:255',
      'message' => 'required',
      'toc' => 'accepted',
      'date_start' => 'required|date',
      'room' => 'required|string|max:255',
    ];
  }

  /**
   * Get custom messages for validator errors.
   *
   * @return array
   */
  public function messages(): array
  {
    return [
      'name.required' => 'Der Nachname ist erforderlich.',
      'firstname.required' => 'Der Vorname ist erforderlich.',
      'email.required' => 'Die E-Mail-Adresse ist erforderlich.',
      'email.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
      'phone.required' => 'Die Telefonnummer ist erforderlich.',
      'message.required' => 'Eine Nachricht ist erforderlich.',
      'toc.accepted' => 'Sie müssen den Datenschutzbestimmungen zustimmen.',
      'date_start.required' => 'Das Datum ist erforderlich.',
      'room.required' => 'Der Raum ist erforderlich.',
    ];
  }
}