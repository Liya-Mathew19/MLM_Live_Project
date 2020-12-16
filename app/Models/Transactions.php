<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $collection="transactions";
    protected $fillable = ['invoice_number','wallet_id','fk_user_id','subscription_fee','sgst','cgst','cess','gst', 'amount','date','paid_from','reference_no',
    'status']; 
}
