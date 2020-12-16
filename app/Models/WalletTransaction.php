<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;
    protected $collection="wallet_transactions";
    protected $fillable = ['fk_user_id', 'amount','date','type','remarks',
    'status',];  
}
