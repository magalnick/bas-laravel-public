@foreach (config('bas.social_media') as $platform => $social_media)
    <li class="nav-item">
        <a class="nav-link pl-2 pr-1 mx-1 py-3 my-n2 h5" id="social-{{ $platform }}" href="{{ $social_media['url'] }}" target="_blank" aria-label="{{ $social_media['platform'] }}" data-toggle="tooltip" data-placement="bottom" title="{{ $social_media['tagline'] }}">
            <i class="{{ $social_media['fontawesome'] }}" aria-hidden="true"></i>
        </a>
    </li>
@endforeach
