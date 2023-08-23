<x-mail::message>
    # Introduction
    Dear {{$user->nama}}, silahkan klik link dibawah ini untuk konfirmasi pendaftaran.

    <x-mail::button :url="$url">
        Konfirmasi
    </x-mail::button>

    <hr>
    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
