<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquires extends Model
{
    use HasFactory;
    protected $collection="enquires";
    protected $fillable = ['name','email','subject','message','reply','status'];  
}
