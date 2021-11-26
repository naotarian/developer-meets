<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 
        'project_id', 
        'target_user_id', 
        'comment', 
        'created_at', 
        'update_at',
    ];
}
