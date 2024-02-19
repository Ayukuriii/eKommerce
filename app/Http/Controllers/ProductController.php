<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,gif,svg', 'max:2048'],
            'category_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
        ]);

        $validatedData['image'] = $request->file('image')->store('images', 'public');

        Product::create($validatedData);

        return to_route('product.index')->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,svg', 'max:2048'],
            'category_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
        ]);

        if ($request->hasFile('image')) {
            // delete old image if exist on request
            Storage::delete('public/' . $product->image);

            // store new image
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }

        $product->update($validatedData);

        return to_route('product.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        Storage::delete('public/' . $product->image);

        $product->delete();

        return back()->with('success', 'Product deleted successfully');
    }
}
