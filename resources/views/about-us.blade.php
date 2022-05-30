<div class="row">
    <div class="col-md">
        <div class="infobox rounded text-justify">
            <p>
                The Baja Animal Sanctuary is located in Rosarito, Mexico, just 22 miles south of the San Ysidro border.
                The sanctuary was founded by Sunny Benedict, a native New Yorker who was working in Real Estate in Rosarito.
                From her office window, Sunny would see the local animals, mangy and starving, roaming the streets in search
                of anyone who might toss them a morsel of food, or give them a kind pat on the head.
            </p>
            <p>
                She knew she had to do something.
            </p>
            <p>
                With a mere $180.00 she gathered from friends, she turned her dream into reality and started the Baja Animal Sanctuary.
            </p>
        </div>

        <div class="infobox rounded text-justify">
            <p>
                Baja Animal Sanctuary, the only no-kill shelter in northern Mexico, provides a safe haven for dogs and cats.
                Rescued from the streets of Mexico, they now receive food, medical care, and love for the rest of their lives.
                Once the puppies are old enough, or the sick ones are well enough, they are spayed &amp; neutered.
                Our ultimate goal is to find each and every one of them a forever home.
                When this can't be accomplished, since we are a no-kill shelter, the animals that are "un-adoptable" will make BAS their permanent home.
                In some extreme cases, untreatable dogs and cats are euthanized to put an end to their pain and suffering.
            </p>
        </div>

        <div class="infobox rounded text-justify">
            <p>
                The dog enclosures, which are called "corrals", just like the cattery enclosures, are all numbered.
                This makes tracking the location of the residents much easier.
            </p>
            <p>
                The large canine corrals house adult males and females that have been spayed &amp; neutered.
                The residents are placed in corrals based on age, temperament, and health problems.
                Each of the large corrals is home to 10 to 15 dogs.
            </p>
            <p>
                Smaller corrals that house 3 to 4 dogs each are generally used to house residents that need to be spayed or neutered, or new moms nursing pups.
                The smaller corrals are also used to house any animals in need of immediate medical attention or any new BAS arrivals that need to be evaluated by our vet.
            </p>
        </div>

        <div class="infobox rounded text-justify">
            <p>
                A Daily Log is kept on all animals receiving medical care or on medication.
                This information is then transferred to the individual animal's health record.
            </p>
            <p>
                Our overall resident count fluctuates daily, but we always average over 400 residents (dogs and cats combined).
            </p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="infobox rounded">
            @foreach ($about_us['images'] as $image)
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
</div>
