<div class="row">
    <div class="col-md">
        <div class="infobox rounded important" id="newsletter-display">
            <p class="h5"></p>
            <p>
                Trouble viewing the PDF?
                <br />
                <a><i class="fa fa-sign-out" aria-hidden="true"></i> Open in a new tab (<span class="size"></span>)</a>
            </p>
            <div class="pdf"></div>
        </div>
    </div>
    <div class="col-md-3">
        @php
            $current = $newsletters['data']['newsletters'][$newsletters['data']['current']];
        @endphp
        <div class="h4">Current Issue</div>
        <div class="infobox rounded">
            <p class="h5">{{ $current->year }}</p>
            <div><a href="#{{ $current->filename }}">{{ $current->month }}</a></div>
        </div>
        <div class="h4">Archive</div>
        @foreach ($newsletters['data']['archive'] as $year => $year_list)
            <div class="infobox rounded">
                <p class="h5">{{ $year }}</p>
                @foreach ($year_list as $filename)
                    @php
                    $newsletter = $newsletters['data']['newsletters'][$filename];
                    @endphp
                    <div><a href="#{{ $newsletter->filename }}">{{ $newsletter->month }}</a></div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
