<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
         $product =Product::all();
         return response()->json([
                'success'=>true,
                'product'=>$product,

            ],200);
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage(),
                'line'=>$e->getLine(),
                'file'=>$e->getFile(),
            ],500);
        }
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
        try{
             $product=$request->validate([
            'name'=>'required',
            'details'=>'required',
            'price'=>'required',
         ]);
         $new =Product::create($product);
         return response()->json([
                'success'=>true,
                'product'=>$new,

            ],201);
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage(),
                'line'=>$e->getLine(),
                'file'=>$e->getFile(),
            ],500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
       try{
         return response()->json([
                'success'=>true,
                'product'=>$product,

            ],200);
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage(),
                'line'=>$e->getLine(),
                'file'=>$e->getFile(),
            ],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
{
    try {
        // Validation
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'details' => 'required|string',
            'price'   => 'required|numeric',
        ]);

        // Update product
        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error'   => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile(),
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try{
             $product->delete();
         return response()->json([
                'success'=>true,
                'product'=>$product,

            ],200);
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage(),
                'line'=>$e->getLine(),
                'file'=>$e->getFile(),
            ],500);
        }
    }
}
