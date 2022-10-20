<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function index(Product $product)
    {
        return view('backend.barcode.create');
    }

    public function fetch_single_product(Request $request)
    {
        $product = Product::where('id', $request->id)
            ->where('status', 1)
            ->get(['name', 'bar_code', 'product_code']);

        return response()->json($product[0]);
    }

    public function show()
    {
        return view('backend.barcode.print');
    }

    public function print(Request $request)
    {
        // dd($request->all());
        $qty = $request->qty;
        $product = Product::where('id', $request->id)
            ->where('status', 1)
            ->get(['name', 'bar_code', 'product_code'])[0];

        return view('backend.barcode.print', compact('product', 'qty'));
        return response()->json($product[0]);
    }
}
