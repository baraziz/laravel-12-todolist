<?php

namespace App\Services;

interface TodoService
{
    function showAll();

    function showDetail($id);

    function add(array $data);

    function edit($id, array $data);

    function delete($id);
}
