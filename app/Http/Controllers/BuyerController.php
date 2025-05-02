<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Buyer;
use App\Http\Resources\buyerResource;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buyers = Buyer::all();
        return new buyerResource($buyers, 'Hi, Prettylicious', 'success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:buyers,email',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);
        if ($validator->fails()) {
            return new buyerResource(null, 'gagal', $validator->errors());
        }

        $buyer = Buyer::create($request->all());
            return new buyerResource($buyer, 'Data Buyer Berhasil Dibuat', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buyer = Buyer::find($id);
        if ($buyer) {
            return new buyerResource($buyer, 'Data Buyer Ditemukan', 'success');
        } else {
            return new buyerResource(null, 'Data Buyer tidak ditemukan', 'error');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buyer = Buyer::find($id);

        if ($buyer) {
            $buyer->update($request->all());
            return new buyerResource($buyer, 'Data Buyer berhasil diupdate', 'success');
        } else {
            return new buyerResource(null, 'Data Buyer tidak ditemukan', 'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buyer = Buyer::find($id);

        if ($buyer) {
            $buyer->delete();
            return new buyerResource(null, 'Data Buyer berhasil dihapus', 'success');
        } else {
            return new buyerResource(null, 'Data Buyer tidak ditemukan', 'error');
        }
    }
    
}
