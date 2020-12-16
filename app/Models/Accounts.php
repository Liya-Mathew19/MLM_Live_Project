<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;
    protected $collection="accounts";
    protected $fillable = ['acct_id','fk_user_id', 'user_acct_no','fk_referral_id','fk_parent_id','position','acct_type','remarks',
    'status','account_activation_date','node_id','N1','N2','N3','N4']; 
}
