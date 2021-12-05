<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserActivity
 *
 * @property int $id
 * @property string $ip_address
 * @property int $user_id
 * @property string $activity
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 */
class UserActivity extends Model
{
    use HasFactory;

    protected $table = "user_activities";
    protected $fillable = ['user_id','activity','date','ip_address'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function getActivities($dateFrom = null, $dateTo = null){
        $activity = self::with("user:id,email,username");
        if($dateFrom == null && $dateTo == null){
            return $activity->latest("date")->select("user_activities.*")->paginate(40);
        }
        elseif($dateFrom == null){
            return $activity->where("date","<",$dateTo)->latest("date")->paginate(40);
        }
        elseif($dateTo == null){
            return $activity->where("date",">",$dateFrom)->latest("date")->paginate(40);
        }
        else{
            return $activity->whereBetween("date",[$dateFrom,$dateTo])->latest("date")->paginate(40);
        }
    }
}
