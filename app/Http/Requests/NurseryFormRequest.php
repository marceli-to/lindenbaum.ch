<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class NurseryFormRequest extends FormRequest
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
      'name_parents' => 'required|string|max:255',
      'street' => 'required|string|max:255',
      'location' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'phone' => 'required|string|max:255',
      'martial_status' => 'required|string|max:255',
      'name_child' => 'required|string|max:255',
      'gender' => 'required|string|max:255',
      'date_of_birth' => 'required|date',
      'citizenship' => 'required|string|max:255',
      'care_days' => 'required|array',
      'care_days.*' => 'required|string|max:255',
      'justification_urgency' => 'required|string',
      'previous_care_type' => 'required|string',
      'date_of_entry' => 'required|date',
      'toc' => 'accepted',
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
      'name_parents.required' => 'Der Nachname ist erforderlich.',
      'street.required' => 'Die Strasse ist erforderlich.',
      'location.required' => 'Die PLZ/Ort ist erforderlich.',
      'email.required' => 'Die E-Mail-Adresse ist erforderlich.',
      'email.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
      'phone.required' => 'Die Telefonnummer ist erforderlich.',
      'martial_status.required' => 'Der Zivilstand ist erforderlich.',
      'name_child.required' => 'Der Name des Kindes ist erforderlich.',
      'gender.required' => 'Das Geschlecht ist erforderlich.',
      'date_of_birth.required' => 'Das Geburtsdatum ist erforderlich.',
      'citizenship.required' => 'Die Staatsbürgerschaft ist erforderlich.',
      'care_days.required' => 'Die Betreuungstage sind erforderlich.',
      'care_days.array' => 'Die Betreuungstage müssen ein Array sein.',
      'justification_urgency.required' => 'Die Begründung der Dringlichkeit ist erforderlich.',
      'previous_care_type.required' => 'Die vorherige Betreuungsart ist erforderlich.',
      'date_of_entry.required' => 'Das Datum ist erforderlich.',
      'toc.accepted' => 'Sie müssen den Datenschutzbestimmungen zustimmen.',
    ];
  }
}