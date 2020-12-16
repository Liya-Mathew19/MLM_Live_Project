<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Accounts;
use App\Models\SubscriptionPayment;
use App\Models\IncomeDetails;
use Session;
use Auth;
use App\Helper\PaymentHelper;
use App\Helper\Helper;
use App\Models\WalletTransaction;

class GenerateSubscriptionFee extends Controller
{

    public static function initSubscriptionFee_sample()
    {
       DB::beginTransaction();
        $member=array();
        $currentDate=PaymentHelper::get_current_date();

        $pre_date = date("Y-m", strtotime($currentDate . " -1 month"));
        $pre_mth=date('m',strtotime($pre_date));
        $pre_year=date('Y',strtotime($pre_date));

        $month=date('m',strtotime($currentDate));  
        $year=date('Y',strtotime($currentDate));  
        $start=$year.'/'.$month.'/'.'01';     // Set a start date with year/month/01
        $end=$year.'/'.$month.'/'.'05';      // Set a end date with year/month/05

        $startDate = date('Y-m-d', strtotime($start));
        $endDate = date('Y-m-d', strtotime($end));

        if (($currentDate >= $startDate) && ($currentDate <=$endDate))
        {
            $accts=DB::table('accounts')
            ->join('subscription_payments', 'subscription_payments.fk_acct_id', '=','accounts.acct_id')
            ->select('accounts.*', 'subscription_payments.*')
            ->where('subscription_payments.month',$pre_mth)
            ->where('subscription_payments.year',$pre_year)
            ->get();
            foreach($accts as $acct)
            {
                $acct_status=$acct->status;
                $acct_id=$acct->acct_id;
                $user_id=$acct->fk_user_id;
                $commission_amount=$acct->commission_amount;
                PaymentHelper::initSubscriptionFee_byAccountID($acct_id,$currentDate);  
                
                if($acct_status=='Progress')
                {
                    $subscription_payments=DB::select("update subscription_payments set status='Closed'
                    where status='Progress' and created_at < '$startDate'");
                }
                else
                {
                    $income_details=IncomeDetails::where('fk_acct_id',$acct_id)
                    ->where('month',$pre_mth)
                    ->where('year',$pre_year)->first();

                    if(empty($income_details))
                    {
                        $wallet= new WalletTransaction();
                        $wallet->id=PaymentHelper::generate_wallet_id();
                        $wallet->fk_user_id=$user_id;
                        $wallet->amount=static::get_grand_total($acct_id);
                        $wallet->date=date('Y-m-d');
                        $wallet->type="Credit";
                        $wallet->remarks="Credited as Commission";
                        $wallet->status="Paid";
                        $wallet->save();
                        
                        $income=new IncomeDetails();
                        $income->fk_acct_id=$acct_id;
                        $income->fk_wallet_id=$wallet->id;
                        $income->no_of_active_node=static::get_active_accounts($acct_id);
                        $income->amount=static::get_grand_total($acct_id);
                        $income->commission_amount=$commission_amount;
                        $income->month=$pre_mth;
                        $income->year=$pre_year;
                        $income->date=$currentDate;
                        $income->remarks='Income';
                        $income->status='Credited';
                        $income->save();
                    }  
                    else
                    {
                
                        dd("Data already exists");
                    }                  
                } 
            }
            DB::commit();
        }
      
    }  

    //Set payments status closed after next month

    public static function initSubscriptionFee()
    {
        $currentDate=PaymentHelper::get_current_date();

        $pre_date = date("Y-m", strtotime($currentDate . " -1 month"));
        $pre_mth=date('m',strtotime($pre_date));
        $pre_year=date('Y',strtotime($pre_date));

        $month=date('m',strtotime($currentDate));  
        $year=date('Y',strtotime($currentDate));   
        $start=$year.'/'.$month.'/'.'01';     // Set a start date with year/month/01
        $end=$year.'/'.$month.'/'.'05';      // Set a end date with year/month/05

        $startDate = date('Y-m-d', strtotime($start));
        $endDate = date('Y-m-d', strtotime($end));
        
        $accounts=Accounts::where('status','=','Activated')->get();

        if (($currentDate >= $startDate) && ($currentDate <=$endDate))
        {
            $subscription_payments=DB::select("update subscription_payments set status='Closed'
            where status='Progress' and created_at < '$startDate'");
            
            foreach($accounts as $account)
            {
                $acct_id=$account->acct_id;
                PaymentHelper::initSubscriptionFee_byAccountID($acct_id,$currentDate);  
            }
        }
    }  


    
    public static function get_active_accounts($id)
    {
        $currentDate=PaymentHelper::get_current_date();

        $pre_date = date("Y-m", strtotime($currentDate . " -1 month"));
        $pre_mth=date('m',strtotime($pre_date));
        $pre_year=date('Y',strtotime($pre_date));

        $month=date('m',strtotime($currentDate));  
        $previous_month=date("m", strtotime($currentDate . " last month"));
        $year=date('Y',strtotime($currentDate));  
        $members=array();

        $accounts=Accounts::where('status','=','Activated')->get();
        $account=DB::table('accounts')
        ->join('users', 'accounts.fk_user_id', '=', 'users.id')
        ->select('users.*', 'accounts.*')->where('accounts.acct_id',$id)->first();

        $positions=$account->position;
        $node_id=$account->node_id;
        $levels=DB::select("select distinct position from accounts where position >'$positions'");
        $i=0;
        foreach($levels as $l)
        {
            $i++;
            $node=array();
            $position=$l->position;

            $accounts=DB::select("select * from accounts where node_id like '$node_id%' 
            and position='$position'");

            $progress_accounts=DB::select("select * from accounts where position='$position' and node_id like '$node_id%' and
             (status='Progress' or status='requested') ");

            $cancelled_accounts=DB::select("select * from accounts where position='$position' and node_id like '$node_id%' and
             status='Cancelled'");

            $rejected_accounts=DB::select("select * from accounts where position='$position' and node_id like '$node_id%' and
             status='Deactivated'");
            
            $active_subscriptions=DB::select("select * from accounts where node_id like '$node_id%'  and position='$position' and 
            acct_id IN (select distinct fk_acct_id from subscription_payments where status='Paid' 
            and month ='$pre_mth' and year <='$pre_year')");

            $inactive_subscriptions=DB::select("select * from accounts where node_id like '$node_id%'  and position='$position' and 
            acct_id IN (select distinct fk_acct_id from subscription_payments where status !='Paid' 
            and month ='$pre_mth' and year ='$pre_year')");

            $commission=DB::select("select * from subscription_payments where status='Paid' 
            and month ='$pre_mth' and year ='$pre_year' and fk_acct_id IN 
            (select distinct acct_id from accounts where node_id like '$node_id%'  
            and position='$position')");

            $commission_amount=0;
            foreach($commission as $subs)
            {
                $commission_amount += $subs->commission_amount;
            }

            $node['total_commission_amount']=$commission_amount;
            $node['total_members']=count($accounts);
            $node['active']=count($active_subscriptions);
            $node['inactive']=count($inactive_subscriptions);
            $node['progress']=count($progress_accounts);
            $node['cancelled']=count($cancelled_accounts);
            $node['rejected']=count($rejected_accounts);
            $node['position']=$position-$positions;
            $members[]=$node;
            
            if($node['total_members']==0)
            {
                break;
            }
            $level_limit=Helper::get_level_limit();
            if($i==$level_limit)
            {
                break;
            }
        }  
        $total_members=0;$active=0;$inactive=0;$progress=0;$cancelled=0;$rejected=0;$grand_total=0;$no=1;
           
        foreach($members as $accounts)
        {
           $total_members += $accounts['total_members'];
           $active += $accounts['active'];
           $inactive += $accounts['inactive'];
           $progress += $accounts['progress'];
           $cancelled += $accounts['cancelled'];
           $rejected += $accounts['rejected'];
           $grand_total += $accounts['total_commission_amount'];
        }
        
        return $active;
    }

    public static function get_grand_total($id)
    {
        $currentDate=PaymentHelper::get_current_date();

        $pre_date = date("Y-m", strtotime($currentDate . " -1 month"));
        $pre_mth=date('m',strtotime($pre_date));
        $pre_year=date('Y',strtotime($pre_date));
        
        $month=date('m',strtotime($currentDate));  
        $year=date('Y',strtotime($currentDate));  
        $members=array();

        $accounts=Accounts::where('status','=','Activated')->get();
        $account=DB::table('accounts')
        ->join('users', 'accounts.fk_user_id', '=', 'users.id')
        ->select('users.*', 'accounts.*')->where('accounts.acct_id',$id)->first();

        $positions=$account->position;
        $node_id=$account->node_id;
        $levels=DB::select("select distinct position from accounts where position >'$positions'");
        $i=0;
        foreach($levels as $l)
        {
            $i++;
            $node=array();
            $position=$l->position;

            $accounts=DB::select("select * from accounts where node_id like '$node_id%' 
            and position='$position'");

            $progress_accounts=DB::select("select * from accounts where position='$position' and node_id like '$node_id%' and
             (status='Progress' or status='requested') ");

            $cancelled_accounts=DB::select("select * from accounts where position='$position' and node_id like '$node_id%' and
             status='Cancelled'");

            $rejected_accounts=DB::select("select * from accounts where position='$position' and node_id like '$node_id%' and
             status='Deactivated'");
            
            $active_subscriptions=DB::select("select * from accounts where node_id like '$node_id%'  and position='$position' and 
            acct_id IN (select distinct fk_acct_id from subscription_payments where status='Paid' 
            and month ='$pre_mth' and year ='$pre_year')");

            $inactive_subscriptions=DB::select("select * from accounts where node_id like '$node_id%'  and position='$position' and 
            acct_id IN (select distinct fk_acct_id from subscription_payments where status !='Paid' 
            and month ='$pre_mth' and year ='$pre_year')");

            $commission=DB::select("select * from subscription_payments where status='Paid' 
            and month ='$pre_mth' and year ='$pre_year' and fk_acct_id IN 
            (select distinct acct_id from accounts where node_id like '$node_id%'  
            and position='$position')");

            $commission_amount=0;
            foreach($commission as $subs)
            {
                $commission_amount += $subs->commission_amount;
            }

            $node['total_commission_amount']=$commission_amount;
            $node['total_members']=count($accounts);
            $node['active']=count($active_subscriptions);
            $node['inactive']=count($inactive_subscriptions);
            $node['progress']=count($progress_accounts);
            $node['cancelled']=count($cancelled_accounts);
            $node['rejected']=count($rejected_accounts);
            $node['position']=$position-$positions;
            $members[]=$node;
            
            if($node['total_members']==0)
            {
                break;
            }
            $level_limit=Helper::get_level_limit();
            if($i==$level_limit)
            {
                break;
            }
        }  
        $total_members=0;$active=0;$inactive=0;$progress=0;$cancelled=0;$rejected=0;$grand_total=0;$no=1;
           
        foreach($members as $accounts)
        {
           $total_members += $accounts['total_members'];
           $active += $accounts['active'];
           $inactive += $accounts['inactive'];
           $progress += $accounts['progress'];
           $cancelled += $accounts['cancelled'];
           $rejected += $accounts['rejected'];
           $grand_total += $accounts['total_commission_amount'];
        }
        
        // $income=new IncomeDetails();
        // $income->fk_acct_id=$id;
        // $income->no_of_active_node=$active;
        // $income->amount=$grand_total;
        // $income->date=$currentDate;
        // $income->remarks='Income';
        // $income->status='Credited';
        // $income->save();
        
        return $grand_total;
    }
}
