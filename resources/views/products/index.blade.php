@extends('layouts.app')
@section('content')
    <div class="row justify-content-end">
        <div class="col-2 align-content-end">
            <a href="{{ route('products.create') }}" class="btn btn-primary w-100">Buat</a>
        </div>
    </div>

    <x-message />

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Nama Produk</th>
                <th>Stock</th>
                <th>Harga Satuan</th>
                <th>Harga Jual</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
    </table>
@endsection
