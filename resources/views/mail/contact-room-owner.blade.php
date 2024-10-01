<x-mail::message>
  <div class="text-base pb-base">
    Anfrage Kontaktformular {{ $subject }}
  </div>
  <br>
  <div class="text-base pb-base">
    <strong>Dienstleistung</strong><br>
    {{ $subject }}
  </div>
  <div class="text-base pb-base">
    <strong>Vorname</strong><br>
    {{ $data['firstname'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Name</strong><br>
    {{ $data['name'] }}
  </div>
  <div class="text-base pb-base">
    <strong>E-Mail</strong><br>
    {{ $data['email'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Telefon</strong><br>
    {{ $data['phone'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Raum</strong><br>
    {{ $data['room'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Datum</strong><br>
    {{ date('d.m.Y', strtotime($data['date_start'])) }}
  </div>
  <div class="text-base pb-base">
    <strong>Nachricht</strong><br>
    {{ $data['message'] }}
  </div>
</x-mail::message>
