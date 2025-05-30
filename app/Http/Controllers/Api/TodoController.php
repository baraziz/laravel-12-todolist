<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DataNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Resources\TodoResource;
use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private TodoService $todoService) {}

    public function index()
    {
        $data = $this->todoService->showAll();

        if ($data == null) {
            return new TodoResource($data);
        }

        return TodoResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        return new TodoResource($this->todoService->add(
            $request->toArray()
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->todoService->showDetail($id);

        if ($data == null) {
            throw new DataNotFound("todo not found");
        }

        return new TodoResource($data);
        return response([
            "status" => "success",
            "message" => "data ditemukan",
            "data" => new TodoResource($data)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $this->todoService->edit($id, $request->all());

        if ($data == null) {
            throw new DataNotFound("todo not found");
        }

        return new TodoResource($this->todoService->edit(
            $id,
            $request->all()
        ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isDeleteSucces = $this->todoService->delete($id);
        if (!$isDeleteSucces) {
            throw new DataNotFound("todo not found");
        };

        return response([
            "message" => "successfully deleted"
        ]);
    }
}
