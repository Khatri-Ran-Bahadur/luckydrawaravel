<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductDraw;

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
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $request->merge(['product_image' => $image_name]);
        }

        ProductDraw::create($request->validated());
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
        $productdraw = ProductDraw::findOrFail($id);
        return view('admin.productdraws.edit', compact('productdraw'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductDrawUpdateRequest $request, string $id)
    {
        $productdraw = ProductDraw::findOrFail($id);
        // update image
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $request->merge(['product_image' => $image_name]);
            // delete old image
            if ($productdraw->product_image) {
                unlink(public_path('images/' . $productdraw->product_image));
            }
        }
        $productdraw->update($request->validated());
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
            unlink(public_path('images/' . $productdraw->product_image));
        }
        $productdraw->delete();
        return redirect()->route('admin.productdraws.index')->with('success', 'Product draw deleted successfully');
    }
}
