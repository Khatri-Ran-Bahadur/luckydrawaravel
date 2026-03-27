<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductDraw;
use App\Http\Requests\ProductDrawStoreRequest;
use App\Http\Requests\ProductDrawUpdateRequest;
use App\Services\ImageUploader;

class ProductDrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $draws = ProductDraw::latest()->paginate(10);
        return view('admin.productdraws.index', compact('draws'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.productdraws.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductDrawStoreRequest $request)
    {
        
        // store image
       $data=$request->validated();
       if ($request->hasFile('product_image')) {
           $data['product_image'] = ImageUploader::upload('productdraws',$request->file('product_image'));
       }
        ProductDraw::create($data);
        return redirect()->route('admin.productdraws.index')->with('success', 'Product draw created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productdraw = ProductDraw::findOrFail($id);
        return view('admin.productdraws.show', compact('productdraw'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productDraw = ProductDraw::findOrFail($id);
        return view('admin.productdraws.edit', compact('productDraw'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductDrawUpdateRequest $request, string $id)
    {
        $productdraw = ProductDraw::findOrFail($id);
        // update image
        $data=$request->validated();
        if ($request->hasFile('product_image')) {
            $data['product_image'] = ImageUploader::upload('productdraws',$request->file('product_image'));
        }
        // delete old image
        if ($productdraw->product_image) {
            ImageUploader::delete($productdraw->product_image);
        }

        $productdraw->update($data);
        return redirect()->route('admin.productdraws.index')->with('success', 'Product draw updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productdraw = ProductDraw::findOrFail($id);
        // delete image
        if ($productdraw->product_image) {
            ImageUploader::delete($productdraw->product_image);
        }
        $productdraw->delete();
        return redirect()->route('admin.productdraws.index')->with('success', 'Product draw deleted successfully');
    }
}
