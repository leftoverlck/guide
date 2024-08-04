<!-- resources/views/attractions/found.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">Місце знайдено</h1>
        <div id="map" style="height: 500px;"></div>
        <div id="placeInfo" class="mt-4"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const lat = urlParams.get('lat');
            const lng = urlParams.get('lng');

            fetch(`/find-place?lat=${lat}&lng=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    const map = L.map('map').setView([data.latitude, data.longitude], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                    L.marker([data.latitude, data.longitude]).addTo(map)
                        .bindPopup(`<b>${data.name}</b><br>${data.description}`)
                        .openPopup();
                    document.getElementById('placeInfo').innerHTML = `<h3>${data.name}</h3><p>${data.description}</p>`;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Сталася помилка при пошуку найближчої пам\'ятки.');
                });
        });
    </script>
@endsection
