<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\Models\User;
use App\Models\Kyc;
use App\Models\Accounts;
use App\Models\IncomeDetails;
use App\Models\ProfileCompletion;
use Validator;
use Illuminate\Http\Request;
use App\Helper\Helper;
use DateTime;

use App\Helper\PaymentHelper;
use Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function get_user_network_tree(Request $request,$id)
    {
        $month=$request->input('month');
        $dateObj   = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F'); 
        $year=$request->input('year');
        $members=array();
        
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
            and month='$month' and year='$year')");

            $inactive_subscriptions=DB::select("select * from accounts where node_id like '$node_id%'  and position='$position' and 
            acct_id IN (select distinct fk_acct_id from subscription_payments where status !='Paid' 
            and month='$month' and year='$year')");

            $commission=DB::select("select * from subscription_payments where status='Paid' 
            and month='$month' and year='$year' and fk_acct_id IN 
            (select distinct acct_id from accounts where node_id like '$node_id%'  
            and position='$position')");

            // $commission=DB::table('subscription_payments')
            // ->join('accounts', 'subscription_payments.fk_acct_id', '=', 'accounts.acct_id')
            // ->select('subscription_payments.*')
            // ->where('subscription_payments.status','=','Paid')
            // ->where('subscription_payments.month','=',$month)
            // ->where('subscription_payments.year','=',$year)
            // ->where('accounts.position','=',$position)
            // ->get();
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
            //$node['inactive']=$node['total_members']-$node['active'];
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
        $acct_id=session('acct_id');
        return view("user.get_user_networktree_view",compact('id','members','account','monthName','year','acct_id'));
        
        
    }

    //User HomePage
    public function index()
    {
        
        $acct=Helper::get_primary_account();

        session(['acct_id' => $acct]);
        $acct_id=session('acct_id');
        
        $userid=Auth::user()->id;
        $users=DB::select("select * from profile_completions where fk_user_id='$userid'");
        $accounts=DB::select("select * from accounts where fk_user_id='$userid' and status ='requested'");
        $wallet_credit=DB::select("select sum(amount) as credit_amount from wallet_transactions where fk_user_id='$userid' and type='Credit'");
        $wallet_debit=DB::select("select sum(amount) as debit_amount from wallet_transactions where fk_user_id='$userid' and type='Debit'");
        foreach($wallet_credit as $credit)
        {
            $wcredit=$credit->credit_amount;
        }
        foreach($wallet_debit as $debit)
        {
            $wdebit=$debit->debit_amount;
        }
        $total_wallet_balance= $wcredit - $wdebit;
        if(Auth::user()->user_type=='Admin')
        {
            return abort(401);
        }
        else
        {
        return view('user.userdashboard',compact("accounts","users","acct_id","total_wallet_balance"));
        }   
        
    }

    
    public function kycuploads(Request $request)
    {
        $acct_id=session('acct_id');
        return view('user.kycuploads',compact("acct_id"));
    }

    //Aadhar upload page view

    public function aadharupload(Request $request)
    {
        $acct_id=session('acct_id');
        return view('user.aadharupload',compact("acct_id"));
    }

    //Cheque upload page view

    public function chequeupload(Request $request)
    {
        $acct_id=session('acct_id');
        return view('user.chequeupload',compact("acct_id"));
    }

    //Pan upload page view

    public function panupload(Request $request)
    {
        $acct_id=session('acct_id');
        return view('user.panupload',compact("acct_id"));
    }

    //Bank upload page view

    public function bankupload(Request $request)
    {
        $acct_id=session('acct_id');
        return view('user.bankupload',compact("acct_id"));
    }

    //Bank details upload page view

    public function bankdetails()
    {
        $acct_id=session('acct_id');
        return view('user.bankdetails',compact("acct_id"));
    }

    //Customer profile page view

    public function customerprofile()
    {
        $userid=Auth::user()->id;
        //dd($userid);
        $users=DB::select("select * from users where id='$userid'");
        $kycs=DB::select("select * from kycs where fk_user_id ='$userid'");
        $kycs1=DB::select("select * from kycs where fk_user_id ='$userid' and status='Deactivated'");
        $account=DB::select("select * from accounts where fk_user_id ='$userid' and acct_type='Primary'");
        $info=array();
        $result=array();
        $acct_id=session('acct_id');
        
        foreach($account as $acct)
        {
            $acct1=$acct->acct_id;
            $active_accounts=Accounts::where('fk_referral_id',$acct1)
            ->where('status','Activated')->get();

            $active_parent=Accounts::where('fk_parent_id',$acct1)
            ->where('status','Activated')->get();

            $info['referral']=$active_accounts;
            $info['parent']=$active_parent;
        }
        $result[]=$info;
        //dd($result);
        $active_referral_count=count($active_accounts);
        $active_parent_count=count($active_parent);
        $profile=DB::select("select * from profile_completions where fk_user_id ='$userid'");
        //return response()->json($kycs);
        return view('user.customerprofile', compact("kycs","users","profile","acct1","acct_id","active_referral_count","active_parent_count"));
    }
    //Send request to admin

    public function userdatarequest()
    {
        $userid=Auth::user()->id;
        $users=DB::select("select * from users where id='$userid'");
        $accounts=DB::select("select * from accounts where fk_user_id='$userid'");
        DB::update("update users set user_status = 'requested' where id=$userid");
        DB::update("update accounts set status = 'requested' where fk_user_id=$userid");
        $acct_id=session('acct_id');
        return redirect()->back()->with('status',"Request send successfully..Please wait for your approval!!");
    }

    //Customer profile update page view

    public function customerprofileupdate()
    {
        $acct_id=session('acct_id');
        return view('user.customerprofileupdate',compact("acct_id"));
    }
  

    
    //Customer update actions

    public function updatecustomer(Request $request)
    {
        $acct_id=session('acct_id');
        request()->validate([
            'name' => ['required', 'string', 'min:2','max:255','regex:/^[\pL\s\-]+$/u'], 
            
        ]);
        $user=Auth::user()->id;
        $name=$request->input('name');
        if(Auth::user()->email != $request->input('email'))
        {
            request()->validate([
                'email' => 'required|string|unique:users,email|email|max:255',
            ]);
        }

        $email=$request->input('email');
        
        if(Auth::user()->phone != $request->input('phone'))
        {
            request()->validate([
                'phone' => 'required|numeric|unique:users,phone|digits:10', 
            ]);
        }

        $phone=$request->input('phone');
        

        $address=$request->input('address');
       
        DB::update("update users set name = '$name',email='$email',phone= '$phone',address= '$address' where id='$user'");
        return redirect("/customerprofile")->with('status',"Updated successfully!!");
        
    }


    //Secondary password setting page

    public function updatesecondarypassword(Request $request)
    {
        $this->validate($request, [
            
            'secondary_pwd' => ['required', 'string', 'min:4'], 
      
        ]);
        $acct_id=session('acct_id');
        $user=Auth::user()->id;
        $secondary_pwd=$request->input('secondary_pwd');
        $conf_sec_pwd=$request->input('confirm_secondary_pwd');
        $profile=ProfileCompletion::where([['fk_user_id',"=",Auth::user()->id]])->get();
        foreach ($profile as $p)
        {
			$p= $p->percentage;
			
        }
        if($secondary_pwd==$conf_sec_pwd)
        {
            if(Auth::user()->secondary_password==null)
            {
            DB::update("update users set secondary_password = '$secondary_pwd' where id='$user'");
            DB::table('profile_completions')->where([['fk_user_id',"=",Auth::user()->id ]])->update(['percentage' => $p+10]);
            
            }
            else
            {
                DB::update("update users set secondary_password = '$secondary_pwd' where id='$user'");
            }
            return redirect("/customerprofile")->with('status',"Updated successfully!!");
        }
        else 
        {
            return redirect("/customerprofile")->with('error',"Password Does not match !!");
        }    
    }

    //Deleting uploaded KYC

    public function deleteuploadedkyc($id)
    {
        $acct_id=session('acct_id');
        $kycs=Kyc::find($id);
        $profile=ProfileCompletion::where([['fk_user_id',"=",Auth::user()->id]])->get();
        foreach ($profile as $p)
        {
			$p= $p->percentage;
			
        }
        $kycs->delete();
   
        DB::table('profile_completions')->where([['fk_user_id',"=",Auth::user()->id ]])->update(['percentage' => $p-10]);
        
        return redirect("/customerprofile")->with('status',"Deleted Successfully!!");
    }

    //Save bank details

    public function storebankdetails(Request $request)
    {
        $request->validate([
            'holder_name' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',
            'acct_no' =>'required|regex:/(^\d{9,18}$)/u|confirmed',
            //'acct_no' => 'required|regex:/(^\d{9,18}$)/u',
            'ifsc_code' => 'required',
			
            ]);
            
        $acct_id=session('acct_id');
        $user=Auth::user()->id;
        $holder_name=$request->input('holder_name');
        $bank_name=$request->input('bank_name');
        $branch_name=$request->input('branch_name');
        
         $acct_no=$request->input('acct_no');
         $ifsc_code=$request->input('ifsc_code');
         $profile=ProfileCompletion::where([['fk_user_id',"=",Auth::user()->id]])->get();
        foreach ($profile as $p)
        {
			$p= $p->percentage;
			
        }
        DB::update("update users set account_holder_name='$holder_name', bank_name = '$bank_name', branch_name ='$branch_name',acct_no='$acct_no',ifsc_code= '$ifsc_code' where id='$user'");
        DB::table('profile_completions')->where([['fk_user_id',"=",Auth::user()->id ]])->update(['percentage' => $p+10]);
        return redirect('customerprofile')->with('status', 'Bank details updated successfully !!!');
    }


    //Edit uploaded bank details

    public function edituploadedbankdetails(Request $request)
    {
        $request->validate([
            'holder_name' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',
            'ifsc_code' => 'required',
			
            ]);
        $acct_id=session('acct_id');
        $user=Auth::user()->id;
        $holder_name=$request->input('holder_name');
        $bank_name=$request->input('bank_name');
        $branch_name=$request->input('branch_name');
        if(Auth::user()->acct_no != $request->input('acct_no'))
        {
            request()->validate([
                'acct_no' =>'required|unique:users,acct_no|regex:/(^\d{9,18}$)/u|confirmed',
            ]);
        }
        $acct_no=$request->input('acct_no');
        $ifsc_code=$request->input('ifsc_code');
        DB::update("update users set account_holder_name='$holder_name', bank_name = '$bank_name', branch_name ='$branch_name',acct_no='$acct_no',ifsc_code= '$ifsc_code' where id='$user'");
        return redirect('customerprofile')->with('status', 'Bank details updated successfully !!!');
    }

    //Delete uploaded bank details

    public function deleteuploadedbank($id)
    {
        $acct_id=session('acct_id');
        $user=Auth::user()->id;
        $profile=ProfileCompletion::where([['fk_user_id',"=",Auth::user()->id]])->get();
        foreach ($profile as $p)
        {
			$p= $p->percentage;
			
        }
        $user->bank_name->delete();
        $user->acct_no->delete();
        $user->ifsc_code->delete();
        DB::table('profile_completions')->where([['fk_user_id',"=",Auth::user()->id ]])->update(['percentage' => $p-10]);
        return redirect("/customerprofile")->with('status',"Deleted Successfully!!");
    }

    //Edit uploaded bank details page view

    public function edituploadedbank()
    {
        $acct_id=session('acct_id');
		$users=Auth::user()->id;
        return view('user.edituploadedbank',compact("users","acct_id"));
    }

    //Accounts view page

    public function accountview()
    {
        $acct_id=session('acct_id');
        $users=Auth::user()->id;
        $accountview=DB::select("select * from accounts where fk_user_id='$users' and (status !='Cancelled' and status !='Progress')");
        return view('user.accountview', compact("accountview","acct_id"));
    }

    //Cancel accounts

    public function cancelaccount($id)
    {
        $acct_id=session('acct_id');
        $users=Auth::user()->id;
        $accountview=DB::select("update accounts set status='Cancelled' where fk_user_id='$users' and acct_id='$id'");
        return redirect('accountview')->with('error','Account cancelled successfully');
    }

    //View accounts

    public function viewaccount($id)
    {

        $acct_id=session('acct_id');
        $users=Auth::user()->id;
        $accountview=DB::select("select * from accounts where fk_user_id='$users' and acct_id='$id'");
        
        if($accountview==null)
        {
            return abort(401);
        }
        else{
        return view('user.viewaccount', compact("accountview","acct_id"));
        }
    }

    //Add new accounts

   /* public function addnewaccount()
    {
        $acct_id=session('acct_id');
        $userid=Auth::user()->id;
       
        DB::beginTransaction();
		$accountcount=PaymentHelper::getParentID($acct_id);
			//var_dump($accountcount);
			$referral_id = null;
			$spill_over_id=null;
			$level=0;
			$node_id="";
			
			 if($accountcount ==null){
				 $referral_id = null;
				 $spill_over_id=null;
				 $level =$level +1;
				 $node_id = $level;
			 }else{
				 //var_dump($accountcount);
				 $referral_id = $acct_id;
				$spill_over_id= $accountcount->acct_id;
				 $level=$accountcount->position;
				 $parentnode_id=$accountcount->node_id;
				 
				  $nextlevel =$level +1;
				 $nodecount = Accounts::Where('position','=', $nextlevel)->count()+1;
				  
				 $node_id = $parentnode_id.$nodecount;
				 
				 $level=$nextlevel;
			 }
            $account=new Accounts();
            $account->acct_id=Helper::generate_account_number();
            $account->fk_user_id=$userid;
            
            $account->fk_referral_id=$referral_id;
            $account->fk_parent_id= $spill_over_id;
			
            $account->position=$level;
            $account->node_id=$node_id;
			
			$account->N1=0;
			 $account->N2=0;
			 $account->N3=0;
			 $account->N4=0;
			 
			
            
            
			 $account->acct_type="Secondary";
        $account->status="Progress";
        $account->save();
		
		// UPDATE PARENT NODE NEW CHILD NODE TO PARENT NODE
			$ChildAccountID= $account->acct_id;
			
			$ParentAccount=Accounts::where('acct_id', $spill_over_id)->first(); 
            if($ParentAccount!=null){
            if($ParentAccount->N1==0){
				$ParentAccount->N1=$ChildAccountID;
				 Accounts::where('acct_id', $spill_over_id)->update(['N1' => $ChildAccountID]);
			} 
			else if($ParentAccount->N2==0){
				 Accounts::where('acct_id', $spill_over_id)->update(['N2' => $ChildAccountID]);
			} 
			else if($ParentAccount->N3==0){
				 Accounts::where('acct_id', $spill_over_id)->update(['N3' => $ChildAccountID]);
			} 
			else if($ParentAccount->N4==0){
				 Accounts::where('acct_id', $spill_over_id)->update(['N4' => $ChildAccountID]);
			} 
			}
			

            DB::commit();
		
		
        return redirect('/addaccount')->with('status','Account added successfully');
    }
*/
  
    //Adding new accounts

    public function addaccount()
    {
        $users=Auth::user()->id;
        $acct_id=session('acct_id');
        $accountview=DB::table('accounts')->where('fk_user_id',$users)->latest('created_at')->first();
        return view('user.addaccount', compact("accountview","acct_id"));
    }
	public function addnewaccount()
    {
        $acct_id=session('acct_id');
        $userid=Auth::user()->id;
       
        DB::beginTransaction();
		$accountcount=PaymentHelper::getParentID($acct_id);
			//var_dump($accountcount);
			$referral_id = null;
			$spill_over_id=null;
			$level=0;
			$node_id="";
			
			 if($accountcount ==null){
				 $referral_id = null;
				 $spill_over_id=null;
				 $level =$level +1;
				 $node_id = $level;
			 }else{
				 //var_dump($accountcount);
				 $referral_id = $acct_id;
				$spill_over_id= $accountcount->acct_id;
				 $level=$accountcount->position;
				 $parentnode_id=$accountcount->node_id;
				 
				  $nextlevel =$level +1;
				 $nodecount = Accounts::Where('position','=', $nextlevel)->count()+1;
				  
				 $node_id = $parentnode_id.$nodecount;
				 
				 $level=$nextlevel;
			 }
            $account=new Accounts();
            $account->acct_id=Helper::generate_account_number();
            $account->fk_user_id=$userid;
            
            $account->fk_referral_id=$referral_id;
            $account->fk_parent_id= $spill_over_id."(self)";
			$account->created_at = date("Y-m-d");
            $account->position=$level;
            $account->node_id=$node_id;
			
			$account->N1=0;
			 $account->N2=0;
			 $account->N3=0;
			 $account->N4=0;
			 
			
            
            
			 $account->acct_type="Secondary";
        $account->status="Progress";
        //$account->save();
		
		/*( UPDATE PARENT NODE NEW CHILD NODE TO PARENT NODE
			$ChildAccountID= $account->acct_id;
			
			$ParentAccount=Accounts::where('acct_id', $spill_over_id)->first(); 
            if($ParentAccount!=null){
            if($ParentAccount->N1==0){
				$ParentAccount->N1=$ChildAccountID;
				 Accounts::where('acct_id', $spill_over_id)->update(['N1' => $ChildAccountID]);
			} 
			else if($ParentAccount->N2==0){
				 Accounts::where('acct_id', $spill_over_id)->update(['N2' => $ChildAccountID]);
			} 
			else if($ParentAccount->N3==0){
				 Accounts::where('acct_id', $spill_over_id)->update(['N3' => $ChildAccountID]);
			} 
			else if($ParentAccount->N4==0){
				 Accounts::where('acct_id', $spill_over_id)->update(['N4' => $ChildAccountID]);
			} 
			}
			*/

            DB::commit();
		
		return view('user.addaccount', compact("account","acct_id"));
        return redirect('/addaccount')->with('status','Account added successfully');
    }


    //Add spill over ID

    public function updatespill_over_id(Request $request,$id)
    {
        $acct_id=session('acct_id');
        
        $accounts = DB::select("select * from accounts where acct_id=$id");
        foreach($accounts as $account){
            $account->fk_parent_id=$request->input('spill_over_id');
        }

        $accounts_spill_id = Accounts::where('acct_id', '=', $account->fk_parent_id)->first();
        if ($j === null) 
        {
            return redirect('/addaccount')->with('error','No account Exist with this ID');
        } 
        else 
        {
            DB::update("update accounts set fk_parent_id='$account->fk_parent_id' where acct_id='$id'");
            return redirect('/addaccount')->with('status','Account Updated successfully');
        }
        
    }


public function searchspill_over_id(Request $request){
	$fk_parent_id=$request->input('spill_over_id');
	$account= Accounts::where('acct_id', '=',$fk_parent_id)->first();
	$result=array();
	if($account==null){
		$result["status"]=false;
		$result["message"]="No Account Found on this ID";
		
	}else{
		$result["user"]=User::where('id', $account->fk_user_id)->first();
		$result["status"]=true;
		$result["message"]="Account Found";
		$result["account"]= $account;
		
	}
	
	return response()->json(json_encode($result));
}

    //Send account approval requests

    public function sendaccountrequest(Request $request)
    {
		//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
		$acct_id=session('acct_id');
        $userid=Auth::user()->id;
        $spill_over_id=$request->input('parent_id');
		if($spill_over_id==null){
			$spill_over_id= $acct_id;
		}
        DB::beginTransaction();
		$accountcount=PaymentHelper::getParentID($spill_over_id);
			//var_dump($accountcount);
			$referral_id = null;
			 
			$level=0;
			$node_id="";
			
			 if($accountcount ==null){
				  echo "ERROR. NO SPIL OVER ID FOUND";
			 }else{
				 //var_dump($accountcount);
				 $referral_id = $acct_id;
				$spill_over_id= $accountcount->acct_id;
				 $level=$accountcount->position;
				 $parentnode_id=$accountcount->node_id;
				 
				  $nextlevel =$level +1;
				/* $nodecount = Accounts::Where('position','=', $nextlevel)->count()+1;*/
				
				 $nodecount = Accounts::Where('position','=', $nextlevel)
				 ->Where('node_id','like', $parentnode_id.'%')
				 ->count()+1; 
				 
				 $node_id = $parentnode_id.$nodecount;
				 
				 $level=$nextlevel;
			 }
			 
            $account=new Accounts();
            $account->acct_id=Helper::generate_account_number();
            $account->fk_user_id=$userid;
            
            $account->fk_referral_id=$referral_id;
            $account->fk_parent_id= $spill_over_id;
			$account->created_at = date("Y-m-d");
            $account->position=$level;
            $account->node_id=$node_id;
			
			$account->N1=0;
			 $account->N2=0;
			 $account->N3=0;
			 $account->N4=0;
			 $account->acct_type="Secondary";
        $account->status="requested";
        $account->save();
		
		/*( UPDATE PARENT NODE NEW CHILD NODE TO PARENT NODE	*/
			$ChildAccountID= $account->acct_id;
			
			$ParentAccount=Accounts::where('acct_id', $spill_over_id)->first(); 
            if($ParentAccount!=null){
            if($ParentAccount->N1==0){
				$ParentAccount->N1=$ChildAccountID;
				 Accounts::where('acct_id', $spill_over_id)->update(['N1' => $ChildAccountID]);
			} 
			else if($ParentAccount->N2==0){
				 Accounts::where('acct_id', $spill_over_id)->update(['N2' => $ChildAccountID]);
			} 
			else if($ParentAccount->N3==0){
				 Accounts::where('acct_id', $spill_over_id)->update(['N3' => $ChildAccountID]);
			} 
			else if($ParentAccount->N4==0){
				 Accounts::where('acct_id', $spill_over_id)->update(['N4' => $ChildAccountID]);
			} 
			}
		

            DB::commit();
		 return redirect('accountview')->with('status','Request Send Successfully');
    }

    //Accepting admin activation

    public function activationaccept()
    {
        $acct_id=session('acct_id');
        $user_id=Auth::user()->id;
        DB::update("update users set approval_status_notification = 'No' where id='$user_id'");
        return redirect()->back();
    }

    //Upload user image

    public function upload_user_image(Request $request,$id)
	{
        $request->validate([
			'user_image' => 'required',
			
			]);
       
        $users=User::find($id);
		if ($request->hasfile('user_image'))
    	{
    		$file=$request->file('user_image');
    		$name=$file->getClientOriginalName();
    		$filename=time().$name;
    		$file->move('uploads/kyc/',$filename);
    		$users->user_image=$filename;
    	}
    	else{
    		$users->user_image='';
        }
        
		$users->save();
		
			return redirect()->back()->with('status', 'Image updated successfully !!!');
    
    }

    //Upload GST number
    
    public function update_gst(Request $request,$id)
    {
        $acct_id=session('acct_id');
        $user=User::find($id);
        $user->gstin=$request->input('gstin');
        $user->save();
        
        return redirect("/customerprofile")->with('status',"GST Number Updated successfully!!");
    }

    public function change_password(Request $request)
    {
        $acct_id=session('acct_id');
        return view('user.change_password',compact("acct_id"));
    }

    
    public function change_password_action(Request $request)
    {
        $validation=Validator::make($request->all(), [
            'new_password' => 'required|min:3|max:20',
            'confirm_password' => 'required|min:3|max:20|same:new_password',
        ]);

        if($validation->fails())
        {
            return redirect()->back()->with('error', "Confirm password and new password must match !!");
        }
        
        $acct_id=session('acct_id');
        $user_id=Auth::user()->id;
        $old_password=$request->input('old_password');
        $new_password=Hash::make($request->input('new_password'));
        $confirm_password=Hash::make($request->input('confirm_password'));        
        if(Hash::check($old_password, Auth::user()->password))
        {
            User::where('id', $user_id)
          ->update(['password' => $new_password,'confirm_password'=>$confirm_password]);
            
            return redirect()->back()->with('status',"Password Changed Successfully !!");
        }
        else
        {
            return redirect()->back()->with('error',"Old Password is wrong !!");
        }
    }

    public function income_details()
    {
        $acct_id=session('acct_id');
        $accts=array();
        $transactions=array();
        $result=array();
        $user_id=Auth::user()->id;
        $accounts=Accounts::where('fk_user_id',$user_id)
        ->where('status','Activated')->get();
     
        foreach($accounts as $account)
        {
            $account_id=$account->acct_id;
            $incomes=IncomeDetails::where('fk_acct_id',$account_id)
            ->where('status','Paid')->get();
            $transactions[]=$incomes;
        }
        $result['accounts']=$accounts;
        $result['incomes']=$transactions;
       //dd($result);
       
        return view('user.income_details',compact('acct_id','accounts','result'));
    }


    

}