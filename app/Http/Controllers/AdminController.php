<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kyc;
use App\Models\Enquires;
use App\Models\Accounts;
use App\Models\SubscriptionPayment;
use App\Models\Transactions;
use App\Models\CommissionPayments;
use App\Models\CommissionSettings;
use App\Helper\PaymentHelper;
use App\Models\CommissionRequests;
use App\Models\WalletTransaction;
use App\Mail\EnquiryMail;
use App\Helper\Helper;
use Session;
use DB;
use Auth;
use DateTime;
use App\Mail\VerificationMail;
use Mail;

class AdminController extends Controller
{
    public function __construct()
    {   
        $this->middleware('admin');
    }

    //Customer Bank reports

    public function customer_bank_report()
    {
        $users=DB::table('users')
            ->join('kycs', 'users.id', '=', 'kycs.fk_user_id')
            ->select('users.*', 'kycs.identification_number')
            ->where('users.user_status','=','Activated')
            ->where('kycs.type','=','Pan Card Details')
            ->get();
            //dd($users);
       // $users=User::where('user_status','Activated')->get();
        return view("admin.customer_bank_report",compact('users'));
    }

    //Enquiry list

    public function admin_enquiry_view()
    {
        $enquires=Enquires::where('status','Send')->get();
        return view("admin/admin_enquiry_view",compact('enquires'));
    }

    //Full network view

