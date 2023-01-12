<li>
    <a data-menu="default" href="{{ route('dashboard.show') }}">
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="javascript: void(0);" class="has-arrow">
        <span>Penganggaran</span>
    </a>
    <ul class="sub-menu">
        <li>
            <a data-menu="item" href="{{ route('rka-pd.index') }}">
                Rencana Anggaran
            </a>
        </li>
        <li>
            <a data-menu="item" href="{{ route('belanja-rka-pd.index') }}">
                Rincian Belanja
            </a>
        </li>
    </ul>
</li>
