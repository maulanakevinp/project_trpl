<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .rotate90 {
            position: relative;
            transform: rotate(90deg);
        }
    </style>
</head>
<body>
    <div class="text-center">
        <img src="{{ url($file) }}" alt="{{ $file_name }}" class="rotate90">
    </div>
</body>
</html>