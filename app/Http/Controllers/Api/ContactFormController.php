<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralFormRequest;
use Statamic\Facades\Entry;

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
            'service' => 'Allgemein',
          ], 
          $request->validated()
        )
      )
      ->save();

    return response()->json(['message' => 'Store successful']);
  }
}