@if($user->foto_url)<img src="{{ $user->foto_url }}" alt="Foto {{ $user->name }}">@else{{ $user->inisial }}@endif
