<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;

use App\Models\Accounts;
use App\Helper\Helper;
use App\Models\SubscriptionPayment;

class TreeController extends Controller
{
	
	public function getchild(Request $request)
    { 
	    $id=$request->input('id');
        $qry="select * from users u join accounts a on(u.id=a.fk_user_id)  where  fk_parent_id='$id' 
        ORDER BY a.node_id";
        $account =DB::select($qry);
        $current_month=date('m');
        $current_year=date('Y');
        $member=array();
        $info=array();

        foreach($account as $acct)
        {
            $account_id=$acct->acct_id;
            $account_status=$acct->status;
            
            $info['account_status']=$account_status;
            $subscriptions=SubscriptionPayment::where('fk_acct_id',$account_id)
            ->where('month',$current_month)
            ->where('year',$current_year)
            ->where('status','Paid')
            ->get();
            $info['status']=count($subscriptions);

            if($info['account_status']=='Progress' || $info['account_status']=='requested')
            {
            $info['color']="orange";
            }
            elseif($info['account_status']=='Cancelled')
            {
                $info['color']="blue";
            }
            elseif($info['status']==0)
            {
                $info['color']="red";
            }
            elseif($info['account_status']=='Deactivated')
            {
                $info['color']="violet";
            }
            else
            {
                $info['color']="green";
            }
            $info['acct']=$acct;
            $info['pos']=session('position');
            $member[]=$info;
        }
        
       
        return view('admin.childnodes',compact('account','member'));
	
	}
	
	
    
    public function admin_usernetworktree($id)
    {        
        
        $results=array();
        $current_month=date('m');
        $current_year=date('Y');
        $account =DB::select("select * from users u join accounts a on(u.id=a.fk_user_id) where acct_id='$id'");
        $member=array();
        $info=array();

        foreach($account as $acct)
        {
            $account_id=$acct->acct_id;
            $user_id=$acct->fk_user_id;
            $account_status=$acct->status;
            $position=$acct->position;
            session(['position' => $position]);
            $info['pos']=session('position');
            $info['account_status']=$account_status;
            $subscriptions=SubscriptionPayment::where('fk_acct_id',$account_id)
            ->where('month',$current_month)
            ->where('year',$current_year)
            ->where('status','Paid')
            ->get();
            $info['status']=count($subscriptions);
            if($info['account_status']=='Progress' || $info['account_status']=='requested')
            {
            $info['color']="orange";
            }
            elseif($info['account_status']=='Cancelled')
            {
                $info['color']="blue";
            }
            elseif($info['account_status']=='Deactivated')
            {
                $info['color']="violet";
            }
            elseif($info['status']==0)
            {
                $info['color']="red";
            }
            else
            {
                $info['color']="green";
            }
            $info['acct']=$acct;
            $member[]=$info;
        }
        
        //dd($member);
        $acct_id=session('acct_id');  
       return view('admin.admin_usernetworktree',compact('account','member','acct_id'));
       
    }

      public function usernetworktree($id)
    {        
        $users=Auth::user()->id;
        $results=array();
        $current_month=date('m');
        $current_year=date('Y');
       //$account=DB::select("select * from accounts where fk_user_id='$users' and acct_id='$id'");
        $account =DB::select("select * from users u join accounts a on(u.id=a.fk_user_id) where fk_user_id='$users' and acct_id='$id'");
        
        $member=array();
        $info=array();

        foreach($account as $acct)
        {
            $account_id=$acct->acct_id;
            $account_status=$acct->status;
            $position=$acct->position;
            session(['position' => $position]);
            $info['pos']=session('position');
            $info['account_status']=$account_status;
            $subscriptions=SubscriptionPayment::where('fk_acct_id',$account_id)
            ->where('month',$current_month)
            ->where('year',$current_year)
            ->where('status','Paid')
            ->get();
            $info['status']=count($subscriptions);
            if($info['account_status']=='Progress' || $info['account_status']=='requested')
            {
            $info['color']="orange";
            }
            elseif($info['account_status']=='Cancelled')
            {
                $info['color']="blue";
            }
            elseif($info['account_status']=='Deactivated')
            {
                $info['color']="violet";
            }
            elseif($info['status']==0)
            {
                $info['color']="red";
            }
            else
            {
                $info['color']="green";
            }
            $info['acct']=$acct;
            $member[]=$info;
        }
        //dd($member);
        $acct_id=session('acct_id');  
       return view('admin.usernetworktree',compact('account','member','acct_id'));
       
    }
    
    public function network_view()
    {        
         //$account= Accounts::where('node_id', 1)->first(); // parent account(ROOT) have the NODE_ID=1
         $account =DB::select("select * from users u join accounts a on(u.id=a.fk_user_id) where node_id=1");
        $current_month=date('m');
        $current_year=date('Y');
        $member=array();
        $info=array();

        foreach($account as $acct)
        {
            $account_id=$acct->acct_id;
            $account_status=$acct->status;
            $position=$acct->position;
            session(['position' => $position]);
            $info['pos']=session('position');
            $info['account_status']=$account_status;
            $subscriptions=SubscriptionPayment::where('fk_acct_id',$account_id)
            ->where('month',$current_month)
            ->where('year',$current_year)
            ->where('status','Paid')
            ->get();
            $info['status']=count($subscriptions);
            if($info['account_status']=='Progress' || $info['account_status']=='requested')
            {
            $info['color']="orange";
            }
            elseif($info['account_status']=='Cancelled')
            {
                $info['color']="blue";
            }
            elseif($info['account_status']=='Deactivated')
            {
                $info['color']="violet";
            }
            elseif($info['status']==0)
            {
                $info['color']="red";
            }
            else
            {
                $info['color']="green";
            }
            $info['acct']=$acct;
            $member[]=$info;
        }
        
        
        return view('admin.networktree',compact('account','member'));
        
    }

}
