<main data-topbar="dark" data-layout="horizontal">
    <div id="layout-wrapper">

        @include('components.header-auth')

        @include('components.topbar')

        <div class="main-content">
            <div class="page-content">
                <div id="page"></div>
            </div>

            @include('components.footer')
        </div>
    </div>
</main>
<script type="text/javascript">
    /// call initial page of auth layout: login page
    $(document).ready(function() {
        load('#page', '{{ route('login') }}');
    });
</script>
