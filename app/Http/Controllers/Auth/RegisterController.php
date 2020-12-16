<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Accounts;
use App\Models\WalletTransaction;
use App\Models\ProfileCompletion;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Http\Request;
use App\Helper\PaymentHelper;
use App\Helper\Helper;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function parentID()
    {
        return 1;
    }

    public function new_register($id)
    {
        $data = \Crypt::decrypt($id);
        $account_info=Accounts::where('acct_id',$data)->first();
        if($account_info->status=='Terminated')
        {   
              return abort(404);  
        }
        else
        {
            return view('auth.new_register',compact('data','id'));
        }
    }

    
    public function personal_register(Request $data)
    {
        $this->validate($data, [
            'name' => ['required', 'string', 'min:2','max:255','regex:/^[\pL\s\-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required','numeric','digits:10','unique:users,phone'], 
            'password' => ['required', 'string', 'min:4', 'confirmed'], 
            'referral_id' => ['nullable','exists:App\Models\Accounts,acct_id' ],
            'spill_over_id' => ['nullable','exists:App\Models\Accounts,acct_id'],
        ]);

            DB::beginTransaction();
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->country_code = "+91";
            $user->phone = $data['phone'];
            $user->password = Hash::make($data['password']);
            $user->confirm_password = Hash::make($data['password_confirmation']);
            $user->income = 0;
            $user->phone_status = "Progress";
            $user->email_status = "Progress";
            $user->user_status = 'Progress';
            $user->gstin = "";
            $user->type="Personal";
            $user->user_type ='User';
            $user->approval_status_notification ='No';
            $user->save();

            // session('ptype','Personal');
            // $ptype=session('ptype');

            $profile=new ProfileCompletion();
            $profile->fk_user_id=$user->id;
            $profile->percentage=20;
            $profile->save();
			
			if($data['spill_over_id']==null){
				$data['spill_over_id']=$data['referral_id'];
			}
			 
			$accountcount=PaymentHelper::getParentID($data['spill_over_id']);
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
             }
             else
             {
				 $referral_id = $data['referral_id'];
				$spill_over_id= $accountcount->acct_id;
				 $level=$accountcount->position;
				 $parentnode_id=$accountcount->node_id;
				 
				  $nextlevel =$level +1;
				 $nodecount = Accounts::Where('position','=', $nextlevel)
				 ->Where('node_id','like', $parentnode_id.'%')
				 ->count()+1; 
				  
				 $node_id = $parentnode_id.$nodecount;
				 
				 $level=$nextlevel;
			 }
            $account=new Accounts();
            $account->acct_id=Helper::generate_account_number();
            $account->fk_user_id=$user->id;
            
            $account->fk_referral_id=$referral_id;
            $account->fk_parent_id= $spill_over_id;
			
            $account->position=$level;
            $account->node_id=$node_id;
			
			$account->N1=0;
			$account->N2=0;
			$account->N3=0;
			$account->N4=0;
			 
			$account->acct_type="Primary";
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
           return redirect('/login')->with('message', 'Registered successfully, please login...!');
        }

        public function corporate_register(Request $data)
        {
            $attributes=[
                'corporate_name' => 'name',
                'corporate_email' => 'email',
                'corporate_phone' => 'phone',
                'corporate_password'=>'password',
                'corporate_gstin'=>'gstin',
                'corporate_referral_id' =>'referral_id',
                'corporate_spill_over_id' =>'spill_over_id',];

            $this->validate($data, [
            'corporate_name' => ['required', 'string', 'min:2','max:255','regex:/^[\pL\s\-]+$/u'],
            'corporate_email' => ['required', 'string', 'email', 'max:255','unique:users,email'],
            'corporate_phone' => ['required','numeric','digits:10','unique:users,phone'], 
            'corporate_password' => ['required', 'string', 'min:4', 'confirmed'],  
            'corporate_gstin' =>['required','regex:/^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/'],
            'corporate_referral_id'=> ['nullable','exists:App\Models\Accounts,acct_id'],
            'corporate_spill_over_id'=>['nullable','exists:App\Models\Accounts,acct_id']],[],$attributes);
 
            DB::beginTransaction();
            $user = new User();
            $user->name = $data['corporate_name'];
            $user->email = $data['corporate_email'];
            $user->country_code = "+91";
            $user->phone = $data['corporate_phone'];
            $user->password = Hash::make($data['corporate_password']);
            $user->confirm_password = Hash::make($data['corporate_password_confirmation']);
            $user->income = 0;
            $user->phone_status = "Progress";
            $user->email_status = "Progress";
            $user->user_status = 'Progress';
            $user->gstin = $data['corporate_gstin'];
            $user->type="Corporate"; 
            $user->user_type ='User';
            $user->approval_status_notification ='No';
            $user->save();
            // session('ctype','Personal');
            // $ctype=session('ctype');

            $profile=new ProfileCompletion();
            $profile->fk_user_id=$user->id;
            $profile->percentage=20;
            $profile->save();
    
            if($data['corporate_spill_over_id']==null){
				$data['corporate_spill_over_id']=$data['corporate_referral_id'];
			}
			$accountcount=PaymentHelper::getParentID($data['corporate_spill_over_id']);
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
				 $referral_id = $data['corporate_referral_id'];
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
            $account->fk_user_id=$user->id;
            
            $account->fk_referral_id=$referral_id;
            $account->fk_parent_id= $spill_over_id;
			
            $account->position=$level;
            $account->node_id=$node_id;
			
			$account->N1=0;
			 $account->N2=0;
			 $account->N3=0;
			 $account->N4=0;
			$account->acct_type="Primary";
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
            return redirect('/login')->with('message', 'Registered successfully, please login...!');
        }




        public function new_personal_register(Request $data,$id)
    {
        $id = \Crypt::decrypt($id);
        $account_info=Accounts::where('acct_id',$id)->first();
        $array['old_account_info']=$account_info;
        $arr[]=$array;
        if($account_info==null)
        {
            return abort(404);
        }        
         if($account_info->status=='Cancelled')
         {
        $this->validate($data, [
            'name' => ['required', 'string', 'min:2','max:255','regex:/^[\pL\s\-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required','numeric','digits:10','unique:users,phone'], 
            'password' => ['required', 'string', 'min:4', 'confirmed'], 
            'referral_id' => ['nullable','exists:App\Models\Accounts,acct_id' ],
            'spill_over_id' => ['nullable','exists:App\Models\Accounts,acct_id'],
        ]);

            DB::beginTransaction();
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->country_code = "+91";
            $user->phone = $data['phone'];
            $user->password = Hash::make($data['password']);
            $user->confirm_password = Hash::make($data['password_confirmation']);
            $user->income = 0;
            $user->phone_status = "Progress";
            $user->email_status = "Progress";
            $user->user_status = 'Progress';
            $user->gstin = "";
            $user->type="Personal";
            $user->user_type ='User';
            $user->approval_status_notification ='No';
            $user->save();
            $profile=new ProfileCompletion();
            $profile->fk_user_id=$user->id;
            $profile->percentage=20;
            $profile->save();
			
            if($data['spill_over_id']==null)
            {
				$data['spill_over_id']=$data['referral_id'];
			}
			 
			$accountcount=PaymentHelper::getParentID($data['spill_over_id']);
			$referral_id = null;
			$spill_over_id=null;
			$level=0;
			$node_id="";
			
            if($accountcount ==null)
            {
				$referral_id = null;
				$spill_over_id=null;
				$level =$level +1;
				$node_id = $level;
            }
            else
            {
			    $referral_id = $data['referral_id'];
				$spill_over_id= $accountcount->acct_id;
				$level=$accountcount->position;
				$parentnode_id=$accountcount->node_id; 
				$nextlevel =$level +1;
				$nodecount = Accounts::Where('position','=', $nextlevel)
				->Where('node_id','like', $parentnode_id.'%')
				->count()+1;   
				$node_id = $parentnode_id.$nodecount; 
				$level=$nextlevel;
             }
             $user_id=$array['old_account_info']->fk_user_id;
             $acct=$user_id.'00'.$id;
             
             DB::update("update accounts set acct_id = '$acct',fk_parent_id='',position=-1,node_id= -1,N1= '-1',N2= '-1',N3= '-1',N4= '-1',status='Terminated' where acct_id='$id'");
       
             
            $account=new Accounts();
            $account->acct_id=$id;
            $account->fk_user_id=$user->id;
            $account->fk_referral_id=$array['old_account_info']->fk_referral_id;
            $account->fk_parent_id= $array['old_account_info']->fk_parent_id;
            $account->position=$array['old_account_info']->position;
            $account->node_id=$array['old_account_info']->node_id;
			$account->N1=$array['old_account_info']->N1;
			$account->N2=$array['old_account_info']->N2;
			$account->N3=$array['old_account_info']->N3;
			$account->N4=$array['old_account_info']->N4;
			$account->acct_type="Primary";
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
        }
        else
        {
            return redirect('/login')->with('error', 'INVALID REGISTRATION LINK !!');
        }
            DB::commit();
           return redirect('/login')->with('message', 'Registered successfully, please login...!');
        }

        public function new_corporate_register(Request $data,$id)
        {
            $id = \Crypt::decrypt($id);
            $account_info=Accounts::where('acct_id',$id)->first();
            $array['old_account_info']=$account_info;
            $arr[]=$array;
            $attributes=[
                'corporate_name' => 'name',
                'corporate_email' => 'email',
                'corporate_phone' => 'phone',
                'corporate_password'=>'password',
                'corporate_gstin'=>'gstin',
                'corporate_referral_id' =>'referral_id',
                'corporate_spill_over_id' =>'spill_over_id',];

            $this->validate($data, [
            'corporate_name' => ['required', 'string', 'min:2','max:255','regex:/^[\pL\s\-]+$/u'],
            'corporate_email' => ['required', 'string', 'email', 'max:255','unique:users,email'],
            'corporate_phone' => ['required','numeric','digits:10','unique:users,phone'], 
            'corporate_password' => ['required', 'string', 'min:4', 'confirmed'],  
            'corporate_gstin' =>['required','regex:/^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/'],
            'corporate_referral_id'=> ['nullable','exists:App\Models\Accounts,acct_id'],
            'corporate_spill_over_id'=>['nullable','exists:App\Models\Accounts,acct_id']],[],$attributes);
 
            DB::beginTransaction();
            $user = new User();
            $user->name = $data['corporate_name'];
            $user->email = $data['corporate_email'];
            $user->country_code = "+91";
            $user->phone = $data['corporate_phone'];
            $user->password = Hash::make($data['corporate_password']);
            $user->confirm_password = Hash::make($data['corporate_password_confirmation']);
            $user->income = 0;
            $user->phone_status = "Progress";
            $user->email_status = "Progress";
            $user->user_status = 'Progress';
            $user->gstin = $data['corporate_gstin'];
            $user->type="Corporate"; 
            $user->user_type ='User';
            $user->approval_status_notification ='No';
            $user->save();
            // session('ctype','Personal');
            // $ctype=session('ctype');

            $profile=new ProfileCompletion();
            $profile->fk_user_id=$user->id;
            $profile->percentage=20;
            $profile->save();
    
            if($data['corporate_spill_over_id']==null){
				$data['corporate_spill_over_id']=$data['corporate_referral_id'];
			}
			$accountcount=PaymentHelper::getParentID($data['corporate_spill_over_id']);
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
				 $referral_id = $data['corporate_referral_id'];
				  $spill_over_id= $accountcount->acct_id;
				 $level=$accountcount->position;
				 $parentnode_id=$accountcount->node_id;
				 
				  $nextlevel =$level +1;
				 $nodecount = Accounts::Where('position','=', $nextlevel)->count()+1;
				  
				 $node_id = $parentnode_id.$nodecount;
				 
				 $level=$nextlevel;
             }
             $user_id=$array['old_account_info']->fk_user_id;
             $acct=$user_id.'00'.$id;
             
             DB::update("update accounts set acct_id = '$acct',fk_parent_id='',position=-1,node_id= -1,N1= '-1',N2= '-1',N3= '-1',N4= '-1',status='Terminated' where acct_id='$id'");
       
             
            $account=new Accounts();
            $account->acct_id=$id;
            $account->fk_user_id=$user->id;
            $account->fk_referral_id=$array['old_account_info']->fk_referral_id;
            $account->fk_parent_id= $array['old_account_info']->fk_parent_id;
            $account->position=$array['old_account_info']->position;
            $account->node_id=$array['old_account_info']->node_id;
			$account->N1=$array['old_account_info']->N1;
			$account->N2=$array['old_account_info']->N2;
			$account->N3=$array['old_account_info']->N3;
			$account->N4=$array['old_account_info']->N4;
			$account->acct_type="Primary";
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
            return redirect('/login')->with('message', 'Registered successfully, please login...!');
        }
}
        
       
       

   

