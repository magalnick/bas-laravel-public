@php
    $placement_stats_year = '2021';
    $placement_statistics = $bas['placement_statistics'][$placement_stats_year];
@endphp

<div class="row">
    <div class="col-md">
        <div class="infobox rounded important">
            <p class="h5">Good News!</p>
            <p class="font-weight-bold">In {{ $placement_stats_year }} we placed {{ $placement_statistics['placed']['dogs'] }} dogs and {{ $placement_statistics['placed']['cats'] }} cats in their forever homes!</p>
            <p>
                <div>We took in {{ $placement_statistics['took_in']['dogs'] }} dogs and {{ $placement_statistics['took_in']['cats'] }} cats.</div>
                <div>We sterilized {{ $placement_statistics['sterilized'] }} dogs and cats for BAS to place for adoption.</div>
                <div>Our Spay &amp; Neuter Clinics sterilized {{ $placement_statistics['spay_neuter_clinic'] }} local dogs and cats.</div>
                <div>We presently have {{ $placement_statistics['currently_have']['dogs'] }} dogs and {{ $placement_statistics['currently_have']['cats'] }} cats at the Sanctuary.</div>
            </p>
            <p>We could never do this without our amazing volunteers and our loyal supporters!</p>
        </div>

        <div class="infobox rounded text-justify">
            <p class="h5">Our Mission</p>
            <p>{{ $bas['mission_statement'] }}</p>
        </div>

        @include('snippets.amazon-wish-list')

        <div class="infobox rounded text-justify">
            <p class="h5">Our Partners</p>
            <p>
                The Baja Animal Sanctuary is proud to partner with
                <a href="https://kahootsfeedandpet.com/pages/kahoots-rancho-penasquitos" target="_blank">Kahoots Rancho Pe&ntilde;asquitos</a>,
                <a href="https://www.petcofoundation.org/" target="_blank">The Petco Foundation</a>, and
                <a href="https://petsmartcharities.org/" target="_blank">Petsmart Charities</a>.
            </p>
            <div class="row">
                <div class="col-sm text-center" style="padding-top: 10px;">
                    <a href="https://kahootsfeedandpet.com/pages/kahoots-rancho-penasquitos" target="_blank"><img width="225" src="/images/favorite-businesses/kahoots-logo-badge.svg" alt="Kahoots Rancho Pe&ntilde;asquitos" /></a>
                </div>
                <div class="col-sm text-center" style="padding-top: 10px;">
                    <a href="https://www.petcofoundation.org/" target="_blank"><img width="225" src="/images/partners/partner_petco.png" alt="Petco Foundation" /></a>
                </div>
                <div class="col-sm text-center" style="padding-top: 10px;">
                    <a href="https://petsmartcharities.org/" target="_blank"><img width="225" src="/images/partners/partner_petsmart.png" alt="PetSmart Charities" /></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 text-center">
        <div>
            <!-- badge with 5 stars and reviews -->
            <script type="text/javascript">
                gnp_url = 'baja-animal-sanctuary';
                gnp_num = '4';
            </script>
            <script src="https://greatnonprofits.org/js/api/badge_stars.js" type="text/javascript"></script>
            <noscript><a href="https://greatnonprofits.org/org/baja-animal-sanctuary/?badge=1"><img alt="Review Baja Animal Sanctuary on Great Nonprofits" title="Review Baja Animal Sanctuary on Great Nonprofits" src="//cdn.greatnonprofits.org/images/great-nonprofits.gif?id=1049915"></a></noscript>
        </div>
        <div>
            <img src="/images/awards/guidestar-silver-transparency-2021.png" alt="Guidestar Silver Transparency - 2021" class="mt-2" style="width: 120px;" />
        </div>
        <div>
            <img src="/images/legacy/sunny-benedict-in-memoriam-small.png" alt="In Memoriam: Our founder and president, Adel (Sunny) Benedict" class="infobox rounded tight mt-2" style="width: 136px;" />
        </div>

        <div class="text-center mt-3">
            <a class="btn btn-primary btn-lg btn-block" href="{{ $bas['marketing']['newsletter_signup_url_external'] }}" target="_blank">
                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                Subscribe to BAS
                <span class="text-nowrap">e-News</span>
            </a>
        </div>
    </div>
</div>
