<?php

use App\Services\TodoService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    $this->todeService = app()->make(TodoService::class);
});

test('TodoService singleton', function () {
    $todeService1 = app()->make(TodoService::class);
    $todeService2 = app()->make(TodoService::class);

    expect($todeService1)->toBe($todeService2);
});

test('TodoService add todo success', function () {
    $data = [
        'name' => 'todo service1'
    ];

    $respon = $this->todeService->add($data);

    expect($respon->name)->toBe('todo service1');
});

test('TodoService add todo fail', function () {
    $data = [
        'salah' => 'todo service1'
    ];

    $respon = $this->todeService->add($data);

    expect($respon)->toBe(null);
});


test('get todo by id success', function () {

    $dataTest = [
        'name' => 'todo service1'
    ];

    $responAdd = $this->todeService->add($dataTest);

    $responGetOne = $this->todeService->showDetail($responAdd->id);

    expect($responAdd->toArray())->toEqual($responGetOne->toArray());
});

test('get todo by id fail', function () {

    $dataTest = [
        'name' => 'todo service1'
    ];

    $resultAdd = $this->todeService->add($dataTest);

    $resultShowDetail = $this->todeService->showDetail($resultAdd->id + 2);

    expect($resultShowDetail)->toBe(null);
    expect($resultShowDetail)->not->toEqual($resultAdd->toArray());
});

test('show all todo success', function () {

    $todoList = $this->todeService->showAll();

    expect($todoList)->toBeInstanceOf(Collection::class);
    expect($todoList)->not->toBe(null);
});

test('show all todo is empty', function () {

    DB::table('todos')->delete();
    $todoList = $this->todeService->showAll();

    expect($todoList)->not->toBeInstanceOf(Collection::class);
    expect($todoList)->toBe(null);
});

test('edit todo success', function () {
    $dataTest = ['name' => 'todo1'];

    $resultAdd = $this->todeService->add($dataTest);

    $dataTest['name'] = 'todo2';
    $resultEdit = $this->todeService->edit($resultAdd->id, $dataTest);


    expect($resultEdit)->not->toBe(null);
    expect($resultEdit->name)->toBe($dataTest['name']);
});

test('edit todo fail', function () {
    $dataTest = ['name' => 'todo1'];

    $resultAdd = $this->todeService->add($dataTest);

    $dataTest['name'] = 'todo2';
    $resultEdit1 = $this->todeService->edit($resultAdd->id + 2, $dataTest);

    $dataTest['salah'] = 'todo2';
    $resultEdit2 = $this->todeService->edit($resultAdd->id + 2, $dataTest);


    expect($resultEdit1)->toBe(null);
    expect($resultEdit2)->toBe(null);
});

test('delete todo success', function () {
    $dataTest = ['name' => 'todo1'];

    $resultAdd = $this->todeService->add($dataTest);

    $resultDelete = $this->todeService->delete($resultAdd->id);

    expect($resultDelete)->toBe(true);
});

test('delete todo fail', function () {
    $dataTest = ['name' => 'todo1'];

    $resultAdd = $this->todeService->add($dataTest);

    $resultDelete = $this->todeService->delete($resultAdd->id + 2);

    expect($resultDelete)->toBe(false);
});
