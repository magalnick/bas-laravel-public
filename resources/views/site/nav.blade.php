<nav class="navbar sticky-top navbar-expand-xl navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerMainNav" aria-controls="navbarTogglerMainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerMainNav">
        <a class="navbar-brand" href="/"><i class="fa fa-paw" aria-hidden="true"></i> {{ $app_name }}</a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            @foreach (config('bas.view.pages') as $this_page)
                @if ($this_page['show_in_navigation'])
                    @php
                        // set up the "current" variables for each link in the nav
                        $current_text = $this_page['id'] === $page ? ' <span class="sr-only">(current)</span>' : '';
                        $class        = $this_page['id'] === $page ? 'nav-item active' : 'nav-item';
                    @endphp

                    <li class="{{ $class }}">
                        <a class="nav-link" href="{{ $this_page['path'] }}">{!! $this_page['title'] . $current_text !!}</a>
                    </li>
                @endif
            @endforeach
        </ul>

        <a class="btn btn-outline-cta" href="/donate" role="button">Donate</a>

{{--
        <ul class="navbar-nav ml-md-auto social">
            @include('site.nav.social')
        </ul>
--}}
{{--
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
--}}
    </div>
</nav>
