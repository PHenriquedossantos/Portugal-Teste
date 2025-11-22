<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\ContactController;

Route::get('/', fn() => redirect()->route('people.index'));

Route::resource('people', PersonController::class);

Route::prefix('people/{person}')->name('people.')->group(function () {
    Route::resource('contacts', ContactController::class);
});
