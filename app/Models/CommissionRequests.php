<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionRequests extends Model
{
    use HasFactory;
    protected $collection="commission_requests";
    protected $fillable = ['fk_user_id', 'amount','date','remarks','status']; 
}
