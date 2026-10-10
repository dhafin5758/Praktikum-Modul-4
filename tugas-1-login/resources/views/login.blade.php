<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
        body { font-family: sans-serif; background: #f3f4f6; display: flex; justify-content: center; padding-top: 4rem; }
        .card { background: #fff; padding: 2rem; border-radius: 8px; width: 320px; box-shadow: 0 1px 4px rgba(0,0,0,.15); }
        label { display: block; margin-top: 1rem; font-size: .9rem; }
        input { width: 100%; padding: .5rem; box-sizing: border-box; margin-top: .25rem; }
        button { margin-top: 1.25rem; width: 100%; padding: .6rem; background: #1a57a0; color: #fff; border: 0; border-radius: 4px; cursor: pointer; }
        .error { background: #fdecea; color: #b42318; padding: .5rem .75rem; border-radius: 4px; margin-top: 1rem; font-size: .9rem; }
        p.sub { color: #555; margin-top: 0; }
    </style>
</head>
<body>
<div class="card">
    <h1>Login</h1>
    <p class="sub">Masuk untuk membuka dashboard</p>

    @error('login')
        <div class="error">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Masuk</button>
    </form>
</div>
</body>
</html>
