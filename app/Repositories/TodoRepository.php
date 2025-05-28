<?php

namespace App\Repositories;

use App\Models\Todo;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class TodoRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    function getAll(): Collection|null
    {
        $todoList = Todo::all();

        if ($todoList->isEmpty()) {
            return null;
        }

        return $todoList;
    }

    function getOne($index): Todo|null
    {
        $todo = Todo::find($index);

        if ($todo == null) {
            return null;
        }

        return $todo;
    }

    function add($data): Todo|null
    {
        try {
            $todo = Todo::create([
                'name' => $data['name']
            ]);
        } catch (Exception $e) {
            return null;
        }

        return $todo;
    }

    function edit($index, $data): Todo|null
    {
        $todo = Todo::find($index);

        if ($this->isNull($todo)) {
            return null;
        }

        $todo->name = $data['name'];

        if (!$todo->save()) {
            return null;
        }

        return $todo;
    }

    function delete($index): bool
    {
        $status = Todo::destroy($index);

        if ($status < 1) {
            return false;
        }

        return true;
    }

    function isNull($data): bool
    {
        return $data == null;
    }
}
