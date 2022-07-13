<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = Product::all();

        return response()->json([
            'status' => true,
            'message' => 'Product list',
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        if(!$request->validated()){
            return response()->json([
                'status' => false,
                'message' => 'error',
                'data' => ''
            ], 400);
        }

//        dd(explode(',',$request->validated()['tags']));
        $product = Product::create($request->validated());
        // adds the tags of the product
        if($request->has('tags')){
            $product->tags()->sync($request->validated()['tags']);

        }

        return response()->json([
            'status' => true,
            'message' => 'Created',
            'data' => $product->load('tags')->toArray()
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        return response()->json([
            'status' => true,
            'message' => 'Product',
            'data' => $product->load('tags')->toArray()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if(!$request->validated()){
            return response()->json([
                'status' => false,
                'message' => 'error',
                'data' => ''
            ], 400);
        }

        $product->update($request->validated());

        if($request->has('tags')){
            $product->tags()->sync($request->validated()['tags']);

        }

        return response()->json([
            'status' => true,
            'message' => 'Updated',
            'data' => $product->load('tags')->toArray()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product)
    {
        try {
            foreach ($product->simple() as $productSimple) {
                $productSimple->delete();
            }
            if ($product->delete()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Deleted',
                    'data' => ''
                ]);
            }
        }catch( Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error Deleting Model',
                'data' => $e->getMessage()
            ], $e->getCode());
        }

    }

    /**
     * Gets only the products that are in stock.
     *
     *@return JsonResponse
     */
    public function stock(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'Products in stock',
            'data' => Product::where('in_stock', true)->without('simple')->get()
        ]);
    }
}