    public function get_full_network_tree(Request $request)
    {
        $month=$request->input('month');
        $dateObj   = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F'); 
        $year=$request->input('year');
        $members=array();
        $account=DB::select("select * from users u join accounts a on(u.id=a.fk_user_id) where node_id=1");//get ROOT element
        foreach($account as $acct)
        {
            $account_id=$acct->acct_id;
            $positions=$acct->position;
            $levels=DB::select("select distinct position from accounts where position >'$positions'");
            
            foreach($levels as $l)
            {
                $node=array();
                $position=$l->position;
                $accounts=DB::select("select * from accounts where position='$position'");
                $progress_accounts=DB::select("select * from accounts where position='$position' and (status='Progress' or status='requested') ");
                $cancelled_accounts=DB::select("select * from accounts where position='$position' and status='Cancelled'");
                $rejected_accounts=DB::select("select * from accounts where position='$position' and status='Deactivated'");
                
                $active_subscriptions=DB::select("select * from accounts where position='$position' and 
                    acct_id IN (select distinct fk_acct_id from subscription_payments where status='Paid' 
                    and month='$month' and year='$year')");

                $inactive_subscriptions=DB::select("select * from accounts where position='$position' and 
                    acct_id IN (select distinct fk_acct_id from subscription_payments where status !='Paid' 
                    and month='$month' and year='$year')");

                $commission=DB::select("select * from subscription_payments where status='Paid' and month='$month' 
                    and year='$year' and fk_acct_id IN (select distinct acct_id from accounts 
                    where position='$position')");

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
                $node['position']=$position-$positions;
                $members[]=$node;

                if($node['total_members']==0)
                {
                    break;
                }    
            }  
        }
        return view("admin.get_full_network_tree_view",compact('members','account','monthName','year'));  
    }


    //User-wise network view

    public function get_network_tree(Request $request,$id)
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
        $parent_id=$account->acct_id;
        
        $levels=DB::select("select distinct position from accounts where position >'$positions'");
        $i=0;
        foreach($levels as $l)
        {
            $i++;
            $node=array();
            $position=$l->position;
            $accounts=DB::select("select * from accounts where node_id like '$node_id%' and position='$position'");
            $progress_accounts=DB::select("select * from accounts where position='$position' and 
                node_id like '$node_id%' and(status='Progress' or status='requested') ");
            $cancelled_accounts=DB::select("select * from accounts where position='$position' 
                and node_id like '$node_id%' and status='Cancelled'");
            $rejected_accounts=DB::select("select * from accounts where position='$position' 
            and node_id like '$node_id%' and status='Deactivated'");
            
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
        return view("admin.get_network_tree_view",compact('id','members','account','monthName','year'));  
    }

    //Registrations on progress view

    public function admin_progress_view()
    {
        $users=User::where('user_status','Progress')
        ->where('user_type','=','User')
        ->orWhere('user_status','Verified')
        ->where('user_type','=','User')
        ->get();
        return view("admin.admin_progress_view",compact('users'));
    }


    public function admin_cancelled_view()
    {
        $users= DB::table('accounts')->where('status','Cancelled')
        ->join('users', 'users.id', '=','accounts.fk_user_id')
        ->select('accounts.*', 'users.*')->get();
        
        return view("admin.admin_cancelled_view",compact('users'));
    }

    //Enquiry replies

    public function enquiry_reply(Request $request,$id)
    {
        $enquires=Enquires::find($id);
        $name=$enquires->name;
        $email=$enquires->email;
        $subject=$enquires->subject;
        $reply_message=$request->input("message");
        $enquires->reply=$reply_message;
        $enquires->status="Replied";
        $enquires->save();
        $data = array(
            'name'      =>  $name,
            'email' => $email,
            'subject'   =>   $subject,
            'message'   =>   $reply_message
        );

        Mail::to($data['email'])->send(new EnquiryMail($data));
        return redirect()->back()->with('status','Reply sent successfully !!');
    }

    //Admin Dashboard

    public function index()
    {
        $users=DB::select("select * from users where user_type != 'admin' and user_status='requested'");
        $count=count($users);

        $account= DB::table('accounts')->where('status','requested')->where('acct_type','Secondary')
        ->join('users', 'users.id', '=','accounts.fk_user_id')
        ->where('users.user_status','=','Activated')
        ->select('accounts.*', 'users.*')->get();
        $counts=count($account);

        $progress_users=User::where('user_status','Progress')
        ->where('user_type','=','User')
        ->orWhere('user_status','Verified')
        ->where('user_type','=','User')
        ->get();
        $progress_count=count($progress_users);
        
        $pending_documents=DB::table('kycs')
        ->join('users', 'users.id', '=','kycs.fk_user_id')
        ->where('users.user_status','=','Activated')
        ->where('kycs.type','=','Pan Card Details')
        ->where('kycs.status','Pending')
        ->select('kycs.*', 'users.*')->get();
        $pending_count=count($pending_documents);
        

        $cancelled_account= DB::table('accounts')->where('status','Cancelled')
        ->join('users', 'users.id', '=','accounts.fk_user_id')
        ->select('accounts.*', 'users.*')->get();
        $cancel_count=count($cancelled_account);
        $enquiry=Enquires::where('status','Send')->get();
        $enquiry_count=count($enquiry);
        if(Auth::user()->user_type !='admin')
        {
            return abort(401);
        }
        else
        {
        return view('admin.admindashboard',compact("count","counts",'pending_count','cancel_count',"enquiry_count","progress_users","progress_count"));
        }
    }


    //Customer Requests View

    public function customerrequests()
    {
        $users=DB::select("select * from users where user_type != 'admin' and user_status='requested'");
        return view('admin.customerrequests',['users'=>$users]);
    }


    //Account Requests View

    public function accountrequests ()
    { 
        $account= DB::table('accounts')->where('status','requested')->where('acct_type','Secondary')
            ->join('users', 'users.id', '=','accounts.fk_user_id')
            ->where('users.user_status','=','Activated')
            ->select('accounts.*', 'users.*')->get();
        return view('admin.accountrequests',compact('account'));
    }

    public function pending_document()
    { 
        $account= DB::table('kycs')
        ->join('users', 'users.id', '=','kycs.fk_user_id')
        ->where('users.user_status','=','Activated')
        ->where('kycs.type','=','Pan Card Details')
        ->where('kycs.status','Pending')
        ->select('kycs.*', 'users.name','users.id as uid')->get();
        
        return view('admin.pending_document',compact('account'));
    }


    //User view by id

    public function admincustomerview($id)
    {
        $results=array();
        $info=array();
        $infos=array();
        $users=User::find($id);
        $kycs=DB::select("select * from kycs where fk_user_id ='$id'");
        $account=DB::select("select * from accounts where fk_user_id='$id'and acct_type !='Primary' and (status!='Progress' and status!='Cancelled') ");
        $kycdetails=DB::select("select * from kycs where fk_user_id ='$id' and status='Activated'");
        foreach($account as $accounts)
        {
            $status=$accounts->status;
            $info[]=$status;
        } 
        foreach($kycs as $kyc)
        {
            $kycstatus=$kyc->status;
            $infos[]=$kycstatus;  
        }  
        $results['account']=$info;
        $results['kyc']=$infos;
           
        return view('admin.admincustomerview', compact("kycs","users","account","kycdetails","results"));  
    }

    //Edit user bank details

    public function adminedituploadedbankdetails(Request $request,$id)
    {
        $user=User::find($id);
        $request->validate([
            'holder_name' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',
            'ifsc_code' => 'required',
            ]);
        $holder_name=$request->input('holder_name');
        $bank_name=$request->input('bank_name');
        $branch_name=$request->input('branch_name');
        if($user->acct_no != $request->input('acct_no'))
        {
            request()->validate([
                'acct_no' =>'required|unique:users,acct_no|regex:/(^\d{9,18}$)/u|confirmed',
            ]);
        }
        $acct_no=$request->input('acct_no');
        $ifsc_code=$request->input('ifsc_code');
        DB::update("update users set account_holder_name='$holder_name', bank_name = '$bank_name', branch_name ='$branch_name',acct_no='$acct_no',ifsc_code= '$ifsc_code' where id='$id'");
        return redirect()->back()->with('status', 'Bank details updated successfully !!!');
    }
     
     //Approved users view

     public function adminapprovedcustomerview($id)
     {
        $users=User::find($id);
        if($users==null)
        {
            return abort(404);
        }
        $results=array();
        $info=array();
        $infos=array();
        $kycs=DB::select("select * from kycs where fk_user_id ='$id'");
        $account=DB::select("select * from accounts where fk_user_id='$id' and (status!='Progress' and status !='Cancelled') ");
        $transactions=Transactions::where('fk_user_id',$id)->where('status','Paid')->get();
        $trans_amount=0;
        foreach($transactions as $trans)
        {
           $total_amount=$trans->amount;
           $trans_amount += $total_amount;
        }
        $kycdetails=DB::select("select * from kycs where fk_user_id ='$id' and status='Activated'");
        foreach($account as $accounts)
        {
            $status=$accounts->status;
            $remarks=$accounts->remarks;
            $info[]=$remarks; 
        } 
        foreach($kycs as $kyc)
        {
            $kycremarks=$kyc->remarks;
            $infos[]=$kycremarks;
        }  
        $results['account']=$info;
        $results['kyc']=$infos;
        return view('admin.adminuserview', compact("kycs","users","account","kycdetails","results","transactions","trans_amount"));
    }

    //User profile update by id view

    public function admincustomerprofileupdate($id)
    {
        $users=User::find($id);
        $kycs=DB::select("select * from kycs where fk_user_id ='$id'");
        if($users==null || $kycs==null)
        {
            return abort(404);
        }
        else
        {
            return view('admin.admincustomerprofileupdate',compact("kycs","users"));
        }
    }
    
    //User profile update by id action

    public function adminupdatecustomer(Request $request,$id)
    {
        $users=User::find($id);
        $kycs=DB::select("select * from kycs where fk_user_id ='$id'");
        $name=$request->input('name');
        $email=$request->input('email');
        $phone=$request->input('phone');
        $address=$request->input('address');
        DB::update("update users set name = '$name',email='$email',phone= '$phone',address= '$address' where id='$id'");
        return redirect()->route('adminuserview',$id)->with('status','Data Updated!!!');   
    }


    //Primary account approval [ Main user]

    public function approvecustomer($id)
    {
        DB::beginTransaction();
            $users=DB::select("select * from users where id =$id");
            $userdata=User::find($id);
            $mobile=$userdata->phone;
            $name=$userdata->name;
            $email=$userdata->email;
            $accounts=DB::select("select * from accounts where fk_user_id =$id and acct_type='Primary'");
            foreach($accounts as $account)
            {
                $acct_id=$account->acct_id;
            }
            $approval_date=date('Y-m-d');
            $approval_date = date('Y-m-d', strtotime($approval_date)); 
            $month=date('m',strtotime($approval_date)); 
            $year=date('Y',strtotime($approval_date));
            $status='Activated'; 
            $message="Dear ".$name.","."YOUR AFPA General Trader's a/c ID -". PaymentHelper::bind_account_number($acct_id)." with KYC is " .$status.".";
            $data = array(
                'name'      =>  $name,
                'email' => $email,
                'message'   =>   $message
            );
    
            Mail::to($data['email'])->send(new VerificationMail($data));
            DB::update("update users set user_status = 'Activated',approval_status_notification = 'Yes' where id=$id");
            DB::update("update accounts set status = 'Activated',account_activation_date='$approval_date' where fk_user_id=$id and acct_type='Primary'");
            Helper::send_sms($mobile,$message);
            PaymentHelper::save_to_subscription_payment($acct_id,$month,$year);
            DB::commit();
           return redirect()->route('adminuserview',$id)->with('status','User Account Approved!!!');   
        }

        //Primary User Rejection

        public function rejectcustomer($id)
        {
            DB::beginTransaction();
            $users=DB::select("select * from users where id =$id");
            $accounts=DB::select("select * from accounts where fk_user_id =$id and acct_type='Primary'");
            foreach($accounts as $account)
            {
                $acct_id=$account->acct_id;
            }
            $userdata=User::find($id);
            $mobile=$userdata->phone;
            $name=$userdata->name;
            $email=$userdata->email;
            $status='Rejected'; 
            $message="Dear ".$name.","."YOUR AFPA General Trader's A/C ID - ". PaymentHelper::bind_account_number($acct_id)." with KYC is " .$status.".";
            $data = array(
                'name'      =>  $name,
                'email' => $email,
                'message'   =>   $message
            );
    
            Mail::to($data['email'])->send(new VerificationMail($data));
            DB::update("update users set user_status = 'Deactivated',approval_status_notification = 'No' where id=$id");
            DB::update("update accounts set status = 'Deactivated' where fk_user_id=$id");
            Helper::send_sms($mobile,$message);
            DB::commit();
            return redirect()->back()->with('status','User Account Rejected!!!');;
        }

        //KYC approval

        public function approvekyc($id)
        {
            $kycs=DB::select("select * from kycs where id =$id");
            DB::update("update kycs set status = 'Activated' where id=$id");
            return redirect()->back()->with('status',"KYC Document Approved !!");
        }


        //KYC rejection

        public function rejectkyc(Request $request,$id)
        {
            $kycs=DB::select("select * from kycs where id ='$id'");
            DB::update("update kycs set status = 'Deactivated' where id=$id");
            return redirect()->back()->with('error',"KYC Document Rejected !!'");
        }


        //Secondary account Approval

        public function approveaccount($id)
        {
            DB::beginTransaction();
            $account= DB::table('accounts')->where('acct_id',$id)
                ->join('users', 'users.id', '=','accounts.fk_user_id')
                ->select('accounts.*', 'users.*')->first();
            $acct_id=$account->acct_id;
            $mobile=$account->phone;
            $name=$account->name;
            $email=$account->email;
            $status='Activated'; 
            $message="Dear ".$name.","."YOUR AFPA General Trader's a/c ID -". PaymentHelper::bind_account_number($acct_id)." with KYC is " .$status.".";
            $data = array(
                'name'      =>  $name,
                'email' => $email,
                'message'   =>   $message
            );
    
            Mail::to($data['email'])->send(new VerificationMail($data));
            $approval_date=date('Y-m-d');
            $approval_date = date('Y-m-d', strtotime($approval_date)); 
            $month=date('m',strtotime($approval_date)); 
            $year=date('Y',strtotime($approval_date)); 
            DB::update("update accounts set status = 'Activated',account_activation_date='$approval_date' where acct_id=$id"); 
            Helper::send_sms($mobile,$message);
            PaymentHelper::save_to_subscription_payment($id,$month,$year);
            DB::commit();
            return redirect()->back()->with('status','Account Approved!!!');  
        }

        //Secondary account rejection

        public function rejectaccount(Request $request,$id)
        {
            DB::beginTransaction();
            $account=DB::select("select * from account where acct_id ='$id'");
            DB::update("update account set status = 'Deactivated',account_activation_date='' where acct_id=$id");
            DB::commit();
            return redirect()->back()->with('status','Account Rejected!!!');
        }


        //KYC status change back to normal after approval/rejection

        public function changekycstatus(Request $request,$id)
        {
            $kycs=DB::select("select * from kycs where id ='$id'");
            DB::update("update kycs set status = 'Pending',remarks='' where id=$id");
            return redirect()->back();
        }
    

        //Account status change back to normal after approval/rejection

        public function changeaccountstatus(Request $request,$id)
        {
            $account=DB::select("select * from accounts where acct_id ='$id'");
            DB::update("update accounts set status = 'requested',account_activation_date='' where acct_id=$id");
            return redirect()->back();
        }

        public function changeaccountstatustoapprove(Request $request,$id)
        {
            $approval_date=date('Y-m-d');
            $approval_date = date('Y-m-d', strtotime($approval_date)); 
            $accounts=Accounts::where('acct_id',$id)->first();
           // $account=DB::select("select * from accounts where acct_id ='$id'")->first();
            $type=$accounts->acct_type;
            $user_id=$accounts->fk_user_id;
            if($type='Primary')
            {
                DB::update("update users set user_status='Activated',blocked_at = null where id = $user_id");
                DB::update("update accounts set status = 'Activated',account_activation_date='$approval_date' where acct_id=$id");
               
            }
            elseif($type='Secondary')
            {
                DB::update("update accounts set status = 'Activated',account_activation_date='$approval_date' where acct_id=$id");
            
            }
            return redirect()->back();
        }


        //View all blocked users

        public function blockedusers()
        {
            $users=DB::select("select * from users where user_status ='Terminated'");
            return view('admin.blockedusers',['users'=>$users]);
        }


        //View all approved users

        public function approvedrequests(Request $request)
        {
            $drop_value = $request->input('search_type');
            $search_value = $request->input('search_text');

            if($drop_value =='name')
            {
                $users = DB::select("select * from users where name like '$search_value%' and  user_status ='Activated'");
                
            }

            elseif($drop_value =='account_id')
            {
                $users = DB::select("select * from users u join accounts a on(u.id=a.fk_user_id) where u.user_status ='Activated' and a.acct_id ='$search_value'");
                
        
            }
        
            else
            {
            $users=DB::select("select * from users where user_status ='Activated'");
            }
            return view('admin.approvedrequests',['users'=>$users]);
        }


        //View all rejected users

        public function rejectedrequests()
        {
            $users=DB::select("select * from users where user_status ='Deactivated'");
            return view('admin.rejectedrequests',['users'=>$users]);
        }


        //Block a user

        public function terminatecustomer($id)
        {
            DB::beginTransaction();
            $users=DB::select("select * from users where id =$id");
            DB::update("update users set user_status='Terminated',blocked_at = NOW() where id = $id");
            DB::update("update accounts set status='Cancelled' where fk_user_id = $id");
            DB::commit();
            return redirect()->back()->with('error','Account Blocked!!!');
        }


        //Unblock a user

        public function unblockcustomer($id)
        {
            $users=DB::select("select * from users where id =$id");
            DB::update("update users set user_status='Activated',blocked_at = null where id = $id");
            return redirect()->back()->with('status','Account Unblocked!!!');
        }


        //Delete a user

        public function deletecustomer($id)
        {
            DB::beginTransaction();
            $array=array();
            $result=array();
            $user1=User::find($id);
            $accounts=Accounts::where('fk_user_id',$id)->get();
            $accountflag=true;
            foreach($accounts as $account)
            {
                $acct_id=$account->acct_id;
                if($account->status != 'Activated')
                {
                    $accountflag = false;
                    break;
                }
            }
            if($accountflag==true)
            {
                $payment=SubscriptionPayment::where('fk_acct_id',$acct_id)->get();
                foreach($payment as $pay)
                {
                    $status=$pay->status;
                    if($status !='Paid')
                    {
                        return redirect()->back()->with('error',"There exist an active account where a payment data is found !!");
                    }
                }
            }
            else
            {
                $user1->delete();
            }
            $users=DB::select("select * from users where user_type != 'admin' and user_status='requested'");
            DB::commit();
            return view('admin.customerrequests',['users'=>$users]);
        }


        //Add remarks for kyc rejection

        public function updateremarks(Request $request,$id)
        {
            DB::beginTransaction();
            $kycs=DB::select("select * from kycs where id ='$id'");
            $remarks=$request->input('remarks');
            DB::update("update kycs set remarks = '$remarks', status = 'Deactivated'  where id='$id'");
            DB::commit();
            return redirect()->back()->with('status','KYC document rejected!!!');
        }


        //Add remarks for account rejection

        public function updateaccountremarks(Request $request,$id)
        {
            DB::beginTransaction();
            $account= DB::table('accounts')->where('acct_id',$id)
                ->join('users', 'users.id', '=','accounts.fk_user_id')
                ->select('accounts.*', 'users.*')->first();
            $acct_id=$account->acct_id;
            $mobile=$account->phone;
            $name=$account->name;
            $email=$account->email;
            $status='Rejected'; 
            $message="Dear ".$name.","."YOUR AFPA General Trader's a/c ID -". PaymentHelper::bind_account_number($acct_id)." with KYC is " .$status.". Please contact administrator for further details !";
            $data = array(
                'name'      =>  $name,
                'email' => $email,
                'message'   =>   $message
                );
            Mail::to($data['email'])->send(new VerificationMail($data));
            $remarks=$request->input('remarks1');
            DB::update("update accounts set remarks = '$remarks', status = 'Deactivated'  where acct_id='$id'");
            DB::commit();
            return redirect()->back()->with('status','Account Rejected!!!'); 
    }

    //Change Password view

    public function admin_change_password(Request $request)
    {
        return view('admin.admin_change_password');
    }

    //Change password action

    public function admin_change_password_action(Request $request)
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


    //Admin viewing commission requests

    public function admin_commission_request_view()
    {
        $commission_requests=DB::table('commission_requests')->where('status', 'Requested')->get();
        return view('admin.admin_commission_requests',compact('commission_requests'));
    }

    //Detailed view of each commission requests

    public function commission_detailed_view($id)
    {
        $userarray=array();
        $result=array();
        $commission_requests=CommissionRequests::where('request_id',$id)->get();
        if ($commission_requests->isEmpty()) 
        {
            return abort(404);
        }
        foreach($commission_requests as $requests)
        {
            $user_id=$requests->fk_user_id;
            $remark=$requests->remarks;
        }
        $users=User::where('id',$user_id)->get();
        if ($commission_requests->isEmpty() && $users->isEmpty()) 
        {
            return abort(401);
        }
        $total_wallet_balance=PaymentHelper::getCurrentWalletBalance($user_id);
        return view('admin.commission_detailed_view', compact("total_wallet_balance","users","remark","commission_requests")); 
    }


    //Approving commission requests

    public function approve_commission_request($id)
    {
        DB::beginTransaction();
        DB::update("update commission_requests set status = 'Approved' where request_id=$id"); 
        DB::commit();
        return redirect()->back()->with('status','Commission Request Approved!!!');
    }


    //Rejection remarks

    public function reject_commission_remarks(Request $request,$id)
    {
        DB::beginTransaction();
        $remarks=$request->input('reason');
        DB::update("update commission_requests set remarks = '$remarks',status = 'Rejected'  where request_id=$id"); 
        DB::commit();
        return redirect()->back()->with('status','Commission Request Rejected!!!');
    }


    //Reject commission requests

    public function reject_commission_request(Request $request,$id)
    {
        DB::beginTransaction();
        DB::update("update commission_requests set status = 'Rejected' where request_id=$id"); 
        DB::commit();
        return redirect()->back()->with('status','Commission Request Rejected!!!');
    }


    //Changing commission status after approval/rejection

    public function changecommissionstatus(Request $request,$id)
    {
        DB::update("update commission_requests set status = 'Requested',remarks='' where request_id=$id");
        return redirect()->back();
    }


    //Admin viewing approved commission requests

    public function approved_commission_requests()
    {
        DB::beginTransaction();
        $requests=DB::table('commission_requests')->where('status','Approved')
        ->join('users', 'users.id', '=', 'commission_requests.fk_user_id')->get();
        
        DB::commit();
        return view("admin.approved_commission_requests",compact("requests"));
    }


    //Commission payment confirmation page

    public function commission_payment_confirmation(Request $request)
    {
        $this->validate($request, [
            'total' => ['required'],
            
        ]);
      
        $request_select[] = $request->input('request_select');
        foreach ($request_select as $req) 
        {
            $req_ids=$req;
            $newData = implode(",",$req_ids);
        }
        $total = $request->input('total');
        $commission_requests=DB::table('commission_requests')->whereIn('request_id',$req_ids)
        ->join('users', 'users.id', '=', 'commission_requests.fk_user_id')->get();
        
        $totals=0;
        foreach($commission_requests as $commission)
        {
            $user_id=$commission->fk_user_id;
            $amount=$commission->amount;
            $totals += $amount;
            $users=User::where('id',$user_id)->get();
            foreach($users as $user)
            {
                $name=$user->name;
            }
        }
        
        Session::put('commission_details', ['id' => $newData, 'totals' => $totals,'req_id' => $req_ids,'request_select' => $request_select]);
        $commission_data=Session::get('commission_details');
        return view('admin.commission_payment_confirmation',compact('commission_data','commission_requests','users','name'));
    }

    
    //Commission Payments

    public function commission_payment()
    {
        DB::beginTransaction();
        $commission_data=Session::get('commission_details');
        $req_ids=$commission_data['req_id'];
        $commission_requests=CommissionRequests::whereIn('request_id',$req_ids)->get();
       foreach($commission_requests as $req)
       {
           $request_id=$req->request_id;
            $user_id=$req->fk_user_id;
            $amount=$req->amount;
            $wallet=WalletTransaction::where('fk_user_id', $user_id)->get();
            foreach($wallet as $wal)
            {
            $wallet_amount=$wal->amount;
            
            }
            $balance=$amount;

            $wallet= new WalletTransaction();
            $wallet->id=PaymentHelper::generate_wallet_id();
            $wallet->fk_user_id=$user_id;
            $wallet->amount=$balance;
            $wallet->date=date('Y-m-d');
            $wallet->type="Debit";
            $wallet->remarks="Debited based on Commission request";
            $wallet->status="Paid";
            $wallet->save();

            $tds_amount=(5/100)*$amount;
            $commission= new CommissionPayments();
            $commission->fk_request_id=$request_id;
            $commission->amount=$amount;
            $commission->tds_percentage="5";
            $commission->tds_amount=$tds_amount;
            $commission->total=$commission->amount-$commission->tds_amount;
            $commission->reference_no="0";
            $commission->date=date('Y-m-d');
            $commission->fk_wallet_id=$wallet->id;
            $commission->status="Transferred";
            $commission->save();

            DB::update("update commission_requests set status = 'Transferred' where request_id=$request_id");

       }
       $requests=DB::table('commission_requests')->where('status','Approved')->get();
       DB::commit();
       return redirect('/approved_commission_requests')->with('status',"Payment Successfull !!!");
    
    }

    //Updating KYC details

	public function adminupdateuploadedkyc(Request $request,$id)
    {
		$acct_id=session('acct_id');
        $kyc=Kyc::find($id);
		$kyc->type=$request->input('type');
		if ($kyc->type=="Aadhar Card Details") {
			$kyc->identification_number=$request->input('aadhar_identification_number');
			$attributes=[
				'aadhar_identification_number' => 'Aadhar number',];
			$request->validate([
			'aadhar_identification_number' =>'required|unique:kycs,identification_number|regex:/(^[2-9]{1}[0-9]{3}\\s[0-9]{4}\\s[0-9]{4}$)/u',
		  ],[],$attributes);
		  }

		  if($kyc->type=="Pan Card Details") {
			$kyc->identification_number=$request->input('pan_identification_number');
			$attributes=[
				'pan_identification_number' => 'PAN number',];
			$request->validate([
			'pan_identification_number' =>'required|unique:kycs,identification_number|regex:/([A-Z]{5}[0-9]{4}[A-Z]{1})/u',
		  ],[],$attributes);
		  }

		  if($kyc->type=="Bank Details") {
			$kyc->identification_number=$request->input('bank_identification_number');
			$attributes=[
				'bank_identification_number' => 'Account number',
				];
			$request->validate([
			'bank_identification_number' =>'required|unique:kycs,identification_number|regex:/(^\d{9,18}$)/u',
		  ],[],$attributes);
		  }

		  if($kyc->type=="Cancelled Cheque / Passbook FrontPage"){
			$kyc->identification_number=$request->input('identification_number');
			$attributes=[
				'identification_number' => 'Cheque number',];
			$request->validate([
				'identification_number' =>'required|unique:kycs,identification_number',
			  ],[],$attributes);
		  }
        $kyc->status="Activated";
		$kyc->save();
        return redirect()->back()->with('status', 'Data updated successfully !!!');
    }
    
    //Commission report view

    public function admin_commission_report_view()
    {
        return view('reports.commission_report');
    }

    //Payment report view
    public function admin_payment_report_view()
    {
        return view('reports.payment_report');
    }

    //Payment report action

    public function payment_report(Request $request)
    {
        $start_date=$request->input('start_date');
        $end_date=$request->input('end_date');
        DB::enableQueryLog();
        
        $transactions=Transactions::whereBetween('date',[$start_date, $end_date])
        ->join('users', 'users.id', '=', 'transactions.fk_user_id')
        ->get();
        $results=array();
        $final=array();
        $info=array();
        foreach($transactions as $trans)
        { 
            $info['transaction_id']=$trans->transaction_id;
            $info['user_id']=$trans->fk_user_id;
            $info['invoice_number']=$trans->invoice_number;
            $info['subscription_fee']=$trans->subscription_fee;
            $info['date']=$trans->date;
            $info['sgst']=($trans->sgst/100)* $info['subscription_fee'];
            $info['cgst']=($trans->cgst/100)* $info['subscription_fee'];
            $info['gst']=$trans->gst;
            $info['cess']=($trans->cess/100)* $info['subscription_fee'];
            $info['amount']=$trans->amount;
            $info['user_name']=$trans->name; 
            $info['address']=$trans->address; 
            $info['phone']=$trans->phone;
            $info['email']=$trans->email;  
            $results[]=$info;       
        }
       
        return view('/reports.payment_report_view',compact('transactions','results','start_date','end_date'));    
        
    }

    //Commission report action

    public function commission_report(Request $request)
    {
        $start_date=$request->input('start_date');
        $end_date=$request->input('end_date');
        $results=array();
        $info=array();
        $commissions=CommissionPayments::whereBetween('date',[$start_date, $end_date])->get();
        foreach($commissions as $comm)
        { 
            $info['id']=$comm->id;
            $info['request_id']=$comm->fk_request_id;
            $info['amount']=$comm->amount;
            $info['tds_percentage']=$comm->tds_percentage;
            $info['tds_amount']=$comm->tds_amount;
            $info['total']=$comm->total;
            $info['date']=$comm->date;

            $requests=CommissionRequests::where('request_id',$info['request_id'])
            ->join('users', 'users.id', '=', 'commission_requests.fk_user_id')
            ->get();
            foreach($requests as $req)
            {
                $info['user_name']=$req->name;
                $info['user_address']=$req->address;
                $info['email']=$req->email;
                $info['phone']=$req->phone;
             
            }  

            $results[]=$info;
                
        } 
        
        return view('/reports.commission_report_view',compact('commissions','results','start_date','end_date'));
    }


    public function subscription_payment_reports(Request $request,$id)
    {
        $start_date=$request->input('start_date');
        $end_date=$request->input('end_date');
        $transactions=Transactions::whereBetween('date',[$start_date, $end_date])
        ->where('fk_user_id',$id)->where('status','Paid')
        ->get();
        
        $results=array();
        $info=array();
        $user_array=array();
        $user = User::whereId($id)->first();
        foreach($transactions as $trans)
        { 
            $info['transaction_id']=$trans->transaction_id;
            $info['user_id']=$trans->fk_user_id;
            $info['invoice_number']=$trans->invoice_number;
            $info['subscription_fee']=$trans->subscription_fee;
            $info['date']=$trans->date;
            $info['sgst']=($trans->sgst/100)* $info['subscription_fee'];
            $info['cgst']=($trans->cgst/100)* $info['subscription_fee'];
            $info['gst']=$trans->gst;
            $info['cess']=($trans->cess/100)* $info['subscription_fee'];
            $info['amount']=$trans->amount;
            $results[]=$info;   
               
        }
        $user_array['user']=$user;      
        
        return view('/reports.subscription_payment_reports',compact('transactions','results','user_array','start_date','end_date'));    
        
    }


    //View transferred commission details

    public function admin_approved_requests_view(Request $request)
    {
        $start_date=$request->input('start_date');
        $end_date=$request->input('end_date');
        $results=array();
        $info=array();
        
        $commission_payment=DB::table('commission_requests')
        ->where('status','Approved')
        ->whereBetween('date',[$start_date, $end_date])
        ->join('users', 'users.id', '=', 'commission_requests.fk_user_id')
        ->get();
        
        
        foreach($commission_payment as $payment)
        {
            $info['name']=$payment->name;
            $info['email']=$payment->email;
            $info['phone']=$payment->phone;
            $info['acct_no']=$payment->acct_no;
            $info['amount']=$payment->amount;
            $info['date']=$payment->date;
            $info['tds_percentage']=5;
            $info['tds_amount']=($info['tds_percentage']/100)*$info['amount'];
            $info['total']=$info['amount'] - $info['tds_amount'];
            $data[]=$info;
        }
        if ( $commission_payment->isEmpty() ) {
            return abort(404);
          }
        else
        {
            $results['commission_payment']=$data;
            //$results['commission_payment']=$commission_payment;

        $acct_id=session('acct_id');
        //dd($results);
        return view('admin.admin_approved_requests_view',compact('commission_payment','acct_id','results','start_date','end_date'));
        }
    }

    public function admin_payment_history()
    {
        $transactions=Transactions::all();
        return view('admin.admin_payment_history', compact("transactions"));
    }

    public function admin_viewreceipt_byid($id)
    {
        $transaction=Transactions::where('transaction_id',$id)->first();
         $user_id=$transaction->fk_user_id;
         $results=array();
         $user = User::whereId($user_id)->first();
         $transactions=Transactions::where('transaction_id',$id)->where('fk_user_id',$user_id)->get()->first();
         if($transaction==null)
         {
             return abort(401);
         }
         else
         {
         $subscriptions=DB::select("select * from subscription_payments where fk_transaction_id='$id'");
         foreach($subscriptions as $subscription)
         {
             $trans_id=$subscription->fk_transaction_id;
         }
         $account=InvoicesController::getDistinctAccountByTraniD($trans_id);
         $results['account']=$account;
         $results['user']=$user;
         $results['transaction']=$transactions;
        return view('/invoices.viewreceipt_byid',compact('results'));
    }
        
    }

    public function adminaddmorekycimage(Request $request,$id)
    {
        $request->validate([
			'path' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
			
			]);
		$kycs=Kyc::find($id);
		$imagepath=json_decode($kycs->path);
		
		if ($request->hasfile('path'))
    	{
			$uploaded_image=$request->file('path');
    		$name=time().$uploaded_image->getClientOriginalName();
    		$uploaded_image->move('uploads/kyc/',$name);
			array_push($imagepath,$name);
			$kycs->path=json_encode($imagepath);
			
    	}		
		$kycs->save();
		if($kycs==null)
		{
			return abort(404);
		}
		else
		{
			return redirect()->back()->with('status', 'Document added successfully !!!');
		}
	}

//Delete KYC documents
public function admindeletekycimage($id,$name)
{
    
    $kyc=Kyc::find($id);
    $imagepath=json_decode($kyc->path);
    if (($key = array_search($name, $imagepath)) !== false)
    {
    unset($imagepath[$key]);
    }
    $values=array_values($imagepath);
    $kyc->path=json_encode($values);
    $kyc->save();
    return redirect()->back()->with('error', 'Document deleted !!!');
}

public function admincancelaccount($id)
    {
        $accounts=Accounts::where('acct_id',$id)->first();
        $users=$accounts->fk_user_id;
        $accountview=DB::select("update accounts set status='Cancelled' where fk_user_id='$users' and acct_id='$id'");
        return redirect()->back()->with('error','Account cancelled successfully');
    }
}
