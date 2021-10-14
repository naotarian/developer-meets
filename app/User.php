<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'email', 'password', 'sex', 'engineer_history', 'age',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
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
