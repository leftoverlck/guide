@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">Пам'ятки Закарпаття</h1>

        <div class="row mb-4">
            <div class="col-12">
                <form class="form-inline" method="GET" action="{{ route('home') }}">
                    <div class="input-group mr-3 mb-3">
                        <input class="form-control" type="search" placeholder="Пошук" aria-label="Search" name="query" value="{{ request('query') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit">Пошук</button>
                        </div>
                    </div>

                    <div class="input-group mr-3 mb-3">
                        <select class="form-control" name="region">
                            <option value="">Виберіть регіон</option>
                            <option value="Міжгірський район" {{ request('region') == 'Міжгірський район' ? 'selected' : '' }}>Міжгірський район</option>
                            <option value="Хустський район" {{ request('region') == 'Хустський район' ? 'selected' : '' }}>Хустський район</option>
                            <option value="Тячівський район" {{ request('region') == 'Тячівський район' ? 'selected' : '' }}>Тячівський район</option>
                            <option value="Воловецький район" {{ request('region') == 'Воловецький район' ? 'selected' : '' }}>Воловецький район</option>
                            <option value="Виноградівський район" {{ request('region') == 'Виноградівський район' ? 'selected' : '' }}>Виноградівський район</option>
                            <option value="Свалявський район" {{ request('region') == 'Свалявський район' ? 'selected' : '' }}>Свалявський район</option>
                            <option value="Мукачівський район" {{ request('region') == 'Мукачівський район' ? 'selected' : '' }}>Мукачівський район</option>
                            <option value="Ужгородський район" {{ request('region') == 'Ужгородський район' ? 'selected' : '' }}>Ужгородський район</option>
                            <option value="Перечинський район" {{ request('region') == 'Перечинський район' ? 'selected' : '' }}>Перечинський район</option>
                            <option value="Рахівський район" {{ request('region') == 'Рахівський район' ? 'selected' : '' }}>Рахівський район</option>
                            <option value="Берегівський район" {{ request('region') == 'Берегівський район' ? 'selected' : '' }}>Берегівський район</option>
                        </select>
                    </div>

                    <div class="input-group mr-3 mb-3">

                        <select class="form-control" name="type" onchange="this.form.submit()">
                            <option value="" {{ request('type') == '' ? 'selected' : 'disabled' }}>Виберіть тип</option>
                            <option value="Замки" {{ request('type') == 'Замки' ? 'selected' : '' }}>Замки</option>
                            <option value="Музеї" {{ request('type') == 'Музеї' ? 'selected' : '' }}>Музеї</option>
                            <option value="Історичні місця" {{ request('type') == 'Історичні місця' ? 'selected' : '' }}>Історичні місця</option>
                            <option value="Архітектура" {{ request('type') == 'Архітектура' ? 'selected' : '' }}>Архітектура</option>
                            <option value="Природні об'єкти" {{ request('type') == 'Природні об\'єкти' ? 'selected' : '' }}>Природні об'єкти</option>
                        </select>
                    </div>

                    <button class="btn btn-outline-success mb-3" type="submit">Фільтр</button>

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary ml-3 mb-3">Скинути фільтри</a>
                </form>
            </div>
        </div>

        <!-- Список пам'яток -->
        <!-- Список пам'яток -->
        <ul class="list-group mt-3">
            @forelse($attractions as $attraction)
                <li class="list-group-item d-flex align-items-start mb-3 card-box">
                    @if ($attraction->image)
                        <img src="{{ asset($attraction->image) }}" alt="{{ $attraction->name }}" style="width: 200px; height: auto;" class="mr-3">
                    @endif
                    <div>
                        <a href="{{ route('attractions.show', $attraction->id) }}">
                            <strong>{{ $attraction->name }}</strong>
                        </a>
                        <p>{{ $attraction->description }}</p>
                        <a href="{{ route('attractions.show', $attraction->id) }}" class="details">
                            {{ Str::limit($attraction->details, 200, '...') }}
                        </a>
                    </div>
                </li>
            @empty
                <li class="list-group-item">Немає пам'яток для відображення</li>
            @endforelse
        </ul>

        <div class="mt-4 d-flex justify-content-center">
            {{ $attractions->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .details {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 3.6em;
            line-height: 1.8em;
            color: #007bff;
            text-decoration: none;
        }
        .details:hover {
            text-decoration: underline;
        }
        .card-box {
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
        }

    </style>
@endsection
