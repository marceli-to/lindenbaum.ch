<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class EventRegistrationRequest extends FormRequest
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
   * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
  public function rules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'firstname' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'event_id' => 'required|string|max:255',
    ];
  }

  public function messages(): array
  {
    return [
      'name.required' => 'Der Name ist erforderlich.',
      'firstname.required' => 'Der Vorname ist erforderlich.',
      'email.required' => 'Die E-Mail-Adresse ist erforderlich.',
      'email.email' => 'Die E-Mail-Adresse muss gültig sein.',
      'event_id.required' => 'Die Event-ID ist erforderlich.',
    ];
  }
}