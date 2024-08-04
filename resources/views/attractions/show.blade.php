@extends('layouts.app')

@section('title', $attraction->name)

@section('content')
    <div class="container">
        <div class="details-container">
            <h1 class="my-4">{{ $attraction->name }}</h1>
            <p>{{ $attraction->description }}</p>
            <p>{{ $attraction->details }}</p>
            <div id="map" class="map-container" style="height: 400px; width: 100%;"></div>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">Назад до списку пам'яток</a>

            <h2>Відгуки</h2>
            <div class="reviews-container">
                @if ($attraction->reviews->isEmpty())
                    <p>Ще немає відгуків до цієї пам'ятки.</p>
                @else
                    <!-- У вашому шаблоні відгуків -->
                    @foreach($attraction->reviews as $review)
                        <div class="review-box">
                            <strong>{{ $review->user->name }}</strong> оцінив(ла) на {{ $review->rating }} зірок
                            <p>{{ $review->comment }}</p>

                            @if(Auth::check() && Auth::id() == $review->user_id)
                                <form action="{{ route('reviews.delete', $review->id) }}" method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цей відгук?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background-color: #6c757d; color: white;">Видалити відгук</button>
                                </form>
                            @endif
                        </div>
                    @endforeach

                @endif

                @auth
                    <h3>Додати відгук</h3>
                        <form method="POST" action="{{ route('attractions.addReview', $attraction->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="rating">Рейтинг</label>
                                <select name="rating" id="rating" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="comment">Коментар</label>
                                <textarea name="comment" id="comment" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Відправити</button>
                        </form>

                    @else
                    <p>Будь ласка, <a href="{{ route('login') }}">увійдіть</a>, щоб залишити відгук.</p>
                @endauth
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .details-container {
            border: 1px solid #ddd !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            padding: 20px !important;
            margin-bottom: 20px !important;
            background-color: #fff !important;
        }
        .map-container {
            border: 1px solid #ddd !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
        }
        .reviews-container {
            border: 1px solid #ddd !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            padding: 20px !important;
            margin-top: 20px !important;
            background-color: #fff !important;
        }
        .review-item {
            margin-bottom: 20px !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([{{ $attraction->latitude }}, {{ $attraction->longitude }}], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([{{ $attraction->latitude }}, {{ $attraction->longitude }}]).addTo(map)
                .bindPopup('{{ $attraction->name }}')
                .openPopup();
        });
    </script>
@endpush
