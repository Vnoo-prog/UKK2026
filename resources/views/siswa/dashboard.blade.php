@extends('layouts.app')

@section('title', 'Dashboard siswa Wicara')

@section('content')
    <h1>Dashboard siswa</h1>
    
    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <h2>Form Aspirasi Baru</h2>
    <form method="POST" action="{{ route('siswa.aspirasi.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Kategori Aspirasi</label>
            <select name="kategori_id" required>
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" name="lokasi" placeholder="Ruang 301 / Lapangan" required>
        </div>
        <div class="form-group">
            <label>Keluhan / Aspirasi</label>
            <textarea name="keluhan" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label>Gambar (Opsional)</label>
            <input type="file" name="gambar" accept="image/*" style="max-width: 100%;">
            <small>Format: JPG, PNG, GIF (Maksimal 2MB)</small>
        </div>
        <button type="submit">Kirim aspirasi</button>
    </form>

    <h2>Histori Aspirasi Saya</h2>
    <div class="table-wrapper">
    <table>
        <tr>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Keluhan</th>
            <th>Gambar</th>
            <th>Status</th>
            <th>Respon</th>
        </tr>
        @foreach ($aspirasis as $aspirasi)
        <tr>
            <td>{{ $aspirasi->created_at->format('d-m-Y H:i') }}</td>
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
        </tr>
        @endforeach
    </table>
    </div>
@endsection