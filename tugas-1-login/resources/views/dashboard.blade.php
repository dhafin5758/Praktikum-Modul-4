<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; margin: 0; }
        header { display: flex; justify-content: space-between; align-items: center; background: #1a57a0; color: #fff; padding: .75rem 1.5rem; }
        header h1 { margin: 0; font-size: 1.2rem; }
        header button { background: #fff; color: #1a57a0; border: 0; padding: .4rem .9rem; border-radius: 4px; cursor: pointer; }
        main { padding: 1.5rem; }
    </style>
</head>
<body>
<header>
    <h1>Dashboard</h1>
    {{-- Logout memakai POST + @csrf, bukan link biasa --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</header>
<main>
    <h2>Selamat datang, {{ $user->nama_lengkap }}!</h2>
    <p>Halaman ini hanya bisa dibuka setelah login.</p>
    <p>Username: {{ $user->username }}</p>
</main>
</body>
</html>
