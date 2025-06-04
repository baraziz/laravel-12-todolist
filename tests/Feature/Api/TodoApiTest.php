<?php

use App\Models\Todo;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

test('API post todo', function () {
    $response = postJson(
        '/api/todo',
        [
            'name' => 'test1'
        ],
        [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]
    );

    $response->assertCreated();

    $response->assertJsonStructure([
        'data' => [
            'id',
            'name'
        ]
    ]);
});

test('API update todo', function () {

    $todoId = Todo::latest()->first()->id;

    $uri = '/api/todo/' . $todoId;

    $response = putJson(
        $uri,
        [
            'name' => 'update test'
        ],
        [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]
    );

    $response->assertOk();

    $response->assertJsonStructure([
        "data" => [
            'id',
            'name'
        ]
    ])->assertJson([
        "data" => [
            'id' => $todoId,
            'name' => "update test"
        ]
    ]);
});

test('API update not found todo', function () {

    $todoId = Todo::latest()->first()->id;

    $uri = '/api/todo/' . ($todoId + 2);

    $response = putJson(
        $uri,
        [
            'name' => 'update test'
        ],
        [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]
    );

    $response->assertNotFound();

    $response->assertJsonStructure([
        "message"
    ])->assertJson([
        'message' => "todo not found"
    ]);
});

test('API get todos', function () {
    $response = getJson('/api/todo', [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        "data" => [
            [
                "id",
                "name"
            ]
        ]
    ]);
});

test('API get by Id todo', function () {

    $todoId = Todo::latest()->first()->id;

    $uri = '/api/todo/' . $todoId;

    $response = getJson($uri, [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ]);

    $response->assertStatus(200);

    $response->assertJsonStructure([
        "status",
        "message",
        "data" => [
            "id",
            "name"
        ]
    ])->assertJson(
        [
            "status" => "success",
            "message" => "data found",
            "data" => [
                "id" => $todoId
            ]
        ]
    );
});

test('API get by Id not found todo', function () {

    $todoId = Todo::latest()->first()->id;

    $uri = '/api/todo/' . $todoId + 2;

    $response = getJson($uri, [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ]);

    $response->assertNotFound();

    $response->assertJsonStructure([
        "message",
    ])->assertJson([
        "message" => "todo not found",
    ]);
});

test('API delete todo by id', function () {

    $todoId = Todo::all()->first()->id;

    $uri = '/api/todo/' . $todoId;

    $response = deleteJson($uri, [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ]);

    $response->assertOk();

    $response->assertJsonStructure([
        "message",
    ])->assertJson([
        "message" => "successfully deleted",
    ]);
});

test('API delete todo by id failed', function () {

    $todoId = Todo::latest()->first()->id;

    $uri = '/api/todo/' . $todoId + 2;

    $response = deleteJson($uri, [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ]);

    $response->assertNotFound();

    $response->assertJsonStructure([
        "message",
    ])->assertJson([
        "message" => "todo not found",
    ]);
});
