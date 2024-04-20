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
 * @property string $token
 * @property \Illuminate\Support\Carbon $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\UserLinkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLink whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLink whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLink whereUserId($value)
 * @mixin \Eloquent
 */
class UserLink extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'token', 'expires_at'];
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
