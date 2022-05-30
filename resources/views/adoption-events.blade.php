@if (config('bas.show_covid_content'))
    <div class="row">
        <div class="col-md">
            <div class="infobox rounded important text-justify">
                <p>
                    <a href="/dogs">Dog adoptions</a> are by appointment only.
                    Current CDC guidelines will be followed to protect adopters, our volunteers, and the staff at Kahoots.
                </p>
                <p>
                    If you're interested in meeting a dog, <a href="/dogs">click here to get bios, photos and submit an application</a>.
                </p>
                <p>
                    Applications are reviewed in the order received.
                    You will be notified by email as to the status of your application.
                    If approved an appointment will be scheduled for you to meet the dog.
                </p>
                <p>Thank you!</p>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md">
        <h2>Dog Adoptions</h2>
        <div class="infobox rounded">
            The Baja Animal Sanctuary conducts weekly dog adoptions in San Diego County.
        </div>
        @foreach (config('bas.adoption.events.dog') as $event)
            @php
                $day_text
                    = $event['which'] === '5th'
                    ? $event['which'] . " " . $event['day'] . " of most months that have a " . $event['which'] . " " . $event['day']
                    : $event['which'] . " " . $event['day'] . " of each month";
            @endphp

            @if (is_null($event['location']))
                <div class="infobox rounded">
                    <p class="h5">{{ $day_text }}</p>
                    <div>No events at this time</div>
                </div>
                @continue
            @endif

            @php
                $location = config("bas.locations.{$event['location']}");
                $note     = $event['note'] ?? null;
            @endphp

            <div class="infobox rounded">
                <p class="h5">{{ $day_text }}</p>
                @if (!is_null($note))
                    <p class="font-italic">{{ $note }}</p>
                @endif

                <p>
                    <span class="font-weight-bold">{{ $location['name'] }} - {{ $location['location'] }}</span>
                    <br />
                    <a href="{{ $location['map'] }}" target="_blank">{{ $location['address'] }}, {{ $location['city'] }}</a>
                    <br />
                    {{ $event['startTime'] }} - {{ $event['endTime'] }} <span class="font-weight-bold">(by appointment only)</span>
                    @foreach ($event['contacts'] as $contact_key)
                        @php
                            $contact = config("bas.contacts.{$contact_key}");
                        @endphp
                        <br />
                        BAS Contact: <a href="mailto:{{ $contact['email'] }}">{{ $contact['name']['first'] }} {{ $contact['name']['last'] }}</a>, <a href="tel:{{ $contact['phone']['raw'] }}">{{ $contact['phone']['formatted'] }}</a>
                    @endforeach
                </p>

                <p>Call {{ $location['name'] }} for more information: <a href="tel:{{ $location['phone']['raw'] }}">{{ $location['phone']['formatted'] }}</a></p>
            </div>
        @endforeach

        <div class="infobox rounded">
            @foreach (config('bas.adoption.events.images.dog') as $image)
                <div class="row">
                    <div class="col text-center">
                        <figure>
                            <img class="figure-img img-fluid shadow rounded" src="{{ $image["src"] }}" alt="{{ $image["alt"] }}" style="{{ $image["style"] }}" />
                            <figcaption class="figure-caption">{{ $image["alt"] }}</figcaption>
                        </figure>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-4">
        <h2>Cat Adoptions</h2>
        <div class="infobox rounded">
            <div>Our kitties are available for adoption full-time in a Vista, California foster home.</div>
            <div class="mt-3"><a href="/cats">Click for more info about our cat adoption program</a>.</div>
        </div>

        @foreach (config('bas.adoption.events.cat') as $event)
            @php
                $location = config("bas.locations.{$event['location']}");
            @endphp
            <div class="infobox rounded">
                <p class="h5">{{ $location['name'] }}</p>
                @foreach ($event['contacts'] as $contact_key)
                    @php
                        $contact = config("bas.contacts.{$contact_key}");
                    @endphp
                    <div>
                        <a href="mailto:{{ $contact['email'] }}">{{ $contact['name']['first'] }} {{ $contact['name']['last'] }}</a>
                        <br />
                        <a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>
                        <br />
                        <a href="tel:{{ $contact['phone']['raw'] }}">{{ $contact['phone']['formatted'] }}</a>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
