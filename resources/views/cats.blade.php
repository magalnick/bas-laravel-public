@php
    $contact = $contacts[ $adoption['main_contact']['cat'] ];
@endphp

<div class="row">
    <div class="col-md">
        <div class="infobox text-justify">
            <p class="h5">Do You Have a Home For Me?</p>
            
            <p>
                The Baja Animal Sanctuary is home to over 80 cats and kittens! If you are looking for just the right addition to your family, we invite you to drive down to the sanctuary and meet some of our feline residents. If you can't visit the sanctuary, we have cats and kittens for adoption in a foster home in Vista, CA;
            </p>

            <div class="row">
                <figure class="col">
                    <img class="figure-img img-fluid shadow rounded" src="/images/cats/sunroom-wide.jpg" alt="Cat sunroom at the foster home" />
                    <figcaption class="figure-caption">Kitties in the Vista foster home have this entire sunroom to themselves. What a beautiful place!</figcaption>
                </figure>

                <figure class="col">
                    <img class="figure-img img-fluid shadow rounded" src="/images/cats/sunroom-buddha.jpg" alt="Cat water fountain in the foster home" />
                    <figcaption class="figure-caption">The sunroom is a zen-like place for the kitties.</figcaption>
                </figure>
            </div>

            <p>
                Pictures and profiles of our available cats are on <a class="font-weight-bold" href="{{ $adoption['petfinder']['available']['cats'] }}" target="_blank">our PetFinder page</a>.
            </p>

            <p>
                Here's our process: If you'd like to meet one of our cats, please <a class="font-weight-bold" href="https://forms.gle/4MjXV4RNHmWi81yVA" target="_blank">fill out a cat adoption application</a>. After we receive your app, we will call you to schedule a Meet &amp; Greet in Vista. You can spend as much time as you like with the cat in our catio to see if you and the kitty are a perfect match.
            </p>

            <div class="row">
                <div class="col">
                    <p>
                        For additional information on any of these adorable kitties, call {{ $contact['name']['first'] }} at <a href="tel:{{ $contact['phone']['raw'] }}">{{ $contact['phone']['formatted'] }}</a>, or email her at <a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>. Make sure to include the name of the cat(s) you are interested in. Check back with us often to see updated pictures and profiles of our cats and kittens available for adoption. 
                    </p>
        
                    <p>
                        Because of COVID, home visits have been scaled back to just a few minutes.
                    </p>
                </div>

                <figure class="col">
                    <img class="figure-img img-fluid shadow rounded" src="/images/cats/catio.jpg" alt="Catio at the foster home" />
                    <figcaption class="figure-caption">Here's the spacious catio where you can spend time with the kitty you'd like to adopt.</figcaption>
                </figure>
            </div>
        </div>
    </div>
    <div class="col-md-3 text-center">
        <a class="btn btn-primary btn-lg btn-block" href="{{ $adoption['petfinder']['available']['cats'] }}" target="_blank">
            See our adoptable cats
        </a>
        <a class="btn btn-primary btn-lg btn-block" href="https://forms.gle/4MjXV4RNHmWi81yVA" target="_blank">
            Fill out our adoption application
        </a>
    </div>
</div>
