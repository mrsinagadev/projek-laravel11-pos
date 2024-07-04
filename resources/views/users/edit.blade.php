@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-6">
        <h2>Ubah Data User</h2>
        <p>Tambahkan akun baru untuk pegawai toko.</p>
    </div>
<div class="col-6">
    <div class="card">
        <div class="card-body">
    <form action="{{ route('users.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $user->id }}">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input value="{{ old('name', $user->name) }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email">Alamat Email</label>
            <input value="{{ old('email', $user->email) }}" type="email" class="form-control @error('email') is-invalid @enderror " id="email" name="email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="username">Login Username</label>
            <input value="{{ old('username', $user->username) }}" type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username">
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="phone">Nomor Telepon</label>
            <input value="{{ old('phone', $user->phone) }}" type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="role">Jabatan</label>
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                <option value="">Pilih salah satu</option>
                <option value="1" @if (old('role', $user->role = 1) == 1)  selected @endif>Admin</option>
                <option value="2" @if (old('role', $user->role = 2) == 2) selected @endif>Kasir</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="photo_path">Foto Profil</label>
            <input value="{{ old('photo_path') }}" type="file" class="form-control @error('photo_path') is-invalid @enderror" id="photo_path" name="photo_path">
            @error('photo_path')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="my-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
            </div>
        </div>
    </div>
</div>
@endsection
