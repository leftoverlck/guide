<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Пам'ятки {{ $region }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">Пам'ятки Закарпаття</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Головна</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <h1 class="my-4">Пам'ятки {{ $region }}</h1>
    <ul class="list-group">
        @foreach ($filteredAttractions as $attraction)
            <li class="list-group-item">
                <a href="{{ url('/attraction/' . $attraction['id']) }}">{{ $attraction['name'] }}</a>
                <p>{{ $attraction['description'] }}</p>
            </li>
        @endforeach
    </ul>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Назад до списку пам'яток</a>
</div>
</body>
</html>
