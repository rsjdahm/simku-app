<main data-topbar="colored">
    <div id="layout-wrapper">

        @include('components.header-dashboard')

        @include('components.sidebar')

        <div class="main-content">
            <div class="page-content">
                <div id="page"></div>
            </div>

            @include('components.footer')
        </div>
    </div>
</main>

<script type="text/javascript">
    $(document).ready(function() {
        const hash = (new URLSearchParams(window.location.search)).get('route');
        if (hash) {
            return load('#page', BASE_URL + '/' + hash);
        } else {
            return load('#page', '{{ route('dashboard.show') }}');
        }

    });
</script>