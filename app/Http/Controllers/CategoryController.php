<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::latest()->with('user', 'products')->get();
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // terima data dari form modal
        $validated = Validator::validate($request->all(), [
            'name' => 'required|string|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori harus diisi',
            'nama.string' => 'Penulisan Nama kategori tidak valid!',
            'nama.unique' => 'Nama kategori sudah terdaftar!',
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
        ]);

        return back()->with('success', 'Data kategori berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'Nama kategori harus diisi',
            'nama.unique' => 'Nama Kategori sudah terdaftar!',
        ]);
        $category->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Data Kategory berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Data Kategori berhasil dihapus!');
    }
}
