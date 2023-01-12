<li>
    <a data-load="#page" data-menu="default" href="{{ route('dashboard.show') }}">
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="javascript: void(0);" class="has-arrow">
        <span>Pengeluaran</span>
    </a>
    <ul class="sub-menu">
        <li>
            <a data-load="#page" data-menu="item" href="{{ route('bukti-gu.index') }}">
                Bukti GU
            </a>
        </li>
        <li>
            <a data-load="#page" data-menu="item" href="{{ route('belanja-ls.index') }}">
                Belanja LS
            </a>
        </li>
    </ul>
</li>
