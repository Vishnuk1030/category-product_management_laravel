<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }
    public function store_product(Request $request)
    {
        $validated = $request->validate([
            "name" => 'required|min:3',
            "category_id" => "required",
            "slug" => "required|min:4",
            "description" => "required|min:10",
            "image" => "nullable|mimes:png,jpg,jpeg,webp"
        ]);

        if ($request->has('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time() . '.' . $extension;

            $path = 'uploads/product/';

            $file->move($path, $filename);
        }

        Product::create([
            "name" => $validated["name"],
            "category_id" => $validated["category_id"],
            "slug" => $validated["slug"],
            "description" => $validated["description"],
            "image" => $path . $filename,
        ]);

        return redirect()->route('product.manage')->with('success', 'Product added Successfully');
    }

    public function manage_product()
    {
        $products = Product::all();
        return view('product.manage', compact('products'));
    }

    public function delete_product(Product $id)
    {
        $id->delete();

        return redirect()->route('product.manage')->with('success', 'Product deleted Successfully');
    }
}
