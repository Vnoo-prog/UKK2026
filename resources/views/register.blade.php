@extends('layouts.app')

@section('title', 'Registrasi - VoxSarana')

@section('content')
    <h1>Registrasi siswa Wicara</h1>
    
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" name="kelas" placeholder="XII RPL" required>
        </div>
        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
@endsection