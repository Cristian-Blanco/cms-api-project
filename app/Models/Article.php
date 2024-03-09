<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'video',
        'status',
        'user_create_id',
        'user_update_id'
    ];

    /**
     *  RELATIONSHIPS
     */
    public function userCreate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_create_id');
    }

    public function userUpdate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_update_id');
    }
}
