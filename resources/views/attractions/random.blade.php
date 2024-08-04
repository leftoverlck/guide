@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">Найближча Пам'ятка</h1>
        <button id="findPlaceBtn" class="btn btn-primary mb-4">Знайти місце</button>
        <div id="map" style="height: 500px;"></div>
        <div id="placeInfo" class="mt-4"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('map').setView([48.3794, 31.1656], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            document.getElementById('findPlaceBtn').addEventListener('click', function (event) {
                event.preventDefault();
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        fetch(`/find-place?lat=${position.coords.latitude}&lng=${position.coords.longitude}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    alert(data.error);
                                    return;
                                }


                                map.setView([data.latitude, data.longitude], 13);
                                L.marker([data.latitude, data.longitude]).addTo(map)
                                    .bindPopup(`<b>${data.name}</b><br>${data.description}`)
                                    .openPopup();


                                document.getElementById('placeInfo').innerHTML = `<h3>${data.name}</h3><p>${data.description}</p>`;
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Сталася помилка при пошуку найближчої пам\'ятки.');
                            });
                    }, function (error) {
                        alert('Не вдалося отримати місцезнаходження.');
                    });
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            });
        });
    </script>
@endsection
