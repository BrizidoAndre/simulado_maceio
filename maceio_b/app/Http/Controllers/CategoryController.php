<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Render the index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);
        Category::create($data);
        return redirect()->route('category.index');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);
        $category->update($data);
        return redirect()->route('category.index');
    }

    /**
     * This method will update all related posts to the Draft status
     * It will also update all related data to a replacement if specified by the user
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Category $category)
    {
        $request->validate([
            'replacement' => ['exists:categories,id']
        ]);
        $replacement = $request->input('replacement', null);
        $category->posts()->update([
            'category_id' => $replacement,
            'status' => 'Draft',
        ]);
        $category->images()->update(['category_id' => $replacement]);
        $category->delete();
        return redirect()->route('category.index');
    }
}
