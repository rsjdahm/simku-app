<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <button type="button" class="btn d-lg-none header-item px-3" data-toggle="collapse"
                data-target="#topnav-menu-content">
                <i class="fas fa-bars"></i>
            </button>
            <div class="navbar-brand-box">
                <a rel="preload" href="{{ url('/') }}" class="logo logo-dark">
                    <img src="{{ asset('img/logo-dark.svg') }}" alt="" height="36">
                </a>
                <a rel="preload" href="{{ url('/') }}" class="logo logo-light">
                    <img src="{{ asset('img/logo-light.svg') }}" alt="" height="36">
                </a>
            </div>
        </div>
        <div class="d-flex">
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Cari sesuatu di sini...">
                    <span class="fas fa-search"></span>
                </div>
            </form>
        </div>
    </div>
</header>
