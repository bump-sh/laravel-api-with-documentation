<?php

namespace Database\Factories;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'folder_id' => Folder::factory()->create(),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
        ];
    }
}
