<aside class="side" id="side">
    <div class="brand"><img class="logo-ic" src="{{ asset('assets-admin/img/logo-icon.svg') }}" alt="Logo ReSawit"><span><em>Re</em>Sawit</span></div>

    <div class="grp">MENU</div>
    <a class="nav {{ request()->routeIs('dashboard') ? 'on' : '' }}" href="{{ route('dashboard') }}"><svg class="ic"><use href="#i-home"/></svg>Dashboard</a>

    @if($admin)
        <div class="grp">DATA MASTER</div>
        <a class="nav {{ request()->routeIs('petani.*') ? 'on' : '' }}" href="{{ route('petani.index') }}"><svg class="ic"><use href="#i-users"/></svg>Data Petani</a>
        <a class="nav {{ request()->routeIs('kebun.*') ? 'on' : '' }}" href="{{ route('kebun.index') }}"><svg class="ic"><use href="#i-leaf"/></svg>Data Kebun</a>
        <a class="nav {{ request()->routeIs('panduan.*') ? 'on' : '' }}" href="{{ route('panduan.index') }}"><svg class="ic"><use href="#i-book"/></svg>Panduan</a>

        <div class="grp">MONITORING</div>
        <a class="nav {{ request()->routeIs('notifikasi.*') ? 'on' : '' }}" href="{{ route('notifikasi.index') }}"><svg class="ic"><use href="#i-bell"/></svg>Notifikasi @if($belum)<span class="cnt">{{ $belum }}</span>@endif</a>
        <a class="nav {{ request()->routeIs('laporan.*') ? 'on' : '' }}" href="{{ route('laporan.siap') }}"><svg class="ic"><use href="#i-file"/></svg>Laporan</a>

        <div class="grp">SISTEM</div>
        <a class="nav {{ request()->routeIs('pengguna.*') ? 'on' : '' }}" href="{{ route('pengguna.index') }}"><svg class="ic"><use href="#i-users"/></svg>Pengguna</a>
        <a class="nav {{ request()->routeIs('pengaturan.*') ? 'on' : '' }}" href="{{ route('pengaturan.edit') }}"><svg class="ic"><use href="#i-gear"/></svg>Pengaturan</a>
    @else
        <div class="grp">KEBUN</div>
        <a class="nav {{ request()->routeIs('kebun.*') ? 'on' : '' }}" href="{{ route('kebun.index') }}"><svg class="ic"><use href="#i-leaf"/></svg>Kebun Saya</a>
        <a class="nav {{ request()->routeIs('notifikasi.*') ? 'on' : '' }}" href="{{ route('notifikasi.index') }}"><svg class="ic"><use href="#i-bell"/></svg>Notifikasi @if($belum)<span class="cnt">{{ $belum }}</span>@endif</a>
    @endif

    <div class="grp">AKUN</div>
    <a class="nav {{ request()->routeIs('profil.*') ? 'on' : '' }}" href="{{ route('profil.edit') }}"><svg class="ic"><use href="#i-user"/></svg>Profil Saya</a>

    <form method="POST" action="{{ route('logout') }}" style="margin-top:8px">
        @csrf
        <button type="submit" class="nav"><svg class="ic"><use href="#i-out"/></svg>Keluar</button>
    </form>

    <div class="user">
        <a class="av" href="{{ route('profil.edit') }}" title="Profil saya">@include('layouts.admin.avatar')</a>
        <div>
            <b style="color:#fff">{{ $user->name }}</b>
            <div style="font-size:12px;color:#8FB0A0">{{ $user->email }}</div>
        </div>
    </div>
</aside>
