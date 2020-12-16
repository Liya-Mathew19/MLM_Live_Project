<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    use HasFactory;
    protected $collection="subscription_payments";
    protected $fillable = ['fk_acct_id', 'subscription_fee','gst','amount','paid_date','fk_transaction_id','month','year',
    'status']; 
}
