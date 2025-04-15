<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;  
use Illuminate\Database\Eloquent\Relations\HasMany;

class Score extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'game_id',
        'score',
    ];

    public function getUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getGame(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
