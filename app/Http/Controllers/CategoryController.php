<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Show the form to create a new category (if needed)
    public function create()
    {
        // Fetch all categories from the database
        $categories = Category::all();
        
        // Pass the categories to the view
        return view('admin.add-category', compact('categories'));
    }

    // Store a newly created category in the database
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new category
        Category::create([
            'name' => $request->input('name'),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Category added successfully!');
    }
    public function showAddCategoryForm()
    {
        $categories = Category::all(); // Fetch all categories
        return view('admin.add-category', compact('categories')); // Pass categories to the view
    }
    public function destroy($id)
{
    $category = Category::findOrFail($id);
    $category->delete();

    return redirect()->back()->with('status', 'Category deleted successfully!');
}
}
