<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>@yield('title', 'VoxSarana - Pengaduan Sarana Sekolah')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
            color: #333;
            line-height: 1.6;
        }

        .header {
            background-color: #0d4a8f;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #ffffff;
        }

        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .table-wrapper {
            overflow-x: auto;
            background: white;
            border-radius: 4px;
            margin-top: 15px;
        }

        h1,
        h2 {
            color: #0d4a8f;
        }

        table {
            width: 100%;
            min-width: 1100px;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px 10px;
            text-align: left;
        }

        th {
            background-color: #0d4a8f;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            max-width: 450px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
        }

        button {
            background-color: #0d4a8f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background-color: #0a3a70;
        }

        .success {
            color: #059226;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .error {
            color: #721c24;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .logout-btn {
            background: none;
            color: white;
            border: 1px solid white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: white;
            color: #0d4a8f;
        }
    </style>
</head>

<body>
    @if (auth()->check())
        <div class="header">
            <h1>Wicara</h1>
            <div>
                <strong>{{ auth()->user()->name }}
                    @if (auth()->user()->role === 'admin')
                        (Admin)
                    @else
                        (siswa - {{ auth()->user()->kelas }})
                    @endif
                </strong>
                &nbsp;&nbsp;
                <a href="#"
                    onclick="event.preventDefault();let f=document.createElement('form');f.method='POST';f.action='/logout';f.innerHTML='<input type=hidden name=_token value={{ csrf_token() }}>';document.body.appendChild(f);f.submit();"
                    class="logout-btn">Logout</a>
            </div>
        </div>
    @endif

    <div class="container">
        @yield('content')
    </div>

    <script>
        // Prevent back button after logout
        history.pushState(null, null, location.href);
        window.addEventListener('popstate', function (event) {
            history.pushState(null, null, location.href);
        });

        // Prevent page caching
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Prevent back button access
        window.onbeforeunload = function() {
            return null;
        };
    </script>
</body>

</html>
