<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashDraw;
use App\Http\Requests\CashDrawStoreUpdateRequest;

class CashDrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $draws = CashDraw::latest()->paginate(10);
        return view('admin.cashdraws.index', compact('draws'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cashdraws.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CashDrawStoreUpdateRequest $request)
    {
        CashDraw::create($request->validated());
        return redirect()->route('admin.cashdraws.index')->with('success', 'Cash draw created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cashdraw = CashDraw::findOrFail($id);
        return view('admin.cashdraws.show', compact('draw'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cashdraw = CashDraw::findOrFail($id);
        return view('admin.cashdraws.edit', compact('cashdraw'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CashDrawStoreUpdateRequest $request, string $id)
    {
        $draw = CashDraw::findOrFail($id);
        $draw->update($request->validated());
        return redirect()->route('admin.cashdraws.index')->with('success', 'Cash draw updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $draw = CashDraw::findOrFail($id);
        $draw->delete();
        return redirect()->route('admin.cashdraws.index')->with('success', 'Cash draw deleted successfully');
    }
}
