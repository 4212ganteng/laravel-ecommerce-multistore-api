<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Adress;


class AdressController extends Controller
{
    //index
    public function index(Request $request)
    {
        $adresses = $request->user()->adresses;
        return response()->json([
            'status' => 'success',
            'message' => 'List data adresses',
            'data' => $adresses
        ]);
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'postal_code' => 'required|string',
            'address' => 'required|string',
            'is_default' => 'boolean'
        ]);

        $adress = Adress::create([
            'user_id' => $request->user()->id,
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'is_default' => $request->is_default
        ]);



        return response()->json([
            'status' => 'success',
            'message' => 'Data adress berhasil disimpan',
            'data' => $adress
        ], 201);
    }


    // update
    public function update(Request $request, $id)
    {
        $request->validate([
            'country' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'postal_code' => 'required|string',
            'address' => 'required|string',
            'is_default' => 'boolean'
        ]);

        $address = Adress::find($id);
        if (!$address) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data adress tidak ditemukan'
            ], 404);
        }

       $address->update([
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'is_default' => $request->is_default
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data adress berhasil diubah',
            'data' => $address
        ]);
    }


    // destroy
    public function destroy($id)
    {
        $address = Adress::find($id);
        if (!$address) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data adress tidak ditemukan'
            ], 404);
        }

        $address->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data adress berhasil dihapus'
        ]);
    }
}
