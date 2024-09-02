<!DOCTYPE html>
<html>
<head>
    <title>Password Required</title>
</head>
<body>
    <form method="POST" action="{{ url()->current() }}">
        @csrf
        <label for="password">Enter Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Submit</button>
    </form>
    @if ($errors->any())
        <p style="color: red;">{{ $errors->first('password') }}</p>
    @endif
</body>
</html>
