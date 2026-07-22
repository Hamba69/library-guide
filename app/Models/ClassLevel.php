<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * A class level has many subjects.
     */
    public function subjects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Subject::class);
    }

    /**
     * A class level has many topics through subjects.
     */
    public function topics(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Topic::class, Subject::class);
    }
}
