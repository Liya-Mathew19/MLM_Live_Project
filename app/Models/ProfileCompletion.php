<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileCompletion extends Model
{
    use HasFactory;
    protected $collection="profile_completions";
    protected $fillable = ['fk_user_id', 'percentage'];  
}
