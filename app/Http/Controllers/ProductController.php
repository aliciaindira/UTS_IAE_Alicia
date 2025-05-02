<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;
use App\Http\Resources\productResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();
        return new productResource ($product , 'Products List', 'success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:products,name',
            'price' => 'required|numeric|min:100000',
            'category' => 'required|in:Kaos,Kemeja,Dress,Skirt,Jeans',
            'size' => 'required|in:S,M,L,XL,XXL',
            'color' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'material' => 'required|in:Cotton,Denim,Silk,Satin'
        ]);
    
        if ($validator->fails()) {
            return new ProductResource(null, 'Validasi gagal', $validator->errors());
        }
    
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'size' => $request->size,
            'color' => $request->color,
            'stock' => $request->stock, // pakai stock dari $stockMap, bukan dari inputan
            'description' => $request->description,
            'material' => $request->material,
        ]);
    
        return new productResource($product, 'Product telah berhasil ditambahkan', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            return new productResource($product, 'Product Ditemukan', 'success');
        } else {
            return new productResource(null, 'Product tidak ditemukan', 'error');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product =Product::find($id);

        if ($product) {
            $product->update($request->all());
            return new productResource($product, 'Product Berhasil Diupdate', 'success');
        } else {
            return new productResource(null, 'Product tidak ditemukan', 'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product =Product::find($id);

        if ($product) {
            $product->delete();
            return new productResource(null, 'Product Berhasil Dihapus', 'success');
        } else {
            return new productResource(null, 'Product tidak ditemukan', 'error');
        }
    }
}
