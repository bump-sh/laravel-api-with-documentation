<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('folder_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
}
