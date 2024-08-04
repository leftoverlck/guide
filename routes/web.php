<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttractionController;

Auth::routes();
Route::get('/home', [AttractionController::class, 'index'])->name('home');

Route::get('/', [AttractionController::class, 'index'])->name('attractions.index');
Route::get('/search', [AttractionController::class, 'search'])->name('attractions.search');
Route::get('/filter', [AttractionController::class, 'filter'])->name('attractions.filter');
Route::get('/attractions/{id}', [AttractionController::class, 'show'])->name('attractions.show');
Route::get('/attractions/type', [AttractionController::class, 'filterByType'])->name('attractions.filterByType');
Route::post('/attraction/{id}/review', [AttractionController::class, 'addReview'])->middleware('auth')->name('attractions.addReview');
Route::delete('/reviews/{id}', [AttractionController::class, 'deleteReview'])->middleware('auth')->name('reviews.delete');
Route::get('/region/{region}', [AttractionController::class, 'region']);

