<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    /**
     * Allowed resource type values (mirrors the migration enum).
     */
    public const TYPES = ['Link', 'PDF', 'Video', 'Simulation'];

    protected $fillable = [
        'topic_id',
        'title',
        'resource_type',
        'url',
        'annotation',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    /**
     * A resource belongs to a topic.
     */
    public function topic(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Convenience: return a Bootstrap badge colour class per resource type.
     */
    public function typeBadgeClass(): string
    {
        return match ($this->resource_type) {
            'PDF'        => 'danger',
            'Video'      => 'primary',
            'Simulation' => 'warning',
            default      => 'secondary', // Link
        };
    }

    /**
     * Convenience: return a FontAwesome icon class per resource type.
     */
    public function typeIcon(): string
    {
        return match ($this->resource_type) {
            'PDF'        => 'fa-file-pdf',
            'Video'      => 'fa-video',
            'Simulation' => 'fa-flask',
            default      => 'fa-link',
        };
    }
}
