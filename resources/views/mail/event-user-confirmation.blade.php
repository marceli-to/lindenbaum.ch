<x-mail::message>
  <div class="text-base pb-base">
    Guten Tag<br><br>Vielen Dank für Ihre Anmeldung. Wir freuen uns, dass Sie sich für die Veranstaltung interessieren.
  </div>
  <br>
  <div class="text-base pb-base">
    <strong>Veranstaltung</strong><br>
    {{ $data['title'] }}
  </div>
  @if ($data['firstname'])
  <div class="text-base pb-base">
    <strong>Vorname</strong><br>
    {{ $data['firstname'] }}
    </div>
  @endif
  @if ($data['name'])
    <div class="text-base pb-base">
      <strong>Name</strong><br>
      {{ $data['name'] }}
    </div>
  @endif
  @if ($data['email'])
    <div class="text-base pb-base">
      <strong>E-Mail</strong><br>
      {{ $data['email'] }}
    </div>
  @endif
  @if ($data['phone'])
    <div class="text-base pb-base">
      <strong>Telefon</strong><br>
      {{ $data['phone'] }}
    </div>
  @endif
  @if ($event->has_meal_options && $data['meal_options'])
    <div class="text-base pb-base">
      <strong>Verpflegungswunsch</strong><br>
      {{ $data['meal_options'] }}
    </div>
  @endif
  @if ($data['remarks'])
    <div class="text-base pb-base">
      <strong>Bemerkungen</strong><br>
      {{ $data['message'] }}
    </div>
  @endif
  @if (isset($data['children']) && $data['children'] > 0)
    <div class="text-base pt-xlarge pb-large">
      <strong>Kinder</strong><br>
      {{ $data['children'] }}
    </div>
  @endif
  @if (isset($data['additional_individuals']) && count($data['additional_individuals']) > 0)
    <div class="text-base pt-xlarge pb-large">
      <strong>Begleitpersonen</strong><br>
    </div>
    @foreach ($data['additional_individuals'] as $individual)
      <div class="text-base pb-base">
        <strong>Name</strong><br>
        {{ $individual['name'] }}
      </div>
      @if ($individual['email'])
        <div class="text-base pb-base">
          <strong>E-Mail</strong><br>
          {{ $individual['email'] }}
        </div>
      @endif
      @if ($individual['meal_options'])
        <div class="text-base pb-base">
          <strong>Verpflegungswunsch</strong><br>
          {{ $individual['meal_options'] }}
        </div>
      @endif
    @endforeach
  @endif
</x-mail::message>
