<!DOCTYPE html>
<html>
<head>
    <title>New User Registration Notification</title>
</head>
<body>
    <p>Dear Starlink Kenya,</p>

    <p>I hope this message finds you well.</p>

    <p>We are pleased to inform you that a new user has successfully registered on our platform. Here are the details of the new user:</p>

    <ul>
        <li>Name: {{ $user->name }}</li>
        <li>Email: {{ $user->email }}</li>
        <li>Phone: {{ $user->phone }}</li>
        <li>Registration Date: {{ $user->created_at->format('F d, Y') }}</li>
    </ul>

    

    <p>Please review their profile at your earliest convenience and reach out to them as necessary to welcome them or further engage them in our services.</p>

    <p>Thank you for overseeing this process.</p>

    <p>Best regards,<br>
    Starlink Kenya<br>
    <br>
    +254 729 299 439</p>
</body>
</html>
