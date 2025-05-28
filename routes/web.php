<?php

use App\Repositories\TodoRepository;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $repo = app()->make(TodoRepository::class);
    $data = $repo->add(['name' => 'todo1']);
    dd($data);
    return view('welcome');
});
