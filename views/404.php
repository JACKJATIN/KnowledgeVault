<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Page Not Found</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .error-page {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            background-color: #f4f4f4;
        }

        .error-title {
            font-size: 80px;
            font-weight: bold;
            color: #007bff;
        }

        .error-message {
            font-size: 20px;
            color: #555;
            margin: 20px 0;
        }

        .home-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .home-btn:hover {
            background-color: #0056b3;
        }

        .error-image {
            max-width: 300px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="error-page">
        <img src="assets/404-error.svg" alt="404 Error" class="error-image">
        <div class="error-title">404</div>
        <div class="error-message">Oops! The page you are looking for does not exist.</div>
        <a href="/HOLTEC/index.php" class="home-btn">Back to Home</a>
        </div>
</body>
</html>
