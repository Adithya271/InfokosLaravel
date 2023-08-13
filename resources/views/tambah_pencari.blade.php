@extends('layouts.admin')

@section('content')

<div class="container">
    <h1 class="mb-4">Tambah Pencari Kos</h1>
    <form action="{{ route('userpencari.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="profilGambar">Foto Profil</label>
            <input type="file" class="form-control" id="profilGambar" name="profilGambar">
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label for="nomorHp">Nomor HP</label>
            <input type="text" class="form-control" id="nomorHp" name="nomorHp" value="{{ old('nomorHp') }}">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="email_verified_at">Email Verified At</label>
            <input type="text" class="form-control" id="email_verified_at" name="email_verified_at" value="{{ old('email_verified_at') }}">
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
</div>

@endsection
