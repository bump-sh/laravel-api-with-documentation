<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Folder extends JsonResource
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
            'type' => 'folder',
            'attributes' => [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'name' => $this->name,
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
                'todo_items' => TodoItem::make($this->whenLoaded('todoItems')),
            ],
            'links' => [
                'self' => route('api.folders.show', [$this->user_id]),
            ],
        ];
    }
}
