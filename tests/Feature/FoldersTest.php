<?php

use App\Models\Folder;

test('can list folders', function () {
    $this->actingAs($user = createUser());

    Folder::factory()->times(2)->create([
        'user_id' => $user->id,
    ]);

    $this->getJson(route('api.folders.index'))
        ->assertStatus(200)
        ->assertJsonCount(2, 'data');
});

test('can create folder', function () {
    $this->actingAs($user = createUser());

    $this->postJson(route('api.folders.store', [
        'name' => 'My First Folder',
    ]))
        ->assertStatus(201)
        ->assertJsonCount(1)
        ->assertJson([
            'data' => [
                'attributes' => [
                    'name' => 'My First Folder',
                ],
            ],
        ]);
});

test('can show folder', function () {
    $this->actingAs($user = createUser());

    $folder = Folder::factory()->create([
        'user_id' => $user->id,
        'name' => 'My New Folder',
    ]);

    $this->getJson(route('api.folders.show', [$folder->id]))
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'attributes' => [
                    'name' => 'My New Folder',
                ],
            ],
        ]);
});

test('can update folder', function () {
    $this->actingAs($user = createUser());

    $folder = Folder::factory()->create([
        'user_id' => $user->id,
        'name' => 'My Folder',
    ]);

    $this->putJson(route('api.folders.show', [$folder->id]), [
        'name' => 'My Updated Folder'
    ])
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'attributes' => [
                    'name' => 'My Updated Folder',
                ],
            ],
        ]);
});

test('can delete folder', function () {
    $this->actingAs($user = createUser());

    $folder = Folder::factory()->create([
        'user_id' => $user->id,
        'name' => 'My Folder',
    ]);

    $this->delete(route('api.folders.destroy', [$folder->id]))
        ->assertNoContent();
});
