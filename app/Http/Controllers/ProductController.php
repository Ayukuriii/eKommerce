<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Enums\UserRoleEnum;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\Api\NewProductNotification;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $products = Product::query();

            return DataTables::of($products)
                ->addColumn('action', function ($product) {
                    $viewUrl = route('product.show', $product->id);
                    $editUrl = route('product.edit', $product->id);
                    $deleteUrl = route('product.destroy', $product->id);
                    return '<td class="text-center d-flex justify-content-center align-items-center">
                                <a href="' . $viewUrl . '" class="btn btn-sm btn-dark mr-1"><i class="fa fa-eye"></i></a>
                                <a href="' . $editUrl . '" class="btn btn-sm btn-primary mr-1"><i class="fa fa-pencil-alt"></i></a>
                                <form onsubmit="return confirm(\'Are you sure you want to delete this product?\');" action="' . $deleteUrl . '" method="POST">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-sm btn-danger mr-1"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>';
                })
                ->addColumn('category', function ($product) {
                    $category = $product->category->name;

                    return $category;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.product.index');
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
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
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }

        $product = Product::create($validatedData);

        $notif = $this->userNotify($product);
        Log::info($notif);

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

    public function userNotify($product)
    {
        $users = User::where('role', UserRoleEnum::USER->value)->get();

        foreach ($users as $user) {
            $user->notify(new NewProductNotification($product));
        }

        return count($users);
    }
}
