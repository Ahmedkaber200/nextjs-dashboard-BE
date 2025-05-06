<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::all();
        return $this->sendResponse($data, 'All Product Data.');

        // return response()->json([
        //     'status' => true,
        //     'message' => 'All Product Data.',
        //     'data' => $data,
        // ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateProduct = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
            ]
        );

        if ($validateProduct->fails()) {
            // return response()->json([
            //     'status' => false,
            //     'message' => 'Validation Errorssss',
            //     'error' => $validateProduct->errors()->all()
            // ], 401);

            return $this->sendError('Validation Error', $validateProduct->errors()->all());
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return $this->sendResponse($product, 'Product Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Product::select(
            'id',
            'name',
            'description',
            'price'
        )->where(['id' => $id])->first();

        return $this->sendResponse($data, 'My Single Product Fetch.');
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateProduct = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
            ]
        );

        if ($validateProduct->fails()) {
            return $this->sendError('Validation Error', $validateProduct->errors()->all());
        }

        $product = Product::where(['id' => $id])->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return $this->sendResponse($product, 'Product Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::where('id' ,$id)->delete();
        return $this->sendResponse($product, 'My Product has been removed.');
    }
}
