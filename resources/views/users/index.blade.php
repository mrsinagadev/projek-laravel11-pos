@extends('layouts.app')
@section('content')
<div class="row justify-content-end">
    <div class="col-2 align-content-end">
        <a href="{{ route('users.create') }}" class="btn btn-primary w-100">Buat</a>
    </div>
</div>

<x-message />

<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Jabatan</th>
            <th>Nama</th>
            <th>Kontak</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $i => $user )
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $user->role == 1 ? 'Admin' : 'Kasir' }}</td>
                <td>{{ $user->name }}</td>
                <td>
                    {{ $user->email }}
                    <div class="text-xs">{{ $user->phone }}</div>
                </td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Ubah</a>
                    <button onclick="document.getElementById('delete-{{ $user->id }}').submit()" class="btn btn-sm btn-danger">Hapus</button>
                </td>
            </tr>
            <form action="{{ route('users.delete', $user->id)}}" method="post" id="delete-{{ $user->id }}">@csrf </form>
        @endforeach
    </tbody>
</table>
@endsection
