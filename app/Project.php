<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 
        'project_name', 
        'project_detail', 
        'language', 
        'sub_language',
        'number_of_application',
        'minimum_years_old',
        'minimum_experience',
        'max_years_old',
        'men_and_women',
        'tools',
        'purpose',
        'status',
        'remarks',
        'created_at',
        'updated_at',
    ];
    public function questions()
    {
        return $this->hasMany('App\Question');
    }
    public function project_applications()
    {
        return $this->hasMany('App\ProjectApplication');
    }
    
    protected static function boot() 
    {
        parent::boot();
        self::deleting(function ($project) {
          $project->project_applications()->delete();
        });
    }
}
