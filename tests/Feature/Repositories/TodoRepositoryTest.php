<?php

use App\Repositories\TodoRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


beforeEach(function () {
    $this->todoRepository = app()->make(TodoRepository::class);
});

test('TodoRepository singleton', function () {

    $todoRepository1 = app()->make(TodoRepository::class);
    $todoRepository2 = app()->make(TodoRepository::class);

    expect($todoRepository1)->toBe($todoRepository2);
});

test('add data todo success', function () {

    $data = [
        'name' => 'todo1'
    ];

    $respon = $this->todoRepository->add($data);

    expect($respon->name)->toBe('todo1');
});

test('add data todo fail', function () {

    $data = [
        'salah' => 'todo1'
    ];

    $respon = $this->todoRepository->add($data);

    expect($respon)->toBe(null);
});

test('get one todo success', function () {

    $dataTest = [
        'name' => 'todo1'
    ];

    $responAdd = $this->todoRepository->add($dataTest);

    $responGetOne = $this->todoRepository->getOne($responAdd->id);

    expect($responAdd->toArray())->toEqual($responGetOne->toArray());
});

test('get one todo fail', function () {

    $dataTest = [
        'name' => 'todo1'
    ];

    $resultAdd = $this->todoRepository->add($dataTest);

    $resultGetOne = $this->todoRepository->getOne($resultAdd->id + 2);

    expect($resultGetOne)->toBe(null);
    expect($resultGetOne)->not->toEqual($resultAdd->toArray());
});

test('get all todo success', function () {

    DB::table('todos');
    $todoList = $this->todoRepository->getAll();

    expect($todoList)->toBeInstanceOf(Collection::class);
    expect($todoList)->not->toBe(null);
});

test('get all todo is empty', function () {

    DB::table('todos')->delete();
    $todoList = $this->todoRepository->getAll();

    expect($todoList)->not->toBeInstanceOf(Collection::class);
    expect($todoList)->toBe(null);
});

test('edit todo success', function () {
    $dataTest = ['name' => 'todo1'];

    $resultAdd = $this->todoRepository->add($dataTest);

    $dataTest['name'] = 'todo2';
    $resultEdit = $this->todoRepository->edit($resultAdd->id, $dataTest);


    expect($resultEdit)->not->toBe(null);
    expect($resultEdit->name)->toBe($dataTest['name']);
});

test('edit todo fail', function () {
    $dataTest = ['name' => 'todo1'];

    $resultAdd = $this->todoRepository->add($dataTest);

    $dataTest['name'] = 'todo2';
    $resultEdit1 = $this->todoRepository->edit($resultAdd->id + 2, $dataTest);

    $dataTest['salah'] = 'todo2';
    $resultEdit2 = $this->todoRepository->edit($resultAdd->id + 2, $dataTest);


    expect($resultEdit1)->toBe(null);
    expect($resultEdit2)->toBe(null);
});

test('delete todo success', function () {
    $dataTest = ['name' => 'todo1'];

    $resultAdd = $this->todoRepository->add($dataTest);

    $resultDelete = $this->todoRepository->delete($resultAdd->id);

    expect($resultDelete)->toBe(true);
});

test('delete todo fail', function () {
    $dataTest = ['name' => 'todo1'];

    $resultAdd = $this->todoRepository->add($dataTest);

    $resultDelete = $this->todoRepository->delete($resultAdd->id + 2);

    expect($resultDelete)->toBe(false);
});
