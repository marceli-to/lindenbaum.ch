<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralFormRequest;
use App\Http\Requests\RoomFormRequest;
use App\Http\Requests\NurseryFormRequest;
use App\Http\Requests\CooperativeFormRequest;
use Statamic\Facades\Entry;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Contact\GeneralUserEmail;
use App\Notifications\Contact\GeneralOwnerEmail;
use App\Notifications\Contact\RoomUserEmail;
use App\Notifications\Contact\NurseryUserEmail;
use App\Notifications\Contact\CooperativeUserEmail;
use App\Notifications\Contact\CooperativeOwnerEmail;

use Carbon\Carbon;

class ContactFormController extends Controller
{
  public function general(GeneralFormRequest $request)
  {
    $title = $request->input('firstname') . ' ' . $request->input('name');
    $entry = Entry::make()
      ->collection('requests_general')
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
        
      Notification::route('mail', $request->input('email'))->notify(new GeneralUserEmail(
        $request->input('service'),
        $request->validated()
      ));

      Notification::route('mail', env('MAIL_TO'))->notify(new GeneralOwnerEmail(
        $request->input('service'),
        $request->validated()
      ));

    return response()->json(['message' => 'Store successful']);
  }

  public function room(RoomFormRequest $request)
  {
    $title = $request->input('firstname') . ' ' . $request->input('name');
    $entry = Entry::make()
      ->collection('requests_rooms')
      ->slug($title)
      ->data(
        array_merge(
          [
            'title' => $title,
            'service' => $request->input('service'),
          ], 
          $request->except(['date_start'])
        )
      );
      
      $date = date('d.m.Y', strtotime($request->input('date_start')));
      $entry->date_start = $date;
      $entry->save();

      Notification::route('mail', $request->input('email'))->notify(new RoomUserEmail(
        $request->input('service'),
        $request->validated()
      ));

    return response()->json(['message' => 'Store successful']);
  }

  public function nursery(NurseryFormRequest $request)
  {
    $title = $request->input('name_parents');
    $entry = Entry::make()
      ->collection('requests_nursery')
      ->slug($title)
      ->data(
        array_merge(
          [
            'title' => $title,
            'service' => $request->input('service'),
          ], 
          $request->validated()
        )
      );

      $date = date('d.m.Y', strtotime($request->input('date_of_birth')));
      $entry->date_of_birth = $date;

      $date = date('d.m.Y', strtotime($request->input('date_of_entry')));
      $entry->date_of_entry = $date;

      $entry->care_days = implode(', ', $request->input('care_days'));
      $entry->save();

      Notification::route('mail', $request->input('email'))->notify(new NurseryUserEmail(
        $request->input('service'),
        $request->validated()
      ));

    return response()->json(['message' => 'Store successful']);
  }

  public function cooperative(CooperativeFormRequest $request)
  {
    $title = $request->input('firstname') . ' ' . $request->input('name');
    $entry = Entry::make()
      ->collection('requests_cooperative')
      ->slug($title)
      ->data(
        array_merge(
          [
            'title' => $title,
            'service' => $request->input('service'),
          ], 
          $request->validated()
        )
        );

      $date = date('d.m.Y', strtotime($request->input('date_of_birth')));
      $entry->date_of_birth = $date;
      $entry->save();

      Notification::route('mail', $request->input('email'))->notify(new CooperativeUserEmail(
        $request->input('service'),
        $request->validated()
      ));

      Notification::route('mail', env('MAIL_TO'))->notify(new CooperativeOwnerEmail(
        $request->input('service'),
        $request->validated()
      ));

    return response()->json(['message' => 'Store successful']);
  }
}