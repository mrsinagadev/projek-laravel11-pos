<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $custom_message =
    //untuk parameter ke2 validate, kustom tulisan eror
    [
        '*.required' => ':Attribute jangan dikosongkan.',
        'photo_path.max' => ':Attribute maksimal :max kilobyte.',
        '*.max' => ':Attribute maksimal :max karakter.',
        '*.email' => ':Attribute harus berupa email yang valid.',
        '*.unique' => ':Attribute sudah terdaftar!',
        '*.min' => ':Attribute minimal :min karakter.',
        '*.alpha_num' => ':Attribute hanya terdiri dari huruf dan angka.',
        '*.image' => ':Attribute harus berupa gambar.',
        '*.mimes' => 'Format :attribute hanya berupa :mimes.'

    ];
    public $custom_attribute =
    //untuk parameter ke3 validate, kustom attribute
    [
        'name' => 'Nama Lengkap',
        'email' => 'Alamat Email',
        'username' => 'Nama Pengguna',
        'password' => 'Kata Sandi',
        'phone' => 'Nomor Telepon',
        'role' => 'Jabatan',
        'photo_path' => 'Foto Profil'
    ];
    public function index()
    {
        //panggil semua data user dari tabel
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }

    public function create()
    {
        //menampilkan form untuk membuat user baru
        return view('users.create');
    }
    public function store(Request $request)
    {
        //simpan data user
        //cek data yang dikirim
        $validasi = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|min:6|unique:users,username',
            'password' => 'required|min:8|alpha_num',
            'phone' => 'required|min:9',
            'role' => 'required',
            'photo_path' => 'nullable|image|max:1024|mimes:jpg,jpeg,png'
        ],
            $this->custom_message,
            $this->custom_attribute
    );
        // periksa apakah ada file foto yang diunggah
        $alamat = null;
        if($request->hasFile('photo_path')) {
            $alamat = Storage::disk('public')
            ->putFile('foto-profil', $request->file('photo_path'));
        }
        //simpan data user
        $hasil = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            //kata sandi harus di hash
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'photo_path' => $alamat
        ]);
        //alihkan halaman jika sukses atau gagal
        if($hasil) {
            return redirect()->route('users.index')->with('success', 'Data user berhasil disimpan!');
        }
        return redirect()->back()->with('error', 'Data user gagal disimpan, Terjadi kesalahan saat menyimpan data!');
    }

    public function edit($id)
    {
        //temukan user
        $user = User::find($id);
        if(!$user){
            return to_route('users.index');
        }
        return view('users.edit', ['user' => $user]);
    }
    public function update(Request $request)
    {
        $validasi = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'username' => 'required|min:6|unique:users,username',
            'phone' => 'required|min:9',
            'role' => 'required',
            'photo_path' => 'nullable|image|max:1024|mimes:jpg,jpeg,png'
        ],
            $this->custom_message,
            $this->custom_attribute
        );
        $alamat = null;
        if($request->hasFile('photo_path')) {
            $alamat = Storage::disk('public')
            ->putFile('foto-profil', $request->file('photo_path'));
        }
        User::find($request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'role' => $request->role,
            'photo_path' => $alamat
        ]);
        return to_route('users.index')->with('success', 'Data user berhasil diubah.');
    }

    public function delete($id)
    {
        User::find($id)->delete();
        return to_route('users.index')->with('success', 'Data user berhasil dihapus.');
    }
}
