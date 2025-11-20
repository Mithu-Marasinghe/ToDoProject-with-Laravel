<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>

<body>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <h2>Sign Up!</h2>
        <label>Username:</label>
        <input type="text" name="name" value="{{ old('name') }}"><br>
        <label>Email:</label>
        <input type="text" name="email" value="{{ old('email') }}"><br>
        <label>Password:</label>
        <input type="password" name="password"><br>
        <label>Confirm Password:</label>
        <input type="password" name="password_confirmation"><br>
        
        <button type="submit">Sign Up</button>
    </form><br>
    @if ($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <label>Already have an account?</label>
    <a href="{{ route('showLogin') }}">Log in!</a>
</body>

</html>