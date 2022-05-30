<div class="row">
    <div class="col-md">
        @if ($bas['show_covid_content'])
            <div class="infobox rounded important">
                Please note: Due to Covid 19, only dogs with pre-approved applications will be brought up to the events at this time.
            </div>
        @endif

        <div class="infobox rounded text-justify">
            <p class="h5">Adoption Process</p>
            <p>
                After viewing our adoptable dogs, the next step would be to submit an application on the dog you're interested in adopting.
                The link to our Adoption Application is below. Once the application is received, it will be reviewed and a volunteer will contact you.
                We will then make arrangements for you to meet the dog at one of our next Adoption Events.
                Please see our Event schedule for locations and times. Or, you may drive to our shelter located in Rosarito, Mexico.
                If after meeting the dog, and it is determined the dog is the right fit, you will begin the adoption as a two week foster period.
                If after the two weeks, you decide you'd like to keep your new furry friend, a volunteer will come out to your home and finalize the adoption.
                If for whatever reason during the two weeks you realize the dog is not the right fit,
                you will be able to bring the dog back to the next Adoption Event and our Business Office will mail you a full refund of the adoption fee.
            </p>
            <p class="font-italic">
                Please note: Dogs with pre-approved applications will be brought to the events first.
                If there is room in the transport vehicle, other available dogs will join them.
            </p>
            <p class="font-weight-bold">Adoption Fee: {{ $adoption['fee']['dog'] }}</p>
            <p>All of our dogs are spayed/neutered, current on their vaccines, flea and tick treated, and dewormed prior to being put up for adoption.</p>
            <p class="font-weight-bold font-italic">
                Once you have <a href="{{ $bas_view['pages']['adoption-applications']['path'] }}">submitted your application</a>, please be patient for a response.
                We are all volunteers and work as quickly as possible to respond to all applications.
            </p>
        </div>

        <div class="infobox rounded">
            @foreach ($dogs['images'] as $image)
                <div class="row">
                    <div class="col text-center">
                        <figure>
                            <img class="figure-img img-fluid shadow rounded" src="{{ $image["src"] }}" alt="{{ $image["alt"] }}" style="{{ $image['style'] }}" />
                            <figcaption class="figure-caption">{{ $image["alt"] }}</figcaption>
                        </figure>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-3 text-center">
        <a class="btn btn-primary btn-lg btn-block" href="{{ $adoption['petfinder']['available']['dogs'] }}" target="_blank">
            See our adoptable dogs
        </a>
        <a class="btn btn-primary btn-lg btn-block" href="{{ $bas_view['pages']['adoption-applications']['path'] }}">
            Fill out our adoption application
        </a>
    </div>
</div>
