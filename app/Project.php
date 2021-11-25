<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Project extends Model
{
    use Notifiable;
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
        'project_image',
        'work_frequency',
        'created_at',
        'updated_at',
        'deleted_at',
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
        static::deleting(function ($project) {
          $project->project_applications()->delete();
        });
        // parent::boot();
        // static::deleting(function($project) {
        //     foreach ($project->project_applications()->get() as $app) {
        //         $app->delete();
        //     }
        // });
    }
}
