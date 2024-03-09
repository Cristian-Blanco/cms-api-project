<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'tag',
        'user_create_id',
        'user_update_id'
    ];

    /**
     *  RELATIONSHIPS
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->onDelete('cascade');;
    }

    public function forms(): BelongsToMany
    {
        return $this->belongsToMany(Form::class)->onDelete('cascade');;
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->onDelete('cascade');;
    }

    public function userCreate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_create_id');
    }

    public function userUpdate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_update_id');
    }
}
