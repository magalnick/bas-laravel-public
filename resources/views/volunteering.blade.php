@php
    $volunteer_coordinator_contact      = $contacts[ $volunteer_contacts['coordinator'] ];
    $volunteer_foster_dogs_contact      = $contacts[ $volunteer_contacts['foster']['dog'] ];
    $volunteer_pickup_donations_contact = $contacts[ $volunteer_contacts['pickup']['donations'] ];
    $volunteer_pickup_food_contact      = $contacts[ $volunteer_contacts['pickup']['food'] ];
    $volunteer_vet_assistance_contact   = $contacts[ $volunteer_contacts['vet'] ];
@endphp

<div class="row">
    <div class="col-md">
        <div class="infobox rounded">
            <p class="h5">Volunteer Opportunities Available</p>
            <p>
                We are always in need of extra helpers to keep the Baja Animal Sanctuary running smoothly.
                If you could help with any of the following positions, please call or email the contact person listed.
            </p>
        </div>

        <div class="infobox rounded">
            <p class="h5">Pet Adoptions</p>
            <p>
                We currently conduct dog adoptions at the Kahoots pet store in Rancho Penasquitos.
                Volunteers are always needed to help set up for the event, to care for the animals during the adoption,
                to help answer questions during the event, and to help clean up after an adoption is over.
            </p>
            <p>
                <a href="/adoption-events">See the Adoption Events page for dates and more details.</a>
            </p>
        </div>

        <div class="infobox rounded">
            <p class="h5">Fostering Dogs</p>
            <p>
                After an adoption event, any dogs that have not been adopted are generally placed in a loving foster home until the next adoption event.
                This way the dogs don't have to be driven back to Mexico, and then back up again for the next event.
                If you have room in your house and in your heart to provide a temporary home for one our our dogs let us know!
            </p>
            <p>
                <span class="h5">For more information contact:</span>
                <br />
                {{ $volunteer_foster_dogs_contact['name']['first'] }} {{ $volunteer_foster_dogs_contact['name']['last'] }}
                <br />
                <a href="tel:{{ $volunteer_foster_dogs_contact['phone']['raw'] }}">{{ $volunteer_foster_dogs_contact['phone']['formatted'] }}</a>
                <br />
                <a href="mailto:{{ $volunteer_foster_dogs_contact['email'] }}">{{ $volunteer_foster_dogs_contact['email'] }}</a>
            </p>
        </div>

        <div class="infobox rounded">
            <p class="h5">Donation Pick Up</p>
            <p>
                Frequently donated items need to be picked up and taken to different BAS locations.
                This volunteer position requires that you coordinate an acceptable pickup time with donor and then pick up the donated item(s) and deliver them to where they are needed.
            </p>
            <p>
                <span class="h5">For more information contact:</span>
                <br />
                {{ $volunteer_pickup_donations_contact['name']['first'] }} {{ $volunteer_pickup_donations_contact['name']['last'] }}
                <br />
                <a href="tel:{{ $volunteer_pickup_donations_contact['phone']['raw'] }}">{{ $volunteer_pickup_donations_contact['phone']['formatted'] }}</a>
                <br />
                <a href="mailto:{{ $volunteer_pickup_donations_contact['email'] }}">{{ $volunteer_pickup_donations_contact['email'] }}</a>
            </p>
        </div>

        <div class="infobox rounded">
            <p class="h5">Food Pick Up</p>
            <p>
                Medium to large food donations need to be picked up from the San Diego, Orange County or Los Angeles area and brought to BAS in San Diego.
                This volunteer position generally requires the rental of a cargo van, 15-foot, or 24-foot truck, if you don’t possess one,
                (depending upon the size of the donation) to be paid for by BAS, loading the food donation,
                driving the food to the BAS location in San Diego, and unloading the food.
            </p>
            <p>
                <span class="h5">For more information contact:</span>
                <br />
                {{ $volunteer_pickup_food_contact['name']['first'] }} {{ $volunteer_pickup_food_contact['name']['last'] }}
                <br />
                <a href="tel:{{ $volunteer_pickup_food_contact['phone']['raw'] }}">{{ $volunteer_pickup_food_contact['phone']['formatted'] }}</a>
                <br />
                <a href="mailto:{{ $volunteer_pickup_food_contact['email'] }}">{{ $volunteer_pickup_food_contact['email'] }}</a>
            </p>
        </div>

        <div class="infobox rounded">
            <p class="h5">Vet Assistance</p>
            <p>
                We are always in need of additional veterinary care, especially with spay and neuter surgeries.
                If you are a vet who is willing to drive to Rosarito Beach, Mexico, we would welcome your help!
            </p>
            <p>
                <span class="h5">For more information contact:</span>
                <br />
                {{ $volunteer_vet_assistance_contact['name']['first'] }} {{ $volunteer_vet_assistance_contact['name']['last'] }}
                <br />
                <a href="tel:{{ $volunteer_vet_assistance_contact['phone']['raw'] }}">{{ $volunteer_vet_assistance_contact['phone']['formatted'] }}</a>
                <br />
                <a href="mailto:{{ $volunteer_vet_assistance_contact['email'] }}">{{ $volunteer_vet_assistance_contact['email'] }}</a>
            </p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="infobox rounded">
            <p class="h5">Volunteer Coordinator</p>
            <p>
                {{ $volunteer_coordinator_contact['name']['first'] }} {{ $volunteer_coordinator_contact['name']['last'] }}
                <br />
                <a href="mailto:{{ $volunteer_coordinator_contact['email'] }}">{{ $volunteer_coordinator_contact['email'] }}</a>
            </p>
        </div>
    </div>
</div>
