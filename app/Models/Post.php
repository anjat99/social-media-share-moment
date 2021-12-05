<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $caption
 * @property string $description
 * @property int $is_active
 * @property int $published
 * @property string|null $published_at
 * @property string|null $cover
 * @property int|null $location_id
 * @property int|null $album_id
 * @property int $user_id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAlbumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Album|null $album
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\Location|null $location
 * @property-read \App\Models\Status $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 */
class Post extends Model
{
    use HasFactory;

    public function album(){
        return $this->belongsTo(Album::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function status(){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public static function getStories()
    {
        return self::with('location', 'user', 'user.gender', 'status', 'comments', 'tags', 'album');
    }

    public static function getMyStories()
    {
        return self::with('location', 'user', 'user.gender', 'status', 'comments', 'tags', 'album')->where('user_id',session()->get('user')->id);
    }

    public static function getMyStory($id)
    {
        return ['post' => self::with('location', 'user', 'status', 'comments', 'tags', 'album')->where('user_id',session()->get('user')->id)->find($id)];
    }

    public static function getStory($id)
    {
        return ['post' => self::with('location', 'user', 'status', 'comments', 'tags', 'album')->find($id)];
    }

//    Methods
    public static function sortFilterSearchAndPageStories(Request $request){
        $user = session("user");
        $userIds = $user->friends->pluck('id')->toArray();

        $query = self::getStories()->where('published','=',1)->whereIn('user_id',$userIds);

        /** search */
        if($request->has('keyword') && $request->keyword != ""){
            $keyword = $request->keyword;
            $query = $query->where('caption','LIKE','%'.$keyword."%");
        }

        /** sort */
        if($request->has('sort') && $request->sort != "0"){
            if($request->sort == "Title ASC"){
                $query = $query->orderBy('caption');
            }elseif ($request->sort == "Title DESC"){
                $query = $query->orderByDesc('caption');
            }
            elseif ($request->sort == "Date ASC"){
                $query = $query->orderBy('published_at');
            }elseif ($request->sort == "Date DESC"){
                $query = $query->orderByDesc('published_at');
            }

        }

        /** filter by tags */
        if($request->has('tags') && count($request->tags) != 0){
            $query->with('tags');
            $tags = $request->tags;
            if(is_array($tags)){
                $query = $query->whereHas('tags', function($q) use ($tags){
                    return $q->whereIn('tag_id', $tags);
                });
            }
        }

        return $query;

    }


    public static function filterStoriesByStatus(Request $request){
        $result = self::getMyStories();

        /** filter by status */
        if($request->has('statuses') && count($request->statuses) != 0){
            $result = $result->whereIn('status_id', $request->statuses);
        }

        return $result;

    }

    public static function uploadCoverImage($image){
        $path = Storage::disk('public')->putFile('/assets/img/stories', $image);
        $exploded = explode('/', $path);
        return $exploded[count($exploded) - 1];
    }

    public static function deleteCoverImage($image){
        Storage::disk('public')->delete('/assets/img/stories' . $image);
    }

}
