<?php

namespace App\Repositories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

interface TodoRepository
{
    function getAll(): Collection|null;

    function findById($index): Todo|null;

    function add($data): Todo|null;

    function edit($index, $data): Todo|null;

    function delete($index): bool;

    function isNull($data): bool;
}
