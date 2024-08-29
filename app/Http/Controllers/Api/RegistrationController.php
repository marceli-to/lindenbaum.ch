<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConferenceRegistrationRequest;
use Statamic\Facades\Entry;

class RegistrationController extends Controller
{
  public function registerConference(ConferenceRegistrationRequest $request)
  {
    dd($request->all());
    $registration = Entry::make()
      ->collection('registrations')
      ->data($request->validated())
      ->save();

    return response()->json(['message' => 'Registration successful', 'id' => $registration->id()]);
  }
}