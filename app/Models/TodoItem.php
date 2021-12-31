<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TodoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'folder_id',
        'title',
        'description',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
