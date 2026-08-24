<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Photo Portal</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap.min.css')}}">
</head>
<body>
{{$slot}}
<x-alerts/>
<script src="{{asset('assets/bootstrap.bundle.min.js')}}"></script>
</body>
</html>
