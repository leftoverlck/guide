<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">Пам'ятки Закарпаття</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            @if (Route::has('login'))
                @auth
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">Вихід</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-primary mr-2" href="{{ route('login') }}">Вхід</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="btn btn-outline-secondary" href="{{ route('register') }}">Реєстрація</a>
                        </li>
                    @endif
                @endauth
            @endif
        </ul>
    </div>
</nav>
