<?php

namespace App\Http\Controllers;
use App\Models\Enquires;
use App\Mail\EnquiryMail;
use Mail;

use Illuminate\Http\Request;

class EnquiresController extends Controller
{
    public function enquiry(Request $request)
    {
        
        $enquiry=new Enquires();
        $enquiry->name=$request->input('name');
        $enquiry->email=$request->input('email');
        $enquiry->subject=$request->input('subject');
        $enquiry->message=$request->input('message');
        $enquiry->reply="";
        $enquiry->status="Send";
        $enquiry->save();
        return redirect('/#contact')->with('status','Message sent successfully !!');

    }

    
    public function terms_of_service()
    {
        return view('terms_of_service');
    }

    public function privacy_policy()
    {
        return view('privacy_policy');
    }
}
