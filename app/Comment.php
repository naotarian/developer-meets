<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Comment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 
        'project_id', 
        'target_user_id', 
        'comment', 
        'created_at', 
        'update_at',
    ];
}
