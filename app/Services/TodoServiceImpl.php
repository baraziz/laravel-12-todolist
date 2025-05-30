<?php

namespace App\Services;

use App\Models\Todo;
use App\Repositories\TodoRepository;
use Illuminate\Database\Eloquent\Collection;

class TodoServiceImpl implements TodoService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private TodoRepository $todoRepository) {}

    function showAll(): Collection|null
    {
        return $this->todoRepository->getAll();
    }

    function showDetail($id): Todo|null
    {
        return $this->todoRepository->findById($id);
    }

    function add(array $data): Todo|null
    {
        return $this->todoRepository->add($data);
    }

    function edit($id, array $data): Todo|null
    {
        return $this->todoRepository->edit($id, $data);
    }

    function delete($id): bool
    {
        return $this->todoRepository->delete($id);
    }
}
