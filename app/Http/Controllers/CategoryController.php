<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $categories = Category::query();

            return DataTables::of($categories)
                ->addColumn('action', function ($category) {
                    $viewUrl = route('category.show', $category->id);
                    $editUrl = route('category.edit', $category->id);
                    $deleteUrl = route('category.destroy', $category->id);
                    return '<td class="text-center d-flex justify-content-center align-items-center">
                                <a href="' . $viewUrl . '" class="btn btn-sm btn-dark mr-1"><i class="fa fa-eye"></i></a>
                                <a href="' . $editUrl . '" class="btn btn-sm btn-primary mr-1"><i class="fa fa-pencil-alt"></i></a>
                                <form onsubmit="return confirm(\'Are you sure you want to delete this category?\');" action="' . $deleteUrl . '" method="POST">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-sm btn-danger mr-1"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug']
        ]);

        Category::create($validatedData);
        return to_route('category.index')->with('success', 'Category created successfully');
    }

    public function show(Category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug']
        ]);

        $category->update($validatedData);

        return to_route('category.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return to_route('category.index')->with('success', 'Category deleted successfully');
    }
}
