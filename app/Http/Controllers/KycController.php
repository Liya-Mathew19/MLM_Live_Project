<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kyc;
use App\Models\ProfileCompletion;
use Auth;
use DB;

class KycController extends Controller
{
	public function __construct()
    {   
        $this->middleware('user');
    }
	//Saving KYC data

    public function storekyc(Request $request)
    {
		DB::beginTransaction();
		$acct_id=session('acct_id');
        $kyc=new Kyc();
        $kyc->fk_user_id=$request->input('id');
		$kyc->type=$request->input('type');
		$kyc->path=array();
		if ($kyc->type=="Aadhar Card Details") {
			$kyc->identification_number=$request->input('aadhar_identification_number');
			$attributes=[
				'aadhar_identification_number' => 'Aadhar number',
				'path'=>'Image'];
			$request->validate([
			'aadhar_identification_number' =>'required|unique:kycs,identification_number|regex:/(^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$)/u',
			'path.*' => 'required|mimes:txt,xlx,xls,pdf,jpg,jpeg,png|max:2048',
		  ],[],$attributes);
		  }

		  if($kyc->type=="Pan Card Details") {
			$kyc->identification_number=$request->input('pan_identification_number');
			$attributes=[
				'pan_identification_number' => 'PAN number',
				'path'=>'Image'];
			$request->validate([
			'pan_identification_number' =>'required|unique:kycs,identification_number|regex:/([A-Z]{5}[0-9]{4}[A-Z]{1})/u',
			'path.*' => 'required|mimes:txt,xlx,xls,pdf,jpg,jpeg,png|max:2048',
		  ],[],$attributes);
		  }

		  if($kyc->type=="Bank Details") {
			$kyc->identification_number=$request->input('bank_identification_number');
			$attributes=[
				'bank_identification_number' => 'Account number',
				'path'=>'Image'];
			$request->validate([
			'bank_identification_number' =>'required|unique:kycs,identification_number|regex:/(^\d{9,18}$)/u',
			'path.*' => 'required|mimes:txt,xlx,xls,pdf,jpg,jpeg,png|max:2048',
		  ],[],$attributes);
		  }

		  if($kyc->type=="Cancelled Cheque / Passbook FrontPage"){
			$kyc->identification_number=$request->input('identification_number');
			$attributes=[
				'identification_number' => 'Cheque number',
				'path'=>'Image'];
			$request->validate([
				'identification_number' =>'required|unique:kycs,identification_number',
				'path.*' => 'required|mimes:txt,xlx,xls,pdf,jpg,jpeg,png|max:2048',
			  ],[],$attributes);
		  }

		$kyc->status="Pending";
		
    	if ($request->hasfile('path'))
    	{
			foreach($request->file('path') as $image)
            {
    		$name=time().$image->getClientOriginalName();
    		$image->move('uploads/kyc/',$name);
			$data=$name;
			}
    	}
		else
		{
    		$kyc->path='';
		}
		$myArr = $kyc->path;
        array_push($myArr,$data);
		$kyc->path=json_encode($myArr);
		
		if (Kyc::where([['fk_user_id',"=",Auth::user()->id],['type', '=', $kyc->type]])->exists()) 
		{
			return redirect('customerprofile')->with('error', 'Already uploaded!!!');
		}
		
		else
		{
		$kyc->save();
		
		$profile=ProfileCompletion::where([['fk_user_id',"=",Auth::user()->id]])->get();
        foreach ($profile as $p)
        {
			$p= $p->percentage;
			if($kyc->type=="Aadhar Card Details")
			{
				DB::table('profile_completions')->where([['fk_user_id',"=",Auth::user()->id ]])->update(['percentage' => $p+10]);
			}
			elseif($kyc->type=="Pan Card Details")
			{
				DB::table('profile_completions')->where([['fk_user_id',"=",Auth::user()->id ]])->update(['percentage' => $p+10]);
			}
			elseif($kyc->type=="Bank Details")
			{
				DB::table('profile_completions')->where([['fk_user_id',"=",Auth::user()->id ]])->update(['percentage' => $p+10]);
			}
			elseif($kyc->type=="Cancelled Cheque / Passbook FrontPage")
			{
				DB::table('profile_completions')->where([['fk_user_id',"=",Auth::user()->id ]])->update(['percentage' => $p+10]);
			}
		}
		DB::commit();
		return redirect('customerprofile')->with('status', 'Data updated successfully !!!');	
	}     
	}


	//Updating KYC details

	public function updateuploadedkyc(Request $request,$id)
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
        $kyc->status="Pending";
		$kyc->save();
        return redirect('customerprofile')->with('status', 'Data updated successfully !!!');
	}


	//Editing uploaded KYC

	public function edituploadedkyc($id)
    {
		$acct_id=session('acct_id');
		$kycs=Kyc::find($id);
		if($kycs==null)
		{
			return abort(404);
		}
		elseif($kycs->fk_user_id != Auth::user()->id)
		{
			return abort(401);
		}
		else
		{
		return view('user.edituploadedkyc',compact("kycs","acct_id"));
		}
	}
	


	//Editing uploaded kyc image page view

	public function editkycimage($id)
    {
		$acct_id=session('acct_id');
		$kycs=Kyc::find($id);
		if($kycs==null)
		{
			return abort(404);
		}
		elseif($kycs->fk_user_id != Auth::user()->id)
		{
			return abort(401);
		}
		else{
		return view('user.editkycimage',compact("kycs","acct_id"));
		}
	}

	
	//Updating image actions

	public function updatekycimage(Request $request,$id)
    {
		$acct_id=session('acct_id');
		$request->validate([
			'path' => 'required|mimes:csv,txt,xlx,xls,pdf,jpg,jpeg,png|max:2048',
			
			]);
		$kycs=Kyc::find($id);
		
		if ($request->hasfile('path'))
    	{
    		$file=$request->file('path');
    		$extension=$file->getClientOriginalExtension();
    		$filename=time(). '.' . $extension;
    		$file->move('uploads/kyc/',$filename);
    		$kycs->path=$filename;

    	}
    	else{
    		$kycs->path='';
		}
		$kycs->save();
		if($kycs==null)
		{
			return abort(404);
		}
		elseif($kycs->fk_user_id != Auth::user()->id)
		{
			return abort(401);
		}
		else
		{
			return redirect('customerprofile')->with('status', 'Document updated successfully !!!');
		}
	}

//Add more kyc documents

	public function addmorekycimage(Request $request,$id)
    {
		$request->validate([
			'path' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
			
			]);
		$acct_id=session('acct_id');
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
		elseif($kycs->fk_user_id != Auth::user()->id)
		{
			return abort(401);
		}
		else
		{
			return redirect()->back()->with('status', 'Document added successfully !!!');
		}
	}
	
//Delete KYC documents
	public function deletekycimage($id,$name)
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
		return redirect('customerprofile')->with('error', 'Document deleted !!!');
	}


	}

	
	
