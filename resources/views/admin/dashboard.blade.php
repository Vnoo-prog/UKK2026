@extends('layouts.app')

@section('title', 'Dashboard Admin Wicara')

@section('content')
    <h1>Dashboard admin</h1>
    
    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <h2>Kelola Kategori Aspirasi</h2>
    <style>
        .category-section {
            background: white;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .category-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .category-form input {
            flex: 1;
            max-width: none !important;
        }

        .category-form button {
            padding: 10px 20px;
            white-space: nowrap;
        }

        .categories-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .category-item {
            background: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-item span {
            font-weight: bold;
            color: #0d4a8f;
        }

        .category-item form {
            margin: 0;
        }

        .category-item button {
            background-color: #dc3545;
            padding: 6px 12px;
            font-size: 12px;
            border: none;
        }

        .category-item button:hover {
            background-color: #c82333;
        }
    </style>

    <div class="category-section">
        <h3 style="margin-top: 0; color: #0d4a8f;">Tambah Kategori Baru</h3>
        <form method="POST" action="{{ route('admin.kategori.store') }}" class="category-form">
            @csrf
            <input type="text" name="nama" placeholder="Nama Kategori (contoh: Kebersihan, Fasilitas)" required>
            <button type="submit">Tambah Kategori</button>
        </form>

        <h3 style="color: #0d4a8f;">Daftar Kategori</h3>
        @if($categories->count() > 0)
            <div class="categories-list">
                @foreach($categories as $cat)
                    <div class="category-item">
                        <span>{{ $cat->nama }}</span>
                        <form method="POST" action="{{ route('admin.kategori.destroy', $cat) }}" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: #666;">Belum ada kategori. Silakan tambahkan kategori baru di atas.</p>
        @endif
    </div>

    <h2>Daftar Semua Aspirasi</h2>
    <style>
        .admin-filter-row {
            display: flex;
            gap: 16px;
            flex-wrap: nowrap;
            align-items: flex-end;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 8px;
        }

        .admin-filter-row > div {
            flex-shrink: 0;
            min-width: 150px;
        }

        .admin-filter-row label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 13px;
        }

        .admin-filter-row input,
        .admin-filter-row select {
            width: 100%;
            padding: 8px;
            font-size: 13px;
        }

        .filter-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            margin-top: 0;
            white-space: nowrap;
        }

        .filter-actions button {
            padding: 8px 16px;
            font-size: 13px;
            margin: 0;
        }

        .filter-actions a {
            display: inline-block;
            text-decoration: none;
            color: #0d4a8f;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }

        .filter-actions a:hover {
            background-color: #f0f0f0;
        }

        .admin-action-form {
            display: flex;
            flex-direction: column;
            gap: 8px;
            width: 100%;
            max-width: 220px;
            box-sizing: border-box;
        }

        .admin-action-form select,
        .admin-action-form textarea {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            font-size: 13px;
            padding: 6px;
        }

        .admin-action-form textarea {
            min-height: 50px;
            resize: vertical;
        }

        .admin-action-form button {
            align-self: flex-start;
            padding: 6px 12px;
            font-size: 12px;
        }

        th, td {
            padding: 8px 6px;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        td {
            white-space: normal;
        }

        .success {
            display: inline-block;
            white-space: nowrap;
            font-size: 13px;
        }
    </style>
    <form method="GET" action="{{ route('admin.dashboard') }}">
        <div class="admin-filter-row">
            <div>
                <label>Cari Siswa/username

                </label>
                <input type="text" name="search" value="{{ request('search') }}" style="max-width:200px">
            </div>
            <div>
                <label>Kategori</label>
                <select name="kategori_id">
                    <option value="">Semua</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('kategori_id') == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Status</label>
                <select name="status">
                    <option value="">Semua</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div>
                <label>Dari Tanggal</label>
                <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}">
            </div>
            <div>
                <label>Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}">
            </div>
            <div class="filter-actions">
                <button type="submit">Filter</button>
                <a href="{{ route('admin.dashboard') }}">Reset</a>
            </div>
        </div>
    </form>

    <div class="table-wrapper">
    <table>
        <tr>
            <th>Tanggal</th>
            <th>Siswa</th>
            <th>Kelas</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Keluhan</th>
            <th>Gambar</th>
            <th>Status</th>
            <th>Respon</th>
            <th>Aksi</th>
        </tr>
        @foreach ($aspirasis as $aspirasi)
        <tr>
            <td>{{ $aspirasi->created_at->format('d-m-Y H:i') }}</td>
            <td>{{ $aspirasi->user->name }}<br>({{ $aspirasi->user->username }})</td>
            <td>{{ $aspirasi->user->kelas ?? '-' }}</td>
            <td>{{ $aspirasi->kategori->nama }}</td>
            <td>{{ $aspirasi->lokasi }}</td>
            <td>{{ $aspirasi->keluhan }}</td>
            <td>
                @if($aspirasi->gambar)
                    <a href="{{ asset('storage/' . $aspirasi->gambar) }}" target="_blank">
                        <img src="{{ asset('storage/' . $aspirasi->gambar) }}" alt="Gambar Aspirasi" style="max-width: 100px; max-height: 100px; cursor: pointer;">
                    </a>
                @else
                    -
                @endif
            </td>
            <td>{{ $aspirasi->status }}</td>
            <td>{{ $aspirasi->feedback ?? '-' }}</td>
            <td>
                @if($aspirasi->status !== 'selesai')
                    <form method="POST" action="{{ route('admin.aspirasi.update', $aspirasi) }}" class="admin-action-form">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <select name="status">
                            <option value="Menunggu" {{ $aspirasi->status === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Proses" {{ $aspirasi->status === 'Proses' ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai" {{ $aspirasi->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <textarea name="feedback" rows="2" placeholder="respon...">{{ $aspirasi->feedback }}</textarea>
                        <button type="submit">Update</button>
                    </form>
                @else
                    <span class="success">Sudah selesai</span>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
    </div>
@endsection