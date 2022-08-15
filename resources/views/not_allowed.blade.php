<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Not Allowed</title>
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif
        }

        body div a {
            padding: 10px 15px;
            display: inline-block;
            background: #e02727;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            font-size: 18px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div>
        <img width="150" src="{{ asset('adminassets/img/not.png') }}" alt="">
        <h1>You are not allowed to visit this page</h1>
        <a href="{{ url('/') }}">Homepage</a>
    </div>
</body>
</html>
