<?php
namespace App\Helper;
use Auth;
use DB;
use App\Models\Accounts;
use App\Models\Settings;
use App\Models\SubscriptionPayment;
use App\Http\Controllers\PaymentController;
use App\Models\CommissionPayments;
use Session;

class PaymentHelper
{

    //Get current date

    public static function get_current_date()
    {
        $currentDate = date('Y-m-d');
        $currentDate = date('Y-m-d', strtotime($currentDate)); 
        return $currentDate;
    }
    
    //Get the Settings amount [ Subscription Fee and GST],Calculate total fee
    public static function total_commission_earned(){
		return 0;
	}
	
	 public static function getParentID($parent_id){
		 // Retrieve a model by its primary key...
		$accountcount = Accounts::Where('status','!=', 'Deactivated')->count();
		 if($accountcount==0){
			 return null;
		 }else{
			 $account= Accounts::where('acct_id', $parent_id)->first();
			 if($account==null){
				 // fetch parent node
				 $account= Accounts::where('node_id', 1)->first(); // parent account(ROOT) have the NODE_ID=1
			 }
			 $node_id = $account->node_id;
			 $sql="select * from accounts where node_id like '$node_id%' and (  (N1=0) or (N2=0) or (N3=0) or (N4=0)   ) order by acct_id";
			 $accounts=DB::select($sql);
			  if(count($accounts)>0){
				
				  $account =$accounts[0];
			  }else{
				    var_dump($accounts);
				  // ERROR 
				  dd("CAN NOT PROCED. CONTACT ADMIN");
				  
			  }
				 
				 return $account;//XXXX 
			 
		 }
		//$settings=DB::select("select * from settings");
		return $accountcount;
	}
   
	
    public static function get_settings_amount()
        {
            $settings=DB::select("select * from settings");
            foreach($settings as $setting)
            {
                $settings_amount=$setting->subscription_fee;
                session(['settings_amount' => $settings_amount]);
                $cgst=$setting->cgst_amount;
                $sgst=$setting->sgst_amount;
                $gst=$cgst+$sgst;
                
                if(!empty(Auth::user()->gstin))
         {
            $cess=(0*$settings_amount)/100;
         }
         else
         {
            $cess=($setting->cess*$settings_amount)/100;
         }
                session(['gst' => $gst]);
                $gst_amount = ($settings_amount * $gst ) / 100;
                $amount=$settings_amount+$cess;
                $total_settings_amount =$settings_amount + $gst_amount+$cess;
            }
            return $total_settings_amount;
        }


    //Saving to Subscription Payments
    
    public static function save_to_subscription_fee($accounts,$amount,$trans_id)
    {
        $settings_amount=static::get_settings_amount();
        $balance = $amount;
        $subscription_data=Session::get('subscription_details');

       //loop through selected accounts

        foreach($accounts as $account)
        {
            //Check is balance amount >=subscription fee

            if($balance >= $settings_amount)
            {

                //Call to function get_progress_date() to check if data exists

                $progressdate=static::get_progress_date($account->acct_id);
                $balance = $balance - $settings_amount;

                if($progressdate==false)
                { 
                    //Call to function get_next_pay_date() to get the next month and year

                    $nextdate=static::get_next_pay_date($account->acct_id);

                    //Extract month and year from $nextdate

                    $month = date("m", strtotime($nextdate));
                    $year = date("Y", strtotime($nextdate));

                    //Insert a new data to subscription_payments table
                    $subscriptions=new SubscriptionPayment();
                    $subscriptions->fk_acct_id=$account->acct_id;
                    $subscriptions->subscription_fee= session('settings_amount');
                    $subscriptions->gst= session('gst');
                    $subscriptions->amount=$settings_amount;
                    $subscriptions->paid_date=date('Y-m-d');
                    $subscriptions->fk_transaction_id=$trans_id;
                    $subscriptions->month=$month;
                    $subscriptions->year=$year;
                    $subscriptions->status="Paid";
                    $subscriptions->save(); 
                
                }
                else
                {
                    //Extracting primary key from subscriptions[Progress date]

                    $id=$progressdate->id;

                    //update existing data based on id

                    $payments = SubscriptionPayment::find($id);
                    $payments->paid_date=date('Y-m-d');
                    $payments->fk_transaction_id=$trans_id;
                    $payments->status="Paid";
                    $payments->save();
                }    
            }
            else
            {
                break;
            }
 
        }
 
        if($balance >= $settings_amount)
        {
            static::save_to_subscription_fee($accounts,$balance,$trans_id);
        }
        else
        {
            return $balance;
        }
    }


