<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameVersion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'game_id',
        'version',
        'storage_path',
    ];

    public function getGame(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
