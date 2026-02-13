<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Page Not Found</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
    }

    .container {
      width: 300px;
      height: 300px;
    }

    .container img {
      width: 100%;
      height: 100%;
     
      object-fit: contain;
    }

    .message {
      color: rgb(237, 0, 0);
      font-size: 24px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="{{ asset('uploads/not-found.svg') }}" alt="404">
    <div class="message">
      {{ ($exception->getMessage()!='' && $exception->getMessage()!=null) ? $exception->getMessage() : 'Oops! Page Not Found' }}
    </div>
  </div>
</body>
</html>
