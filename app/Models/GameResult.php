<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $score
 * @property bool $is_win
 * @property float $win_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|GameResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|GameResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameResult whereIsWin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameResult whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameResult whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameResult whereWinAmount($value)
 * @mixin \Eloquent
 */
class GameResult extends Model
{
    use HasFactory;

    const HISTORY_LIST_LIMIT = 3;

    protected $fillable = [
        'user_id',
        'score',
        'is_win',
        'win_amount',
    ];

    protected $casts = [
        'is_win' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
