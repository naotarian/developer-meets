<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemporaryRegistration extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'email', 
        'email_verified_at', 
        'email_verified', 
        'email_verify_token', 
        'password',
        'created_at', 
        'update_at',
    ];
}
