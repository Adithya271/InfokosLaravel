@component('mail::message')
# Introduction
Dear {{ $user->nama }}, silahkan klik link dibawah ini untuk konfirmasi pendaftaran.

@component('mail::button', ['url' => $url])
Konfirmasi
@endcomponent

<hr>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
