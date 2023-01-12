<li>
    <a data-menu="default" href="{{ route('dashboard.show') }}">
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="javascript: void(0);" class="has-arrow">
        <span>Nomenklatur</span>
    </a>
    <ul class="sub-menu">
        <li>
            <a data-menu="item" href="{{ route('urusan.index') }}">
                Urusan
            </a>
        </li>
        <li>
            <a data-menu="item" href="{{ route('bidang.index') }}">
                Bidang
            </a>
        </li>
        <li>
            <a data-menu="item" href="{{ route('program.index') }}">
                Program
            </a>
        </li>
        <li>
            <a data-menu="item" href="{{ route('kegiatan.index') }}">
                Kegiatan
            </a>
        </li>
        <li>
            <a data-menu="item" href="{{ route('sub-kegiatan.index') }}">
                Sub Kegiatan
            </a>
        </li>
    </ul>
</li>
<li>
    <a href="javascript: void(0);" class="has-arrow">
        <span>Unit Kerja</span>
    </a>
    <ul class="sub-menu">
        <li>
            <a data-menu="item" href="{{ route('unit-kerja.index') }}">
                Unit Kerja
            </a>
        </li>
        <li>
            <a data-menu="item" href="{{ route('sub-unit-kerja.index') }}">
                Sub Unit Kerja
            </a>
        </li>
    </ul>
</li>
<li>
    <a href="javascript: void(0);" class="has-arrow">
        <span>Rekening</span>
    </a>
    <ul class="sub-menu">
        <li>
            <a data-menu="item" href="{{ route('rek-akun.index') }}">
                Rek. Akun
            </a>
        </li>
        <li>
            <a data-menu="item" href="{{ route('rek-kelompok.index') }}">
                Rek. Kelompok
            </a>
        </li>
        <li>
            <a data-menu="item" href="{{ route('rek-jenis.index') }}">
                Rek. Jenis
            </a>
        </li>
        <li>
            <a data-menu="item" href="{{ route('rek-objek.index') }}">
                Rek. Obj
            </a>
        </li>
        <li>
            <a data-menu="item" href="{{ route('rek-rincian-objek.index') }}">
                Rek. Rincian Obj
            </a>
        </li>
        <li>
            <a data-menu="item" href="{{ route('rek-sub-rincian-objek.index') }}">
                Rek. Sub Rincian Obj
            </a>
        </li>
    </ul>
</li>
