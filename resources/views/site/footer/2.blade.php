<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <nav class="navbar navbar-expand-sm">
                    <span class="navbar-text">Copyright &copy;{{ date('Y') }} {{ $legal_name }} All rights reserved.</span>
                </nav>
            </div>
            <div class="col-sm-6">
                <nav class="navbar navbar-expand-sm">
                    <ul class="navbar-nav ml-md-auto social">
                        @include('site.nav.social')
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</footer>
