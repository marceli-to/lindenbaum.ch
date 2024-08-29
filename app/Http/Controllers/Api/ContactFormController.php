<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralFormRequest;
use Statamic\Facades\Entry;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactUserEmail;

class ContactFormController extends Controller
{
  public function general(GeneralFormRequest $request)
  {
    $title = $request->input('firstname') . ' ' . $request->input('name') . ', ' . $request->input('email');
    $entry = Entry::make()
      ->collection('contact_requests_general')
      ->slug($title)
      ->data(
        array_merge(
          [
            'title' => $title,
            'service' => $request->input('service'),
          ], 
          $request->validated()
        )
      )
      ->save();
        
      Notification::route('mail', $request->input('email'))->notify(new ContactUserEmail(
        $request->input('service'),
        $request->validated()
      ));

    return response()->json(['message' => 'Store successful']);
  }
}