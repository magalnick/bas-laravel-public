<footer>
    <div class="container">
        <div class="row">
            <div class="col-md">
                <div class="h5">Contact Us</div>
                <div>{{ config('bas.name') }}</div>
                <div>{{ config('bas.mailing_address.address_1') }}</div>
                <div>{{ config('bas.mailing_address.city') }}, {{ config('bas.mailing_address.state') }} {{ config('bas.mailing_address.zipcode_9') }}</div>
                <div><a href="tel:{{ config('bas.contacts.main.phone.raw') }}">{{ config('bas.contacts.main.phone.formatted') }}</a></div>
                <div><a href="mailto:{{ config('bas.contacts.main.email') }}">{{ config('bas.contacts.main.email') }}</a></div>
            </div>

            <div class="col-md">
                <div class="h5">Sanctuary Hours</div>
                @foreach (config('bas.sanctuary_hours') as $sanctuary_hours)
                    <div>{{ $sanctuary_hours }}</div>
                @endforeach
            </div>

            <div class="col-md">
                <div class="h5">Donations</div>
                <div>{{ config('bas.disclaimers.basic.501c3') }}</div>
                <div>&nbsp;</div>
                <div>Federal Tax ID: {{ config('bas.tax_id') }}</div>
                <div>&nbsp;</div>
                <div><a class="btn btn-outline-cta" href="/donate" role="button">Donate Now</a></div>
            </div>
        </div>
    </div>
</footer>
