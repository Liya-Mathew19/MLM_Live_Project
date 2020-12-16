<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionPayments extends Model
{
    use HasFactory;
    protected $collection="commission_payments";
    protected $fillable = ['fk_request_id','wallet_id', 'amount','tds_percentage','tds_amount','total','reference_no','date','status']; 
}
