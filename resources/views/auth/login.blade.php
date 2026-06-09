<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<div class="left">
    <img src="JVS.png" alt="Logo JVS" style="width: 500px; height: auto; vertical-align: middle; margin-right: 10px;">
</div>

<div class="right">

    <form action="{{ url('/login') }}" method="POST" class="login-box">
        @csrf <h4>Masuk</h4>

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px; font-size: 14px;">
                {{ $errors->first() }}
            </div>
        @endif

        <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
        <input type="password" name="password" placeholder="Password" required>

      <button type="submit" class="btn-login" style="padding: 6px 20px; font-size: 14px; width: auto;">Login</button>
    </form>

</div>

</body>
</html>