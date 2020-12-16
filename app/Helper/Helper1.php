<?php
namespace App\Helper;
use Auth;
use DB;
use App\Models\Accounts;
use Request;

class Helper
{

    public static function set_active( $route ) {
        if( is_array( $route ) ){
            return in_array(Request::path(), $route) ? 'active' : '';
        }
        return Request::path() == $route ? 'active' : '';
    }


    public static function get_primary_account()
    {
        $userid=Auth::user()->id;
        $accounts=DB::select("select * from accounts where fk_user_id='$userid' and acct_type='Primary'");
        foreach($accounts as $acct)
        {
            $acct_id=$acct->acct_id;
        }
        return $acct_id;
    }

    public static function get_user_accounts()
    {
        $userid=Auth::user()->id;
        $accounts=DB::select("select * from accounts where fk_user_id='$userid'");
    }

    public static function get_current_account()
    {
        $ci = Accounts::all();
        $userid=Auth::user()->id;
        $accounts=DB::select("select * from accounts where fk_user_id='$userid'");
        $acct_id = session('$acct_id');
    }


    
    public static function get_children($parent_id)
    {
       
        $tree = Accounts::where('fk_parent_id', $parent_id)->pluck('acct_id')->toArray();
        foreach ($tree as $val) 
        {
            $ids = static::get_children($val);
        }
    
    
    return $tree;
    }


public static function send_sms($mobile,$message)
{
    $api_key = '55F85D4F14DBD8';
$contacts = $mobile;
$from = 'AFPAGT';
$sms_text = urlencode($message);

$api_url = "http://msg.pwasms.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=51&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text;
echo $api_url;
//Submit to server

$response = file_get_contents( $api_url);
return $response;
}
}