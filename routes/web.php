<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
});

 
Volt::route('/counter', 'counter');

//livewire post component
Route::get('/post', [\App\Livewire\PostComponent::class, '__invoke'])->name('post');