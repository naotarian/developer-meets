<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
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
}
