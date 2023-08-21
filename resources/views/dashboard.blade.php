@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    <!-- Content Row -->
    <div class="row">


        <!-- Buttons -->
        <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="text-center">
            <i class="fas fa-user fa-2x text-gray-300"></i>
        </div>
        <div class="card-body">
            <a href="/userpemilik" class="btn btn-primary btn-block text-white">Pemilik</a>
        </div>
    </div>
</div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                  <div class="text-center">
            <i class="fas fa-search fa-2x text-gray-300"></i>
        </div>
                <div class="card-body">
                    <a href="/userpencari" class="btn btn-primary btn-block text-white">Pencari</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                  <div class="text-center">
            <i class="fas fa-building fa-2x text-gray-300"></i>
        </div>
                <div class="card-body">
                    <a href="/penginapan" class="btn btn-primary btn-block text-white">Penginapan</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                  <div class="text-center">
            <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
        </div>
                <div class="card-body">
                    <a href="/transaksi" class="btn btn-primary btn-block text-white">Transaksi</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                  <div class="text-center">
            <i class="fas fa-flag fa-2x text-gray-300"></i>
        </div>
                <div class="card-body">
                    <a href="/iklan" class="btn btn-primary btn-block text-white">Iklan</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->
</div>
@endsection
