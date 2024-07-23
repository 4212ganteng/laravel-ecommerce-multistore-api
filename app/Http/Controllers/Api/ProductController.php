<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //index
    public function index(Request $request)
    {
        $products = Product::where('seller_id',$request->user()->id)->with('seller')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'List data products',
            'data' => $products
        ]);
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'string',
            'price' => 'required',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        // check image
        $image = null;
        if ($request->hasFile('image')) {
           $image = $request->file('image')->store('assets/products','public');
        }

        $product = Product::create([
            'seller_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $image,
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data product berhasil disimpan',
            'data' => $product
        ],201);
    }

    //update
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if($product->seller_id != $request->user()->id){
            return response()->json([
                'status' => 'error',
                'message' => 'Data product tidak ditemukan'
            ],404);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'string',
            'price' => 'required',
            'stock' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
        ]);


        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_active' => $request->is_active,

        ]);

        // check image
        if ($request->hasFile('image')) {
           $image = $request->file('image')->store('assets/products','public');
           $product->image = $image;
              $product->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data product berhasil diupdate',
            'data' => $product
        ],200);
    }

    // destroy
    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        if($product->seller_id != $request->user()->id){
            return response()->json([
                'status' => 'error',
                'message' => 'Data product tidak ditemukan'
            ],404);
        }

        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data product berhasil dihapus'
        ],200);
    }
}
