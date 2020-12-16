<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeDetails extends Model
{
    use HasFactory;
    protected $collection="Income_details";
    protected $fillable = ['fk_acct_id','fk_wallet_id','no_of_active_nodes','amount','month','year','data','remarks','status'];  
}
