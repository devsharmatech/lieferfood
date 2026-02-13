<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #f5130b;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            padding: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }
        .btn {
            background-color: #f5130b;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome to Our Platform!</h1>
        </div>
        <div class="content">
            <p>Dear {{$user->name}},</p>
            <p>We are thrilled to welcome you to our platform. Your account has been successfully created. Below are your login details:</p>
            <p><strong>Email:</strong> {{$user->email}}</p>
            <p><strong>Password:</strong> {{$user->fpassword}}</p>
            <p>Please keep this information safe and do not share it with anyone.</p>
            <p>We are excited to have you on board and look forward to a successful partnership.</p>
            <a href="{{route('admin.login')}}" class="btn">Login to Your Account</a>
        </div>
        <div class="footer">
            <p>&copy; {{date('Y')}} {{env('APP_NAME','Dhillon Restaurant')}} . All rights reserved.</p>
        </div>
    </div>
</body>
</html>
