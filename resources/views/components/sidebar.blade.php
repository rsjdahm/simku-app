<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div class="px-3 py-3">
            <div class="row">
                <div class="col-3">
                    <span style="line-height: 36px; font-weight: bold;">Modul:</span>
                </div>
                <div class="col-9">
                    <select name="module-menu" class="form-control" style="width: 100%;">
                        {{-- <option disabled selected>-- Pilih Modul --</option> --}}
                        @foreach (explode(',', Auth::user()->modul) as $modul)
                            <option value="{{ $modul }}">{{ Str::title($modul) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="sidebar"></ul>
        </div>
        <div class="p-3">
            <div class="card p-3 text-center">
                <strong>
                    <h5>S i M K U - V{{ config('app.meta.version') }}</h5>
                </strong>
                <p class="mb-3">Aplikasi Sistem Informasi Manajemen Keuangan RSJD Atma Husada Mahakam</p>
                <a href="https://walid.id" class="btn btn-success btn-sm">SIMKU.ID</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        const module = (new URLSearchParams(window.location.search)).get('module');
        if (module) {
            $("select[name='module-menu']").val(module).change();
        } else {
            if ($("select[name='module-menu']").val()) {
                $("select[name='module-menu']").val($("select[name='module-menu']").val()).change();
            }
        }
    });

    function activateMenu() {
        const hash = (new URLSearchParams(window.location.search)).get('route');
        if (hash) {
            const new_url = BASE_URL + '/' + hash;

            $(".metismenu .active").removeClass('active');

            $('a[data-menu][href="' + new_url + '"]')
                .addClass("active");
            $('a[data-menu][href="' + new_url + '"]')
                .parents('li').children('a').addClass('active');
            $('a[data-menu][href="' + new_url + '"]')
                .parents('li').addClass('mm-active active');
            $('a[data-menu][href="' + new_url + '"]')
                .parents('ul.sub-menu').addClass('mm-show');
        } else {
            // if no history
            $('a[data-menu="default"]').addClass('active').parents('li').addClass('mm-active active');
        }
    }

    // save to history loader
    $("body").on('click', 'a[data-menu]', function(event) {
        event.preventDefault();
        const anchor = $(this);

        load('#page', anchor.attr('href'), function() {
            let url = new URL(window.location);
            url.searchParams.set('route', anchor.attr('href').replace(BASE_URL + '/', ''));
            window.history.pushState({}, '', url)
            activateMenu();
        });

        return false;
    });

    $('main').click(function(event) {
        if ($('main').hasClass("sidebar-enable")) {
            var $target = $(event.target);
            if (!$target.closest('.vertical-menu').length &&
                !$target.closest('#vertical-menu-btn').length) {
                $('main').removeClass('sidebar-enable');
            }
        }
    });

    $("select[name='module-menu']").change(function() {
        const val = $(this).val();
        const url = "{{ route('menu-modul') }}" + "/" + val;
        $("#sidebar").metisMenu('dispose');
        load('#sidebar', url, function() {
            let url = new URL(window.location);
            url.searchParams.set('module', val);

            // let defaultUrl = $('a[data-menu="default"]').data('href').replace(BASE_URL + '/', '');
            // url.searchParams.set('route', defaultUrl);

            window.history.pushState({}, '', url)
            $("#sidebar").metisMenu();

            activateMenu();

            // load($('a[data-menu="default"]').data('load'), $('a[data-menu="default"]').data('href'));
        });
    });
</script>
