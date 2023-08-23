<x-message>
    # Introduction
    Dear {{ $user->nama }}, silahkan klik link dibawah ini untuk konfirmasi pendaftaran.

    <x-button :url="$url">
        Konfirmasi
    </x-button>

    <hr>
    Thanks,<br>
    {{ config('app.name') }}
</x-message>
