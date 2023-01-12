<li>
    <a data-menu="default" href="{{ route('dashboard.show') }}">
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="javascript: void(0);" class="has-arrow">
        <span>Database</span>
    </a>
    <ul class="sub-menu">
        <li>
            <a data-menu="item" href="{{ route('migration.index') }}">
                Migration
            </a>
        </li>
    </ul>
</li>
