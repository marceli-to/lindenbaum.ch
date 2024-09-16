<x-mail::message>
  <div class="text-base pb-base">
    Guten Tag<br><br>Vielen Dank für Ihre Anfrage. Wir werden uns so schnell wie möglich mit Ihnen in Verbindung setzen.
  </div>
  <br>
  <div class="text-base pb-base">
    <strong>Dienstleistung</strong><br>
    {{ $subject }}
  </div>
  <div class="text-base pb-base">
    <strong>Anzahl Anteile</strong><br>
    {{ $data['shares'] }}
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
    <strong>Geburtsdatum</strong><br>
    {{ date('d.m.Y', strtotime($data['date_of_birth'])) }}
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
    <strong>Nachricht</strong><br>
    {{ $data['message'] }}
  </div>
</x-mail::message>
