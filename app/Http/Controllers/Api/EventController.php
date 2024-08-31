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
      'max_participants' => $event->max_participants,
      'has_catering' => $event->has_catering,
      'costs' => $event->costs,
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