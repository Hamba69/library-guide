<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'title',
        'competency_description',
    ];

    /**
     * A topic belongs to a subject.
     */
    public function subject(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * A topic has many resources.
     */
    public function resources(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * A topic has many verified resources (scoped).
     */
    public function verifiedResources(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Resource::class)->where('is_verified', true);
    }
}
