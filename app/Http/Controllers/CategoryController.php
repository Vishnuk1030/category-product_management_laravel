<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.create');
    }

    public function store_category(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|min:3",
            "slug" => "required|min:4",
            "image" => "nullable|mimes:png,jpg,jpeg,webp"
        ]);

        if ($request->has('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time() . '.' . $extension;

            $path = 'uploads/category/';

            $file->move($path, $filename);
        }

        Category::create([
            "name" => $validated["name"],
            "slug" => $validated["slug"],
            "image" => $path . $filename,
        ]);
        return redirect()->route('category.manage')->with('success', 'Category added Successfully');
    }
    public function manage_category()
    {
        $category_manages = Category::paginate(6);
        return view('category.manage', compact('category_manages'));
    }
    public function delete_category(Category $id)
    {
        $id->delete();

        return redirect()->back()->with('success', 'Category deleted Successfully');
    }
    public function edit_category($id)
    {
        $categories = Category::findOrFail(decrypt($id));
        return view('category.edit', compact('categories'));
    }

    public function update_category(Request $request, $id)
    {
        $validated = $request->validate([
            "name" => "required|min:3",
            "slug" => "required|min:4"
        ]);
        Category::findOrFail($id)->update([
            "name" => $validated["name"],
            "slug" => $validated["slug"]
        ]);

        return redirect()->route('category.manage')->with('success', 'Category Updated Successfully');
    }
}
