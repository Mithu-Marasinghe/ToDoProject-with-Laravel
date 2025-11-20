<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>

<body>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h2>Log In</h2>
        <label>Email:</label>
        <input type="text" name="email"><br>
        <label>Password:</label>
        <input type="password" name="password"><br>
        <button type="submit">Log In</button>
    </form> <br>
    
    @if ($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <label>New to AppName?</label>
    <a href="{{ route('showRegister') }}">Sign up today!</a>
</body>

</html>