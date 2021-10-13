<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'reply_id',
        'created_at',
        'question_text',
        'updated_at',
        'deleted_at',
        'created_at',
    ];
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
}
