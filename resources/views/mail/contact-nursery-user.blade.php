<x-mail::message>
  <div class="text-base pb-base">
    Guten Tag<br><br>Vielen Dank für Ihre Anfrage. Wir werden uns so schnell wie möglich mit Ihnen in Verbindung setzen.
  </div>
  <br>
  <div class="text-base pb-base">
    <strong>Name der Eltern</strong><br>
    {{ $data['name_parents'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Strasse</strong><br>
    {{ $data['street'] }}
  </div>
  <div class="text-base pb-base">
    <strong>PLZ/Ort</strong><br>
    {{ $data['location'] }}
  </div>
  <div class="text-base pb-base">
    <strong>E-Mail</strong><br>
    {{ $data['email'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Telefon</strong><br>
    {{ $data['phone'] }}
  </div>
  @if (isset($data['phone_business']))
    <div class="text-base pb-base">
      <strong>Telefon (geschäftlich)</strong><br>
      {{ $data['phone_business'] }}
    </div>
  @endif
  <div class="text-base pb-base">
    <strong>Zivilstand</strong><br>
    {{ $data['martial_status'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Name des Kindes</strong><br>
    {{ $data['name_child'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Geschlecht</strong><br>
    {{ $data['gender'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Geburtsdatum</strong><br>
    {{ date('d.m.Y', strtotime($data['date_of_birth'])) }}
  </div>
  <div class="text-base pb-base">
    <strong>Nationalität</strong><br>
    {{ $data['citizenship'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Gewünschte Betreuungstage</strong><br>
    {{ implode(', ', $data['care_days']) }}
  </div>
  <div class="text-base pb-base">
    <strong>Flexible Betreuungstage</strong><br>
    {{ $data['care_days_flexible'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Begründung der Dringlichkeit</strong><br>
    {{ $data['justification_urgency'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Vorherige Betreuungsart</strong><br>
    {{ $data['previous_care_type'] }}
  </div>
  <div class="text-base pb-base">
    <strong>Eintrittsdatum</strong><br>
    {{ date('d.m.Y', strtotime($data['date_of_entry'])) }}
  </div>

</x-mail::message>