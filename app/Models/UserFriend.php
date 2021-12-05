<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserFriend
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $friendsU
 * @property-read int|null $friends_u_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFriend whereUserId($value)
 */
class UserFriend extends Model
{
    use HasFactory;

    protected $table = "user_friend";

    public function friendsU(){
        return $this->belongsToMany(User::class, 'user_friend','id','user_id');
    }
}