    //Get the Joined Date

    public static function get_joinDate($acct_id)
    {
        $accounts=DB::select("select * from accounts where acct_id='$acct_id'");
        foreach($accounts as $account)
        {
            $joined_date=date('m', strtotime($account->created_at));
            return $joined_date;
        }
  
    }
     
    
    //Formatting currency value

    public static function currency($money)
    {
		return  number_format((float)$money, 2, '.', '');  // Outputs -> 105.00
    }   


    //Get Next Payment Month and Year

    public static function get_next_pay_date($acct_id)
    {
        $date=DB::select(DB::raw("select * from subscription_payments where subscription_payments.fk_acct_id = $acct_id and id =
        (SELECT max(id) FROM subscription_payments
                          WHERE subscription_payments.fk_acct_id = $acct_id
                        ) "));

        //Check if the $date value is empty   

        if(empty($date))
        {
            //Return the current date

            $join_date=date('Y-m-d');
            return $join_date;
        }
        else
        {
            //Current date
            $maximum_pay_date=date('Y-m-d');

            //Check if $date is more than 1
            if(count($date)>0)
            {
                //Generate new date by incrementing 1 to the date
                $date=$date[0];
                $month = $date->month;
                $year = $date->year;
                $custom_date=$year.'-'.$month.'-'.'01';
                $custom_date = strtotime($custom_date);
                $nextdate = date("Y-m-d", strtotime("+1 month", $custom_date));
                return $nextdate;   
            }    
        }
    }  


    //Get data which contains status=Progess based on acct_id

    public static function get_progress_date($acct_id)
    {
        $active_payments_Accounts=DB::select(DB::raw("select * from subscription_payments where fk_acct_id = $acct_id and status='Progress' and id =
        (SELECT max(id) FROM subscription_payments
                          WHERE subscription_payments.fk_acct_id = $acct_id and status='Progress'
                        )"));

        if(empty($active_payments_Accounts))
        {
            return false;
            
        }
        else
        {
            $maximum_pay_date=date('Y-m-d');
            if(count($active_payments_Accounts)>0)
            {
                $active_payments_Accounts=$active_payments_Accounts[0];
                return $active_payments_Accounts;
            }
            else
            {
                return false;
            }
           
             
        }
        
    }

     
    //Save to Subscription_payments table based on acct_id,month and year

    public static function save_to_subscription_payment($acct_id,$month,$year)
    {        
        
        $subscriptions=new SubscriptionPayment();
        $subscriptions->fk_acct_id=$acct_id;
        $subscriptions->subscription_fee= session('settings_amount');
        $subscriptions->gst= session('gst');
        $subscriptions->amount=static::get_settings_amount();
        $subscriptions->month=$month;
        $subscriptions->year=$year;
        $subscriptions->status="Progress";
        $subscriptions->save();  
    }


    //Checking if Subscription_payments based on id,month and year exists or not

    public static function isSubscriptionPaymentExists($acct_id,$month,$year)
    {
        $subscription=DB::select("select * from subscription_payments where fk_acct_id='$acct_id' and month='$month' and year='$year'");
        if(empty($subscription))
        {
            return false;
        }
        else
        {
            return true;
        }     
    }


    //Get accounts based on acct_id and activation date

    public static function initSubscriptionFee_byAccountID($acct_id,$activation_date)
    {
        $month = date('m', strtotime($activation_date));
        $year = date('Y', strtotime($activation_date));
        if(static::isSubscriptionPaymentExists($acct_id,$month,$year)==false)
        {
            static::save_to_subscription_payment($acct_id,$month,$year);
        }     
    } 
    
    
    //Convert the total amount in invoice to words

    public static function convert_amount_to_words($amount)
    {
        $number = $amount;
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'One', '2' => 'Two','3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
        '7' => 'Seven', '8' => 'Eight', '9' => 'Nine','10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve','13' => 'Thirteen', '14' => 'Fourteen',
        '15' => 'Tifteen', '16' => 'Sixteen', '17' => 'Seventeen','18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
        '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty','60' => 'Sixty', '70' => 'Seventy','80' => 'Eighty', '90' => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_1) 
        {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) 
            {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
            } 
            else 
                $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        if($point==0)
        {
            return $result . "Rupees  ";  
        }
        else
        {
            $points = ($point) ?
                "." . $words[$point / 10] . " " . 
                $words[$point = $point % 10] : '';
          
            return $result . "Rupees  " . $points . " Paise";
        }
    }


    //Appending AFPA as prefix
    public static function bind_account_number($account_id)
    {
        $account_prefix="AFPA-".$account_id;
        return $account_prefix;
    }


    //Generate Invoice Number

    public static function generate_invoice_number()
    {
        $start="001";
        $invoice_number=DB::select(DB::raw("select * from transactions where invoice_number =
        (SELECT max(invoice_number) FROM subscription_payments) "));
        foreach($invoice_number as $invoice)
        {
            $max_invoice=$invoice->invoice_number;
        }

        if(empty($invoice_number))
        {
            
            return $start;
        }
        else
        {
            $max_invoice = str_pad((int) $max_invoice+1, 3 ,"0",STR_PAD_LEFT);
            return $max_invoice;
        }
    }



    public static function generate_wallet_id()
    {
        $start="1";
        $wallet_id=DB::select(DB::raw("select * from wallet_transactions where id =
        (SELECT max(id) FROM wallet_transactions) "));
        foreach($wallet_id as $wallet)
        {
            $max_id=$wallet->id;
        }

        if(empty($wallet_id))
        {
            
            return $start;
        }
        else
        {
            $max_wallet_id = $max_id+1 ;
            return $max_wallet_id;
        }
    }


    //Converting the date to dd-mm-yyyy format

    public static function convert_date_format($date)
    {
        $date=date("d-m-Y", strtotime($date));
        return $date;
    }


    //Checking if Cess flag is enabled/not

    public static function isCessEnabled()
    {
        $settings=DB::select("select * from settings");
        foreach($settings as $setting)
        {
            $settings_cess_flag=$setting->cess_flag;
        }
        if($settings_cess_flag==1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    //Get current wallet balance

    public static function getCurrentWalletBalance($user_id)
    {
        $wallet=DB::select("select * from wallet_transactions where fk_user_id='$user_id'");
        $wallet_credit=DB::select("select sum(amount) as credit_amount from wallet_transactions where fk_user_id='$user_id' and type='Credit'");
        $wallet_debit=DB::select("select sum(amount) as debit_amount from wallet_transactions where fk_user_id='$user_id' and type='Debit'");
        foreach($wallet_credit as $credit)
        {
            $wcredit=$credit->credit_amount;
        }

        foreach($wallet_debit as $debit)
        {
            $wdebit=$debit->debit_amount;
        }
        $total_wallet_balance=$wcredit-$wdebit;
        return $total_wallet_balance;
    }

    public static function getTotalWithdrawals($user_id)
    {
        $total=0;
        $transferred_commission_requests=DB::table('commission_requests')->where('fk_user_id', $user_id)->where('status','Transferred')->get();
        foreach($transferred_commission_requests as $transferred)
        {
            $cash=$transferred->amount;
            $total += $cash;
            
        }
        return $total;
    }


    public static function generate_user_id($id)
    {
            $user_id = str_pad((int) $id, 4 ,"0",STR_PAD_LEFT);
            return $user_id;
        
    }

}