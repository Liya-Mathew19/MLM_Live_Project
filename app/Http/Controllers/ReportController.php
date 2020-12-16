<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\CommissionPayments;
use App\Models\CommissionRequests;
use App\Models\User;
use DB;
use Auth;

class ReportController extends Controller
{
    public function __construct()
    {   
        $this->middleware('user');
    }
    public function user_commission_report_view()
    {
        $acct_id=session('acct_id');
        return view('reports.user_commission_report_view',compact('acct_id'));
    }
    public function user_payment_report_view()
    {
        $acct_id=session('acct_id');
        return view('reports.user_payment_report_view',compact('acct_id'));
    }
    
    public function user_payment_report(Request $request)
    {
        $acct_id=session('acct_id');
        $id=Auth::user()->id;
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
        
        return view('/reports.user_payment_report',compact('transactions','results','user_array','start_date','end_date','acct_id'));    
        
    }


    public function user_commission_report(Request $request)
    {
        $acct_id=session('acct_id');
        $id=Auth::user()->id;
        $start_date=$request->input('start_date');
        $end_date=$request->input('end_date');
        $results=array();
        $info=array();
        $user_array=array();
        $user = User::whereId($id)->first();
        $requests=CommissionRequests::where('fk_user_id',$id)->get();
        foreach($requests as $req)
        {
            $req_id=$req->request_id;
            $commissions=CommissionPayments::whereBetween('date',[$start_date, $end_date])->where('fk_request_id',$req_id)->get();
            foreach($commissions as $comm)
            { 
                $info['id']=$comm->id;
                $info['request_id']=$comm->fk_request_id;
                $info['amount']=$comm->amount;
                $info['tds_percentage']=$comm->tds_percentage;
                $info['tds_amount']=$comm->tds_amount;
                $info['total']=$comm->total;
                $info['date']=$comm->date;
                $results[]=$info;    
            } 
        }
        $user_array['user']=$user;   
        return view('/reports.user_commission_report',compact('results','start_date','end_date','user_array','acct_id'));
    }




   
}
