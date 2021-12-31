<?php

use App\Models\Folder;
use App\Models\TodoItem;

test('can list todo items', function () {
    $this->actingAs($user = createUser());

    $folder = Folder::factory()->create([
        'user_id' => $user->id,
    ]);

    TodoItem::factory()->times(2)->create([
        'user_id' => $user->id,
        'folder_id' => $folder->id,
    ]);

    $this->getJson(route('api.todo-items.index', ['folder' => $folder->id]))
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

test('can create todo items', function () {
    $this->actingAs($user = createUser());

    $folder = Folder::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->postJson(route('api.todo-items.store', ['folder' => $folder->id]), [
        'title' => 'Decorate The House',
        'description' => 'All the walls need painting.'
    ])
        ->assertStatus(201)
        ->assertJson([
            'data' => [
                'attributes' => [
                    'title' => 'Decorate The House',
                    'description' => 'All the walls need painting.'
                ],
            ],
        ]);
});

test('can show todo items', function () {
    $this->actingAs($user = createUser());

    $folder = Folder::factory()->create([
        'user_id' => $user->id,
    ]);

    $todoItem = TodoItem::factory()->create([
        'user_id' => $user->id,
        'folder_id' => $folder->id,
        'title' => 'My New Todo Item'
    ]);

    $this->getJson(route('api.todo-items.show', ['folder' => $folder->id, 'todo_item' => $todoItem->id]))
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'attributes' => [
                    'title' => 'My New Todo Item',
                ],
            ],
        ]);
});

test('can update todo items', function () {
    $this->actingAs($user = createUser());

    $folder = Folder::factory()->create([
        'user_id' => $user->id,
    ]);

    $todoItem = TodoItem::factory()->create([
        'user_id' => $user->id,
        'folder_id' => $folder->id,
        'title' => 'My New Todo Item'
    ]);

    $this->putJson(route('api.todo-items.update', ['folder' => $folder->id, 'todo_item' => $todoItem->id]), [
        'title' => 'My Updated Todo Item'
    ])
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'attributes' => [
                    'title' => 'My Updated Todo Item',
                ],
            ],
        ]);
});

test('can delete todo items', function () {
    $this->actingAs($user = createUser());

    $folder = Folder::factory()->create([
        'user_id' => $user->id,
    ]);

    $todoItem = TodoItem::factory()->create([
        'user_id' => $user->id,
        'folder_id' => $folder->id,
        'title' => 'My New Todo Item'
    ]);

    $this->delete(route('api.todo-items.destroy', ['folder' => $folder->id, 'todo_item' => $todoItem->id]))
        ->assertStatus(204);
});
