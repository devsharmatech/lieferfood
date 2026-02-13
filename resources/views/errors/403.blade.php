
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Access Denied</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .access-denied {
      text-align: center;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 80%;
      max-width: 600px;
    }
    .access-denied h5 {
      color: #e74c3c;
      font-size: 1.5rem;
    }
    .access-denied p {
      color: #555555;
      font-size: 1.25rem;
    }
    .access-denied a {
      text-decoration: none;
      font-weight: bold;
      color: #3498db;
    }
    .access-denied a:hover {
      text-decoration: underline;
    }
    .access-denied img {
      margin-top: 20px;
      width: 100px; /* Adjust as needed */
      height: auto;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="access-denied">
      <h5>{{$exception->getMessage() ?: 'Forbidden'}}</h5>
      <img src="{{asset('uploads/unauthorized.png')}}" alt="Access Denied Icon">
      <p>You do not have permission to access this page. Please contact your service partner for assistance.</p>
      <p><a href="mailto:support@example.com">Contact Support</a></p>
    </div>
  </div>

</body>
</html>
