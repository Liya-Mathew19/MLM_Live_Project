<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionSettings extends Model
{
    use HasFactory;
    protected $collection="commission_settings";
    protected $fillable = ['amount','status']; 
}
