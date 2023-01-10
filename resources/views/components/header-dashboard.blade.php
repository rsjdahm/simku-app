<header id="page-topbar">
    <div class="navbar-header bg-primary">
        <div class="d-flex">
            <div class="navbar-brand-box d-none d-lg-block">
                <a href="{{ route('home') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img rel="preload" src="{{ asset('img/logo-mini-dark.svg') }}" alt="Logo SiMKU" height="32">
                    </span>
                    <span class="logo-lg">
                        <img rel="preload" src="{{ asset('img/logo-dark.svg') }}" alt="Logo SiMKU" height="36">
                    </span>
                </a>
                <a href="{{ route('home') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img rel="preload" src="{{ asset('img/logo-mini-light.svg') }}" alt="Logo SiMKU"
                            height="32">
                    </span>
                    <span class="logo-lg">
                        <img rel="preload" src="{{ asset('img/logo-light.svg') }}" alt="Logo SiMKU" height="36">
                    </span>
                </a>
            </div>
            <button type="button" class="btn header-item d-lg-none px-3" id="vertical-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
            <div class="navbar-brand-box d-block d-lg-none">
                <a rel="preload" href="{{ route('home') }}" class="logo logo-dark">
                    <img src="{{ asset('img/logo-dark.svg') }}" alt="" height="36">
                </a>
                <a rel="preload" href="{{ route('home') }}" class="logo logo-light">
                    <img src="{{ asset('img/logo-light.svg') }}" alt="" height="36">
                </a>
            </div>
        </div>
        <div class="d-flex">
            <div class="dropdown d-inline-block">
                <span class="font-weight-bold text-light"
                    id="digital-clock">{{ Carbon\Carbon::now()->isoFormat('HH:mm:ss') }}</span>
                <script>
                    @if (env('DEBUGBAR_ENABLED') == 'true')
                        $(function() {
                            startTime();
                        });

                        function startTime() {
                            var today = new Date();
                            var h = today.getHours();
                            var m = today.getMinutes();
                            var s = today.getSeconds();
                            m = checkTime(m);
                            s = checkTime(s);
                            document.getElementById('digital-clock').innerHTML =
                                h + ":" + m + ":" + s;
                            var t = setTimeout(startTime, 500);
                        }

                        function checkTime(i) {
                            if (i < 10) {
                                i = "0" + i
                            }; // add zero in front of numbers < 10
                            return i;
                        }
                    @else
                        $(document).ready(function() {
                            setInterval(function() {
                                $.ajax({
                                    url: '{{ route('jam') }}',
                                    success: function(data) {
                                        $('#digital-clock').text(data)
                                    }
                                });
                            }, 1000)
                        });
                    @endif
                </script>
                <button type="button" class="btn header-item" id="page-header-user-dropdown" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('img/logo-rsjd.png') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ml-1">{{ Auth::user()->nama }}</span>
                    <i class="fas fa-angle-down d-none d-xl-inline-block ml-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <form id="logout_form" method="POST" action="{{ route('logout') }}">
                        <div class="dropdown-item">
                            <div class="avatar-md profile-user-wid mb-2">
                                <img src="{{ asset('img/avatar.png') }}" alt=""
                                    class="img-thumbnail rounded-circle">
                            </div>
                            <h5>{{ Auth::user()->nama }}</h5>
                            <p class="mb-2">{{ Auth::user()->jabatan }}</p>
                            <span class="badge badge-success"><i class="fas fa-user mr-1 align-middle"></i>
                                {{ Auth::user()->role }}</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        @csrf
                        <button type="submit" class="dropdown-item text-danger" href="{{ route('logout') }}">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<script type="text/javascript">
    $("#vertical-menu-btn").on("click", function(event) {
        event.preventDefault();
        $("main").toggleClass("sidebar-enable");
    })
    $("#logout_form").on("submit", function(event) {
        event.preventDefault();
        const form = $(this);
        const data = new FormData($(this)[0]);
        $.ajax({
            data,
            url: form.attr("action"),
            type: form.attr("method"),
            processData: false,
            contentType: false,
            success: function(response) {
                window.history.pushState({
                    href: BASE_URL
                }, '', BASE_URL)
                return load('#app', response);
            }
        });
        return false;
    });
</script>
