<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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

}
