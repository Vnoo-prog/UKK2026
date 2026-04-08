@extends('layouts.app')

@section('title', 'Login Wicara')

@section('content')
    <h1>Login Wicara</h1>
    
    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai Siswa</a></p>
@endsection