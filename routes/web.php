<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Events\Register;
use App\Livewire\Events\Create;
use App\Livewire\Events\Index;

Route::get('/', function () {
    return redirect()->route('events.index');
});

// Группа для событий
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', Index::class)->name('index');           // список событий
    Route::get('/create', Create::class)->name('create');
    Route::get('/{event}/register', Register::class)        // регистрация
        ->name('register')
        ->whereNumber('event'); // защита: {event} только число
});
