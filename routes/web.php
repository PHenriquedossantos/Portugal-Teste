<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CountryController;

Route::get('/', fn() => redirect()->route('people.index'));
Route::get('/countries/search', [CountryController::class, 'search'])->name('countries.search');
Route::resource('people', PersonController::class);

Route::prefix('people/{person}')->name('people.')->group(function () {
    Route::resource('contacts', ContactController::class);
});
