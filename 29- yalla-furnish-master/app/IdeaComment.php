<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\IdeaCommentLike;

class IdeaComment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idea_id', 'user_id', 'comment', 'image', 'created_at', 'updated_at'
    ];

    public function idea()
    {
        return $this->belongsTo('App\Idea');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function replies()
    {
        return $this->hasMany('App\IdeaCommentReply', 'comment_id');
    }

    public function likes()
    {
        return $this->hasMany('App\IdeaCommentLike', 'comment_id');
    }

    public function setImageAttribute($value)
    {
        $image_name = time() . uniqid() . '.' . $value->getClientOriginalExtension();

        if (!Storage::disk('s3')->put('comments/' . $image_name, File::get($value), 'public')) {
            throw new \Exception('error in uploading image');
        }

        $this->attributes['image'] = $image_name;
    }

    public function getImageAttribute($value)
    {
        // return asset('storage/comments/' . $value);
        return env('AWS_URL') . 'comments/' . $value;
    }

    public function checkLike()
    {
        return IdeaCommentLike::where([
            'user_id' => auth()->guard('user')->user()->id,
            'comment_id' => $this->id,
        ])->first();
    } 
    // using deleting event to delete relation
    public static function boot() {
        parent::boot(); 
        static::deleting(function($comment) { // before delete() method call this
             $comment->replies()->delete(); // delete replies 
             $comment->likes()->delete(); // delete likes
         });
    }
}
