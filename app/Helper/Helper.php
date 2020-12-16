<?php
namespace App\Helper;
use Auth;
use DB;
use App\Models\Accounts;
use Request;

class Helper
{

    //Mask the secondary password

    public static function maskpassword($number)
    {
        $mask_number =  str_repeat("*", strlen($number)-2) . substr($number, -2);
        return $mask_number;
    }

    //Set route active on navigation

    public static function set_active( $route ) {
        if( is_array( $route ) ){
            return in_array(Request::path(), $route) ? 'active' : '';
        }
        return Request::path() == $route ? 'active' : '';
    }


    //Get the primary account

    public static function get_primary_account()
    {
        $userid=Auth::user()->id;
        if($userid==null)
        {
            return abort(404);
        }
        $accounts=DB::select("select * from accounts where fk_user_id='$userid' and acct_type='Primary'");
        foreach($accounts as $acct)
        {
            $acct_id=$acct->acct_id;
        }
        return $acct_id;
    }

    //Get all accounts of logged in user

    public static function get_user_accounts()
    {
        $userid=Auth::user()->id;
        $accounts=DB::select("select * from accounts where fk_user_id='$userid'");
    }

    //Get current account

    public static function get_current_account()
    {
        $ci = Accounts::all();
        $userid=Auth::user()->id;
        $accounts=DB::select("select * from accounts where fk_user_id='$userid'");
        $acct_id = session('$acct_id');
    }


    //Get child accounts

    public static function get_children($parent_id)
    {
       
        $tree = Accounts::where('fk_parent_id', $parent_id)->pluck('acct_id')->toArray();
        foreach ($tree as $val) 
        {
            $ids = static::get_children($val);
        }
        return $tree;
    }


    //Send SMS
    public static function send_sms($mobile,$message)
    {
        $api_key = '55F85D4F14DBD8';
        $contacts = $mobile;
        $from = 'AFPAGT';
        $sms_text = urlencode($message);
        $api_url = "http://msg.pwasms.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=9&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text;
        echo $api_url;
        //Submit to server
        $response = file_get_contents( $api_url);
        return $response;
    }


    //Generate Invoice Number

    public static function generate_account_number()
    {
        $start="202001";
        $account_number=DB::select(DB::raw("select * from accounts where acct_id =
        (SELECT max(acct_id) FROM accounts where status !='Terminated') "));
        
        foreach($account_number as $acct)
        {
            $max_acct=$acct->acct_id;
        }
        if(empty($account_number))
        {
            return $start;
        }
        else
        {
            $max_acct = $max_acct+1;
            return $max_acct;
        }
    }

    //Set a limit for level

    public static function get_level_limit()
    {
        $limit=10;
        return $limit;
    }
}