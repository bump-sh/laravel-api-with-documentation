<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodoItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => 'todo_item',
            'attributes' => [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'folder_id' => $this->folder_id,
                'title' => $this->title,
                'description' => $this->description,
                'created' => [
                    'human' => $this->created_at->diffForHumans(),
                    'string' => $this->created_at->toDateTimeString(),
                ],
                'updated' => [
                    'human' => $this->updated_at->diffForHumans(),
                    'string' => $this->updated_at->toDateTimeString(),
                ],
            ],
            'relationships' => [
                'folder' => Folder::make($this->whenLoaded('folder')),
            ],
            'links' => [
                'self' => route('api.todo_items.show', [$this->folder_id, $this->id]),
            ],
        ];
    }
}
