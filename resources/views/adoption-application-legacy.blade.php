<div class="row">
    <div class="col-md">
        @foreach (json_decode($application, true) as $key => $value)
            <div class="row infobox">
                <div class="col-sm-5">{{ $key }}</div>
                <div class="col-sm-7">
                    {!! join('<br />', $value) !!}
                </div>
            </div>
        @endforeach
    </div>

    <div class="col-md-4">
        <div class="infobox">
            <p class="h5">What is this page?</p>
            <p class="text-justify">
                As we've redesigned our website to make it more modern and user friendly,
                some of the older functionality still needs to work.
                This legacy adoption application page is here so you can still see past applications you've submitted
                by clicking an email link or viewing a bookmarked page.
            </p>
        </div>

        <div class="h5 infobox text-center">
            <a href="{{ $bas_view['pages']['adoption-applications']['path'] }}">Start a new adoption application</a>
        </div>
    </div>
</div>
