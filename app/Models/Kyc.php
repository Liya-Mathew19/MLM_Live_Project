<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    
    use HasFactory;
    protected $collection="kycs";
    protected $fillable = ['fk_user_id', 'type','identification_number','path','status','remarks'];  
}
