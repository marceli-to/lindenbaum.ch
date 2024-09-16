<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRegistrationRequest;
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
        'Fleisch' => $event->has_meal_option_meat ? __('Fleisch') : null,
        'Vegetarisch' => $event->has_meal_option_vegetarian ? __('Vegetarisch') : null,
      ],
      'has_button_additional_individuals' => $event->has_button_additional_individuals,
      'has_field_additional_individual_email' => $event->has_field_additional_individual_email,
      'has_field_additional_individual_name' => $event->has_field_additional_individual_name,
      'has_field_additional_individual_firstname' => $event->has_field_additional_individual_firstname,
    ]);
  }

  public function register(EventRegistrationRequest $request)
  {
    $event = Entry::find($request->input('event_id'));
    $slug = $event->title . ' ' . $request->input('firstname') . ' ' . $request->input('name');
    $entry = Entry::make()
    ->collection('requests_events')
    ->slug($slug)
    ->data(
      array_merge(
        [
          'title' => $event->title,
        ], 
        $request->validated()
      )
    )
    ->save();
      
    // Notification::route('mail', $request->input('email'))->notify(new GeneralUserEmail(
    //   $request->input('service'),
    //   $request->validated()
    // ));

    return response()->json(['message' => 'Store successful']);
  }
}