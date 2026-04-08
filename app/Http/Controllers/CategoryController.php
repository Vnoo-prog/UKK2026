<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:categories,nama',
        ]);

        Category::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function destroy(Category $category)
    {
        if ($category->aspirasis()->count() > 0) {
            return redirect()->route('admin.dashboard')->with('error', 'Kategori tidak bisa dihapus karena masih ada aspirasi yang menggunakan kategori ini');
        }

        $category->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Kategori berhasil dihapus');
    }
}
