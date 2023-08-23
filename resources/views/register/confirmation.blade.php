@component('mail::message')
# Introduction
Dear {{ $user->nama }}, silahkan klik dibawah ini untuk konfirmasi pendaftaran.

@component('mail::button', ['url' => $url])
Konfirmasi Pendaftaran
@endcomponent

<hr>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
