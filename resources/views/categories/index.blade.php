@extends('layouts.app')
@section('content')
<div class="row justify-content-end">
    <div class="col-2 align-content-end">
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#createModal">Buat</button>
    </div>
</div>

{{-- modal create --}}
<x-modal id="createModal">
    <x-slot name="title">Tambah Kategori</x-slot>
    <x-slot name="content">
        <form id="frmCreate" action="{{ route('categories.store')}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="mb-3">
                    <label for="name">Nama Kategori</label>
                    <input type="text" name="name" id="name" value="{{ old('nama') }}" class="form-control @error('name') is-invalid @enderror">
                </div>
        </form>
    </x-slot>
    <x-slot name="action">
        <button onclick="document.getElementById('frmCreate').submit()" type="button" class="btn btn-primary ml-2">Simpan</button>
    </x-slot>
</x-modal>

{{-- komponen message --}}
<x-message />

<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Jumlah Produk</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
@endsection
