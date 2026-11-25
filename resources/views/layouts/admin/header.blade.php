<header class="top">
    <button class="ib tgl" id="tgl" aria-label="Buka menu"><svg class="ic"><use href="#i-menu"/></svg></button>
    <div class="grow"></div>
    <a class="ib" href="{{ route('notifikasi.index') }}" aria-label="Notifikasi">
        <svg class="ic"><use href="#i-bell"/></svg>
        @if($belum)<span class="dot"></span>@endif
    </a>
    <a class="av" href="{{ route('profil.edit') }}" title="{{ $user->name }}">@include('layouts.admin.avatar')</a>
</header>
