<!-- resources/views/admin/login.blade.php -->

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürünler</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('panel/panel.css') }}">
</head>
<body>


<form method="POST" action="{{ route('admin.login.submit') }}">


    @csrf
    <div class="login">
        <div class="login-middle">
            <h2 class="login-text">Admin Login</h2>
            <div class="form">


                <input class="login-style" type="email" name="email" id="email" required>




                <input class="login-style" type="password" name="password" id="password" required>


            <button class="submit" type="submit">Login</button>
            </div>
        </div>

    </div>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
</form>
</body>
</html>
