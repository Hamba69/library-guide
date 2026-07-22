<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_level_id',
        'name',
        'code',
    ];

    /**
     * A subject belongs to a class level.
     */
    public function classLevel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ClassLevel::class);
    }

    /**
     * A subject has many topics.
     */
    public function topics(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Topic::class);
    }
}
