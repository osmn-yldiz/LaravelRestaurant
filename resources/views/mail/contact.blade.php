<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Mail</title>
</head>
<body>
<h3>Name: {{ $data['name'] }}</h3>
<h3>Email: {{ $data['email'] }}</h3>
<p>{{ $data['message'] }}</p>
</body>
</html>
