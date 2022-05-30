<div class="row mb-3">
    <div class="col-md">
        <div class="row m-auto">
            @foreach ($favorite_businesses as $category => $favorite_business)
                <div class="col-md text-center infobox rounded mb-0" id="favorite-business-tab-{{ $category }}">
                    <a href="#{{ $category }}">{{ $favorite_business['heading'] }}</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md">
        @foreach ($favorite_businesses as $category => $favorite_business)
            <div id="favorite-business-{{ $category }}">
                @foreach ($favorite_business['businesses'] as $business)
                    @php
                        $url_and_email_tags = [];
                        if (isset($business['url']) && $business['url'] !== '') {
                            $url_and_email_tags[] = "<a href=\"http://{$business['url']}/\" target=\"_blank\">{$business['url']}</a>";
                        }
                        if (isset($business['email']) && $business['email'] !== '') {
                            $url_and_email_tags[] = "<a href=\"mailto:{$business['email']}\">{$business['email']}</a>";
                        }

                        $business_links = [];
                        if (isset($business['links']) && !empty($business['links'])) {
                            foreach ($business['links'] as $link) {
                                $business_links[] = "<a href=\"{$link['url']}\" target=\"_blank\">{$link['title']}</a>";
                            }
                        }
                    @endphp
                    <div class="infobox rounded">
                        @if (isset($business['image']))
                            <div>
                                <img src="{{ $business['image']['src'] }}" alt="{{ $business['image']['alt'] }}" class="rounded float-right" style="width: {{ $business['image']['width'] }}px; height: {{ $business['image']['height'] }}px;" />
                            </div>
                        @endif
                        <p class="h5">{{ $business['name'] }}</p>
                        @if (isset($business['taglines']) && !empty($business['taglines']))
                            <p>{!! join('<br />', $business['taglines']) !!}</p>
                        @endif
                        @if (isset($business['contacts']) && !empty($business['contacts']))
                            @foreach ($business['contacts'] as $contact)
                            <p>{!! join('<br />', $contact) !!}</p>
                            @endforeach
                        @endif
                        @if (!empty($url_and_email_tags))
                            <p>{!! join('<br />', $url_and_email_tags) !!}</p>
                        @endif
                        @if (!empty($business_links))
                            <p>{!! join('<br />', $business_links) !!}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    <div class="col-md-3">
        <div class="infobox rounded">
            <div>Is there a local business you'd like to see listed?</div>
            <div>&nbsp;</div>
            <div><a href="mailto:{{ config('bas.contacts.main.email') }}">Email us a suggestion</a>.</div>
        </div>
    </div>
</div>
