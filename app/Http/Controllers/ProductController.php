<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::active()->ordered()->get();

        $products = Product::published()
            ->ordered()
            ->with('category')
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
            })
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_published, 404);

        $product->load('images', 'category');

        $related = Product::published()
            ->where('id', '!=', $product->id)
            ->when($product->product_category_id, fn ($q) => $q->where('product_category_id', $product->product_category_id))
            ->ordered()
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
