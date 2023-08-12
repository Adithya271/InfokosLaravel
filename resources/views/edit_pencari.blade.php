@extends('layouts.admin')

@section('content')

<div class="container">
    <h1 class="mb-4">Edit Pencari Kos</h1>
    <form action="{{ url('/userpencari/' . $userpencari->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="profilGambar">Foto Profil</label>
            <input type="file" class="form-control" id="profilGambar" name="profilGambar">
            @if($userpencari->profilGambar)
                <img src="{{ asset('storage/images/' . $userpencari->profilGambar) }}" alt="Foto Profil" width="50" height="50">
            @endif
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $userpencari->nama }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $userpencari->email }}">
        </div>
        <div class="form-group">
            <label for="nomorHp">Nomor HP</label>
            <input type="text" class="form-control" id="nomorHp" name="nomorHp" value="{{ $userpencari->nomorHp }}">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
         <div class="form-group">
            <label for="email_verified_at">Email Verified At</label>
            <input type="text" class="form-control" id="email_verified_at" name="email_verified_at" value="{{ $userpencari->email_verified_at }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

@endsection
