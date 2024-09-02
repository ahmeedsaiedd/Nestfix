<!DOCTYPE html>
<html>
<head>
    <title>Welcome to EBE</title>
</head>
<body>
    <h1>Welcome {{ $user->name }}!</h1>
    <p>Your account has been successfully created.</p>
    <p>Please click the link below to set your password:</p>
    <a href="{{ $resetUrl }}">Set Your Password</a>
    <p>Thank you for joining us!</p>
</body>
</html>
