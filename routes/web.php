<?php

use App\Repositories\TodoRepository;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
