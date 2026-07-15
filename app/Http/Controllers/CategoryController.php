<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate();
        return view('category.index', compact('categories'));
    }


    public function store(Request $request)
    {
        try {
            //code...
            // $this->authorize('create', Auth::user());
            $validated = $request->validate([
                'name' => 'required|unique:categories,name',
                'is_active' => 'bool',
            ]);
            $validated['slug'] = Str::slug($validated['name']);
            Category::create($validated);
            return redirect()->route('categories.index')->with('success', "New category created");
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('categories.index')->with('error', 'Failed to update<br/>'.$th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'is_active' => 'bool',
            ]);
            // $this->authorize('update', $category);
            $category->update($validated);
            return redirect()->route('categories.index')->with('success', "Category updated");
        } catch (\Throwable $th) {
            return redirect()->route('categories.index')->with('error', "Failed to update<br/>" . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            // $this->authorize('delete', $category);
            $category->delete();
            return redirect()->route('categories.index')->with('success', "Category deleted");
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('categories.index')->with('error', "Failed to delete<br/>".$th->getMessage());
        }
    }
}
