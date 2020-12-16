<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $collection="settings";
    protected $fillable = ['subscription_fee','cgst_rate','cgst_amount','sgst_rate','sgst_amount', 'gst','cess','percentage','status','cess_flag']; 
}
