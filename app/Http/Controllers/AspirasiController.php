<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    public function siswaDashboard()
    {
        $aspirasis = Auth::user()->aspirasis()->latest()->get();
        $categories = Category::all();
        return view('siswa.dashboard', compact('aspirasis', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'lokasi' => 'required|string|max:50',
            'keluhan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'kategori_id' => $request->kategori_id,
            'lokasi' => $request->lokasi,
            'keluhan' => $request->keluhan,
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('aspirasis', $filename, 'public');
            $data['gambar'] = 'aspirasis/' . $filename;
        }

        Aspirasi::create($data);

        return redirect()->route('siswa.dashboard')->with('success', 'Aspirasi berhasil dikirim');
    }

    public function adminDashboard(Request $request)
    {
        $query = Aspirasi::with(['user', 'kategori']);
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        $aspirasis = $query->latest()->get();
        $categories = Category::all();

        return view('admin.dashboard', compact('aspirasis', 'categories'));
    }

    public function update(Request $request, Aspirasi $aspirasi)
    {
        if ($aspirasi->status === 'Selesai') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Aspirasi yang sudah selesai tidak dapat diubah lagi');
        }

        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'feedback' => 'nullable|string',
        ]);

        $aspirasi->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Status dan umpan balik berhasil diperbarui');
    }
}