<div class="row">
    <div class="col-md">
        <div class="infobox rounded">
            <p>Thank you so much for your interest in helping the Baja Animal Sanctuary! It is your support that allows us to provide food, shelter, and medical care for the animals during their stay with us.</p>
            <p>There are several ways to complete a donation.</p>
        </div>

        <div class="infobox rounded">
            <p class="h5">PayPal</p>
            <p>Make a difference with the convenience and security of PayPal.</p>
            <p><a class="btn btn-outline-cta" href="https://www.paypal.com/donate/?hosted_button_id=PAQQTT9C5S7US" target="_blank"><i class="fa fa-paypal" aria-hidden="true"></i> General donations</a></p>
            <p><a class="btn btn-outline-cta" href="https://www.paypal.com/donate/?hosted_button_id=UDFKQ2JWYMNX8&source=url" target="_blank"><i class="fa fa-paypal" aria-hidden="true"></i> Clinic renovation</a></p>
        </div>

        <div class="infobox rounded">
            <p class="h5">Credit Card</p>
            <p>Please fill out the credit card donation authorization form and email it to <a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>, or send an email to request a mailing address.</p>
            <p>Credit card donations can be a one-time or monthly transaction.</p>
            <p><a class="btn btn-outline-cta" href="/documents/credit-card-donation-authorization-form.pdf" target="_blank"><i class="fa fa-credit-card" aria-hidden="true"></i> Authorization form</a></p>
        </div>

        <div class="infobox rounded">
            <p class="h5">Check or Money Order</p>
            <p>Please make checks and money orders payable to the Baja Animal Sanctuary and mail them to:</p>
            <p>
                {{ $bas['name'] }}
                <br />
                {{ $bas['mailing_address']['address_1'] }}
                <br />
                {{ $bas['mailing_address']['city'] }}, {{ $bas['mailing_address']['state'] }} {{ $bas['mailing_address']['zipcode_9'] }}
            </p>
        </div>

        <div class="infobox rounded">
            <p class="h5">Zelle</p>
            <p>Another easy way to donate:</p>
            <p>
                <img src="/images/donate/Zelle-logo-no-tagline-white.png" class="rounded" style="background-color: #6d1ed4; width: 90px;" alt="Zelle" />
            </p>
            <p>(858) 549-8148</p>
        </div>

        @include('snippets.amazon-wish-list')
    </div>
    <div class="col-md-3">
        <div class="infobox rounded">
            {{ $bas['disclaimers']['donation']['privacy'] }}
        </div>
        <div class="infobox rounded font-italic">
            {{ $bas['disclaimers']['donation']['501c3'] }}
        </div>
    </div>
</div>
