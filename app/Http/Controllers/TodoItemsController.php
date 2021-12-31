<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoItem as TodoItemResource;
use App\Models\Folder;
use App\Models\TodoItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TodoItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function index(Folder $folder)
    {
        return TodoItemResource::collection($folder->todoItems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Folder $folder)
    {
        $request->validate([
            'title' => [
                'required',
                'max:255',
            ],
        ]);

        $todoItem = $folder->todoItems()->create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return TodoItemResource::make($todoItem);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @param  \App\Models\TodoItem  $todoItem
     * @return \Illuminate\Http\Response
     */
    public function show(Folder $folder, TodoItem $todoItem)
    {
        return TodoItemResource::make($todoItem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folder  $folder
     * @param  \App\Models\TodoItem  $todoItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folder $folder, TodoItem $todoItem)
    {
        $request->validate([
            'title' => [
                'max:255',
            ],
        ]);

        $todoItem->update([
            'title' => $request->input('title', $todoItem->title),
            'description' => $request->input('description'),
        ]);

        return TodoItemResource::make($todoItem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folder  $folder
     * @param  \App\Models\TodoItem  $todoItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder, TodoItem $todoItem)
    {
        $todoItem->delete();

        return response()->noContent();
    }
}
