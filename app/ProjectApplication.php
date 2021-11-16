<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProjectApplication extends Model
{
    use SoftDeletes;
    // protected $dates = ['deleted_at'];
    protected $fillable = [
        'project_id', 
        'author_id', 
        'application_id', 
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
