<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Statamic\Facades\Entry;
use Illuminate\Support\Facades\Notification;

class EventController extends Controller
{
  public function get($eventId)
  {
    $event = Entry::find($eventId);
    return response()->json([
      'title' => $event->title,
      'has_name' => $event->has_name,
      'requires_name' => $event->requires_name,
      'has_firstname' => $event->has_firstname,
      'requires_firstname' => $event->requires_firstname,
      'has_email' => $event->has_email,
      'requires_email' => $event->requires_email,
      'has_phone' => $event->has_phone,
      'requires_phone' => $event->requires_phone,
      'has_remarks' => $event->has_remarks,
      'has_meal_options' => $event->has_meal_options,
      'meal_options' => [
        'Fleisch' => $event->has_meal_option_meat ? 'Fleisch' : null,
        'Vegetarisch' => $event->has_meal_option_vegetarian ? 'Vegetarisch' : null,
      ],
      'has_button_additional_individuals' => $event->has_button_additional_individuals,
      'has_field_additional_individual_email' => $event->has_field_additional_individual_email,
      'has_field_additional_individual_name' => $event->has_field_additional_individual_name,
    ]);
  }

  public function register(Request $request)
  {
    $event = Entry::find($request->input('event_id'));
    $validationResult = $this->validateRequest($request, $event);

    if ($validationResult !== TRUE)
    {
      return $validationResult;
    }

    $entry = Entry::make()
      ->collection('requests_events')
      ->slug($event->title . '-' . uniqid())
      ->data([
        'title' => $event->title,
        'name' => $request->input('name') ?? null,
        'firstname' => $request->input('firstname') ?? null,
        'email' => $request->input('email') ?? null,
        'phone' => $request->input('phone') ?? null,
        'remarks' => $request->input('remarks') ?? null,
        'meal_options' => $request->input('wants_meal_options') != "false" && $request->input('meal_options') ? $request->input('meal_options') : 'ohne Essen',
      ])
      ->save();

    // handle additional individuals
    foreach ($request->input('additional_individuals') as $individual)
    {
      Entry::make()
        ->collection('requests_events')
        ->slug($event->title . '-' . uniqid())
        ->data([
          'title' => $event->title,
          'firstname' => '–',
          'name' => $individual['name'],
          'email' => $individual['email'] ?? '–',
          'meal_options' => $individual['meal_options'] ?? 'ohne Essen',
          'remarks' => 'Begleitperson von ' . $request->input('firstname') . ' ' . $request->input('name'),
        ])
        ->save();
    }

      
    // Notification::route('mail', $request->input('email'))->notify(new GeneralUserEmail(
    //   $request->input('service'),
    //   $request->validated()
    // ));

    return response()->json(['message' => 'Store successful']);
  }

  protected function validateRequest(Request $request, $event)
  {
    $validationRules = $this->getValidationRules($event);

    $validator = Validator::make(
      $request->all(),
      $validationRules['rules'],
      $validationRules['messages']
    );

    if ($validator->fails())
    {
      $errors = $validator->errors();
      $formattedErrors = [];

      foreach ($errors->messages() as $field => $messages)
      {
        if (strpos($field, 'additional_individuals.') === 0) {
          $parts = explode('.', $field);
          $index = $parts[1];
          $subfield = $parts[2];
          $formattedErrors['additional_individuals'][$index][$subfield] = $messages[0];
        } 
        else {
          $formattedErrors[$field] = $messages[0];
        }
      }

      return response()->json(['errors' => $formattedErrors], 422);
    }

    return TRUE;
  }

  protected function getValidationRules($event)
  {
    $validationRules = [];

    if ($event->has_name && $event->requires_name) {
      $validationRules['name'] = 'required';
    }

    if ($event->has_firstname && $event->requires_firstname) {
      $validationRules['firstname'] = 'required';
    }

    if ($event->has_email && $event->requires_email) {
      $validationRules['email'] = 'required|email|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    } 

    if ($event->has_phone && $event->requires_phone) {
      $validationRules['phone'] = 'required';
    }

    if ($event->has_meal_options) {
      $validationRules['wants_meal_options'] = 'required';
      $validationRules['meal_options'] = 'required_if:wants_meal_options,true';
    }

    if ($event->has_button_additional_individuals) {

      if ($event->has_field_additional_individual_name) {
        $validationRules['additional_individuals.*.name'] = 'required';
      }

      if ($event->has_field_additional_individual_email) {
        $validationRules['additional_individuals.*.email'] = 'required|email|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
      }

      if ($event->has_field_additional_individual_cost_center) {
        $validationRules['additional_individuals.*.cost_center'] = 'required';
      }
    }

    if ($event->has_button_additional_individuals && $event->has_meal_options) {
      $validationRules['additional_individuals.*.wants_meal_options'] = 'required';
      $validationRules['additional_individuals.*.meal_options'] = 'required_if:additional_individuals.*.wants_meal_options,true';
    }

    $validationRules['toc'] = 'accepted';

    // Set validation messages
    $validationMessages = [
      'name.required' => __('Name ist erforderlich'),
      'firstname.required' => __('Vorname ist erforderlich'),
      'email.required' => __('E-Mail-Adresse ist erforderlich'),
      'email.email' => __('E-Mail-Adresse muss gültig sein'),
      'email.regex' => __('E-Mail-Adresse muss gültig sein'),
      'phone.required' => __('Telefonnummer ist erforderlich'),
      'meal_options.required' => __('Essen ist erforderlich'),
      'wants_meal_options.required' => __('Angabe ist erforderlich'),
      'additional_individuals.*.name.required' => __('Name ist erforderlich'),
      'additional_individuals.*.email.required' => __('E-Mail-Adresse ist erforderlich'),
      'additional_individuals.*.email.email' => __('E-Mail-Adresse muss gültig sein'),
      'additional_individuals.*.email.regex' => __('E-Mail-Adresse muss gültig sein'),
      'additional_individuals.*.meal_options.required' => __('Essen ist erforderlich'),
      'additional_individuals.*.wants_meal_options.required' => __('Angabe ist erforderlich'),
      'toc.accepted' => __('Sie müssen die Teilnahme- und Annullationsbedingungen sowie die Datenschutzbestimmungen akzeptieren'),
    ];
    
    return [
      'rules' => $validationRules,
      'messages' => $validationMessages,
    ];
  }
}