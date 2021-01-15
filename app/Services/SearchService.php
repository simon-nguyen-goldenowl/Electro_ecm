<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchService
{
    public function autoComplete(Request $request)
    {
        if ($request->has('search')) {
            $search = $request ->input('search');
            $product = Product::class->name();
            return $product;
        }
    }
}
