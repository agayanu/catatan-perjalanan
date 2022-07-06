<li class="nav-item">
    <a class="nav-link logout" href="{!! url('/logout') !!}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="nav-icon cil-account-logout logout"></i> Logout
    </a>
</li>
<li class="nav-item {{ Request::is('home') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('home') !!}">
        <i class="nav-icon cil-home"></i> Beranda
    </a>
</li>
<li class="nav-title">Menu</li>
<li class="nav-item {{ Request::is('note') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('note') !!}">
        <i class="nav-icon cil-location-pin"></i> Catatan Perjalanan
    </a>
</li>