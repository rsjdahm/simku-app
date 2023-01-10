<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                Copyright © {{ date('Y') }} {{ config('app.meta.company') }}
            </div>
            <div class="col-sm-6">
                <div class="text-sm-right d-block">
                    {{-- <img class="mr-2" src="{{ asset('img/bsre.png') }}" height="42" />
                    <img class="mr-2" src="{{ asset('img/logo-berakhlak.png') }}" height="28" /> --}}
                    <span class="badge badge-success"><i
                            class="fas fa-check mr-1 align-middle"></i><strong>simku.id</strong>
                        |
                        V{{ config('app.meta.version') }}</span>
                </div>
            </div>
        </div>
    </div>
</footer>
