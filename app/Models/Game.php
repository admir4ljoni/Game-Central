<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'created_by',
    ];

    public function getCreator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'created_by');
    }

    public function getVersions(): HasMany
    {
        return $this->hasMany(GameVersion::class);
    }
}