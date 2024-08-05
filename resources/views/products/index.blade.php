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
            @forelse ($products as $i => $product )
                <tr>
                    <td>{{ $products->firstItem() + $i }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->selling_price }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-xs">Ubah</a>
                        {{-- <button class="btn btn-danger btn-xs" onclick="confirm('Yakin ingin menghapus ?' document.getElementById('delete-{{ $product->id }}').submit() : null">Hapus</button> --}}
                        <button onclick="document.getElementById('delete-{{ $product->id }}').submit()" class="btn btn-danger btn-xs">Hapus</button>
                    </td>
                </tr>
                <form style="display: none" action="{{ route('products.destroy', $product->id) }}" method="POST" id="delete-{{ $product->id }}">
                    @csrf
                    @method("DELETE")
                </form>
            @empty
                <tr>
                    <td colspan="7">Data tidak ditemukan atau masih kosong.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div>
        {{ $products->links() }}
    </div>
@endsection
