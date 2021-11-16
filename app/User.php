<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 
        'email', 
        'password', 
        'sex', 
        'engineer_history', 
        'age','email_verified', 
        'email_verify_token',
        'self_introduction',
        'free_url',
        'comment',
        'icon_image_sp',
        'icon_image',
        'friends_id',
        'twitter',
        'nickname',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $dates = ['deleted_at']; //追記

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
     protected static function boot() 
    {
        parent::boot();
        static::deleting(function ($user) {
          $user->projects()->delete();
        });
        // parent::boot();
        // static::deleting(function($user) {
        //     foreach ($user->projects()->get() as $project) {
        //         $project->delete();
        //     }
        // });
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    // 投稿者は複数のコメントを持つ。
    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    // 投稿者は複数のリプライを持つ。
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
}
