<x-mail::message>
  <div class="text-base pb-base">
    Guten Tag<br><br>Vielen Dank für Ihre Anfrage. Wir werden uns so schnell wie möglich mit Ihnen in Verbindung setzen.
  </div>
  <br>
  <div class="text-base pb-base">
    <strong>Ihre Angaben:</strong>
  </div>
  <div class="text-base pb-base">
    <strong>Vorname</strong><br>
    {{ $data['firstname'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Name</strong><br>
    {{ $data['name'] }}
  </div>
 </x-mail::message>
