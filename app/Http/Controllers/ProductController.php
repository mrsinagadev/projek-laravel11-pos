<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // rules validasi
    protected $rules =  [
            // 'name' => 'required|unique:products,name' . $id ? (',' . $id) : '',
            'stock' => 'nullable',
            'price' => 'required|min:0',
            'selling_price' => 'required|min:0',
            'description' => 'nullable',
        ];
    // custom attribute
    protected $attributes = [
        'name' => 'nama produk',
        'price' => 'harga modal',
        'selling_price' => 'harga jual',
        'description' => 'deskripsi produk',
    ];
    // custom message
    protected $messages = [
        '*.required' => ':Attribute harus diisi.',
        '*.min' => ':Attribute minimal bernilai :value.',
        '*.unique' => ':Attribute sudah terdaftar.',
    ];

    public function index()
    {
        //panggil semua data produk
        //paginate berfungsi untuk membatas data maksimal 10 data
        $products = Product::latest()->with(['user', 'category'])->paginate(5);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Product::class);
        //panggil semua data kategori dan urutkan berdasarkan nama
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Hanya admin yang boleh simpan data
        //Berdasarkan policy yang ada di ProductPolicy
        Gate::authorize('create', Product::class);
        // untuk mengecek inputan
        // dd($request->all());
        $rules = $this->rules;
        $rules['name'] = 'required|unique:products,name';
        $validated = $request->validate(
            $rules,
            $this->messages,
            $this->attributes
        );

        // simpan data
        $simpan = Product::create ([
            'category_id' => $request->category,
            'user_id' => Auth::id(),
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'selling_price' => $request->selling_price,
            'description' => $request->description,
        ]);
        return to_route('products.index')->with('success', 'Data Produk berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        Gate::authorize('update', $product);

        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        Gate::authorize('update', $product);

        $rules = $this->rules;
        $rules['name'] = 'required|unique:products,name,' . $product->id;
        $validated = $request->validate(
            $rules,
            $this->messages,
            $this->attributes
        );
        // update data product
        $product->update([
            'category_id' => $request->category,
            // 'user_id' => Auth::id(),
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'selling_price' => $request->selling_price,
            'description' => $request->description,
        ]);
        return to_route('products.index')->with('success', 'Data Produk berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Product $product)
    // {
    //     $product->delete();
    //     // return back()->with('success', 'Data Produk berhasil dihapus!');
    //     return to_route('products.index')->with('success', 'Data Produk berhasil dihapus.');
    // }

    // public function destroy($id)
    // {
    //     Gate::authorize('delete', Product::class);

    //     Product::find($id)->delete();
    //     return to_route('products.index')->with('success', 'Data Produk berhasil dihapus.');
    // }
    public function destroy(Product $product)
	{
		Gate::authorize('delete', $product);

		$product->delete();
		return back()->with('success', 'Data produk berhasil dihapus.');
	}
}
