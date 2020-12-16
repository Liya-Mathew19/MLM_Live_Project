<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Initial routes with no authorizations
Route::get('/get_active_accounts/{id}', [App\Http\Controllers\GenerateSubscriptionFee::class, 'get_active_accounts'])->name('get_active_accounts');
Route::get('/get_grand_total/{id}', [App\Http\Controllers\GenerateSubscriptionFee::class, 'get_grand_total'])->name('get_grand_total');
Route::get('/initSubscriptionFee_sample', [App\Http\Controllers\GenerateSubscriptionFee::class, 'initSubscriptionFee_sample'])->name('initSubscriptionFee_sample');
Route::get('/initSubscriptionFee', [App\Http\Controllers\GenerateSubscriptionFee::class, 'initSubscriptionFee'])->name('initSubscriptionFee');
Route::get('/payment_receipt/{id}', [App\Http\Controllers\MainController::class, 'payment_receipt'])->name('payment_receipt');
Route::get('/terms_of_service', [App\Http\Controllers\EnquiresController::class, 'terms_of_service'])->name('terms_of_service');
Route::get('/privacy_policy', [App\Http\Controllers\EnquiresController::class, 'privacy_policy'])->name('privacy_policy');
Route::post('/enquiry', [App\Http\Controllers\EnquiresController::class, 'enquiry'])->name('enquiry');
Route::post('/personal_register', [App\Http\Controllers\Auth\RegisterController::class, 'personal_register'])->name('personal_register');
Route::post('/corporate_register', [App\Http\Controllers\Auth\RegisterController::class, 'corporate_register'])->name('corporate_register');
Route::post('/new_personal_register/{id}', [App\Http\Controllers\Auth\RegisterController::class, 'new_personal_register'])->name('new_personal_register');
Route::post('/new_corporate_register/{id}', [App\Http\Controllers\Auth\RegisterController::class, 'new_corporate_register'])->name('new_corporate_register');

Route::get('/new_register/{id}', [App\Http\Controllers\Auth\RegisterController::class, 'new_register'])->name('new_register');


Route::group(['middleware' => ['auth:web', 'active_user','prevent-back-history']], function() {

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Report Controller user

Route::get('/user_commission_report_view', [App\Http\Controllers\ReportController::class, 'user_commission_report_view'])->name('user_commission_report_view');
Route::get('/user_payment_report_view', [App\Http\Controllers\ReportController::class, 'user_payment_report_view'])->name('user_payment_report_view');
Route::post('/user_payment_report', [App\Http\Controllers\ReportController::class, 'user_payment_report'])->name('user_payment_report');
Route::get('/user_payment_report_view', [App\Http\Controllers\ReportController::class, 'user_payment_report_view'])->name('user_payment_report_view');
Route::post('/user_commission_report', [App\Http\Controllers\ReportController::class, 'user_commission_report'])->name('user_commission_report');
Route::get('/user_commission_report_view', [App\Http\Controllers\ReportController::class, 'user_commission_report_view'])->name('user_commission_report_view');

//Mail Controller

Route::get('/sendemail', [App\Http\Controllers\MailController::class, 'index'])->name('index');
Route::post('/sendemail/send', [App\Http\Controllers\MailController::class, 'send'])->name('send');

//Account Controller

Route::get('/accountdashboard/{id}', [App\Http\Controllers\AccountsController::class, 'accountdashboard'])->name('accountdashboard');

// Tree Controller admin

Route::group(['middleware' => ['auth:web','admin', 'active_user','prevent-back-history']], function() {

Route::get('/network-view', [App\Http\Controllers\TreeController::class, 'network_view'])->name('network_view');
Route::get('/view-network-tree/{id}', [App\Http\Controllers\TreeController::class, 'viewnetworktree'])->name('viewnetworktree');
Route::get('/networktree/{id}',[App\Http\Controllers\TreeController::class,'networktree'])->name('networktree');
Route::get('/admin_usernetworktree/{id}',[App\Http\Controllers\TreeController::class,'admin_usernetworktree'])->name('admin_usernetworktree');

});

Route::group(['middleware' => ['auth:web','user', 'active_user','prevent-back-history']], function() {
Route::get('/usernetworktree/{id}',[App\Http\Controllers\TreeController::class,'usernetworktree'])->name('usernetworktree');
});
Route::get('/getchild/',[App\Http\Controllers\TreeController::class,'getchild'])->name('getchild');


Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
Route::post('/get_user_network_tree/{id}', [App\Http\Controllers\UserController::class, 'get_user_network_tree'])->name('get_user_network_tree');
Route::get('/get_user_networktree_view/{id}', [App\Http\Controllers\UserController::class, 'get_user_networktree_view'])->name('get_user_networktree_view');
Route::get('/searchspill_over_id/',[App\Http\Controllers\UserController::class,'searchspill_over_id'])->name('searchspill_over_id');
Route::post('/change_password_action', [App\Http\Controllers\UserController::class, 'change_password_action'])->name('change_password_action');
Route::get('/change_password', [App\Http\Controllers\UserController::class, 'change_password'])->name('change_password');
Route::get('/kycuploads', [App\Http\Controllers\UserController::class, 'kycuploads'])->name('kycuploads');
Route::get('/chequeupload', [App\Http\Controllers\UserController::class, 'chequeupload'])->name('chequeupload');
Route::get('/aadharupload', [App\Http\Controllers\UserController::class, 'aadharupload'])->name('aadharupload');
Route::get('/panupload', [App\Http\Controllers\UserController::class, 'panupload'])->name('panupload');
Route::get('/bankupload', [App\Http\Controllers\UserController::class, 'bankupload'])->name('bankupload');
Route::get('/addaccount',[App\Http\Controllers\UserController::class,'addaccount'])->name('addaccount');
Route::get('/referrals', [App\Http\Controllers\UserController::class, 'referrals'])->name('referrals');
Route::get('/customerprofile', [App\Http\Controllers\UserController::class, 'customerprofile'])->name('customerprofile');
Route::get('/userdatarequest', [App\Http\Controllers\UserController::class, 'userdatarequest'])->name('userdatarequest');
Route::get('/customerprofileupdate', [App\Http\Controllers\UserController::class, 'customerprofileupdate'])->name('customerprofileupdate');
Route::post('/updatecustomer/{id}',[App\Http\Controllers\UserController::class,'updatecustomer'])->name('updatecustomer');
Route::post('/updatesecondarypassword',[App\Http\Controllers\UserController::class,'updatesecondarypassword'])->name('updatesecondarypassword');
Route::get('/bankdetails', [App\Http\Controllers\UserController::class, 'bankdetails'])->name('bankdetails');
Route::get('/customerbankdetails', [App\Http\Controllers\UserController::class, 'customerbankdetails'])->name('customerbankdetails');
Route::post('/storebankdetails',[App\Http\Controllers\UserController::class, 'storebankdetails'])->name('storebankdetails');
Route::get('/deleteuploadedkyc/{id}',[App\Http\Controllers\UserController::class,'deleteuploadedkyc'])->name('deleteuploadedkyc');
Route::get('/addnewaccount',[App\Http\Controllers\UserController::class,'addnewaccount'])->name('addnewaccount');
Route::get('/accountview',[App\Http\Controllers\UserController::class,'accountview'])->name('accountview');
Route::get('/viewaccount/{id}',[App\Http\Controllers\UserController::class,'viewaccount'])->name('viewaccount');
Route::get('/activationaccept',[App\Http\Controllers\UserController::class,'activationaccept'])->name('activationaccept');
Route::post('/sendaccountrequest/{id}',[App\Http\Controllers\UserController::class,'sendaccountrequest'])->name('sendaccountrequest');
Route::get('/edituploadedbank',[App\Http\Controllers\UserController::class,'edituploadedbank'])->name('edituploadedbank');
Route::post('/edituploadedbankdetails/{id}',[App\Http\Controllers\UserController::class,'edituploadedbankdetails'])->name('edituploadedbankdetails');
Route::get('/deleteuploadedbank/{id}',[App\Http\Controllers\UserController::class,'deleteuploadedbank'])->name('deleteuploadedbank');
Route::get('/cancelaccount/{id}',[App\Http\Controllers\UserController::class,'cancelaccount'])->name('cancelaccount');
Route::post('/updatespill_over_id/{id}',[App\Http\Controllers\UserController::class,'updatespill_over_id'])->name('updatespill_over_id');
Route::post('/upload_user_image/{id}',[App\Http\Controllers\UserController::class,'upload_user_image'])->name('upload_user_image');
Route::post('/update_gst/{id}',[App\Http\Controllers\UserController::class,'update_gst'])->name('update_gst');
Route::get('/income_details',[App\Http\Controllers\UserController::class,'income_details'])->name('income_details');



Route::get('/commission_requests', [App\Http\Controllers\CommissionController::class, 'commission_requests'])->name('commission_requests');
Route::post('/send_new_commission_request', [App\Http\Controllers\CommissionController::class, 'send_new_commission_request'])->name('send_new_commission_request');
Route::get('/viewcommission_byid/{id}', [App\Http\Controllers\CommissionController::class, 'viewcommission_byid'])->name('viewcommission_byid');


Route::get('/receiptview', [App\Http\Controllers\InvoicesController::class, 'receiptview'])->name('receiptview');
Route::get('/viewreceipt_byid/{id}', [App\Http\Controllers\InvoicesController::class, 'viewreceipt_byid'])->name('viewreceipt_byid');


Route::get('/admin_dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin_dashboard');
Route::get('/admin_viewreceipt_byid/{id}', [App\Http\Controllers\AdminController::class, 'admin_viewreceipt_byid'])->name('admin_viewreceipt_byid');
Route::post('/admin_approved_requests_view', [App\Http\Controllers\AdminController::class, 'admin_approved_requests_view'])->name('admin_approved_requests_view');
Route::post('/subscription_payment_reports/{id}', [App\Http\Controllers\AdminController::class, 'subscription_payment_reports'])->name('subscription_payment_reports');
Route::get('/admin_commission_report_view', [App\Http\Controllers\AdminController::class, 'admin_commission_report_view'])->name('admin_commission_report_view');
Route::get('/admin_payment_report_view', [App\Http\Controllers\AdminController::class, 'admin_payment_report_view'])->name('admin_payment_report_view');
Route::post('/payment_report', [App\Http\Controllers\AdminController::class, 'payment_report'])->name('payment_report');
Route::get('/payment_report_view', [App\Http\Controllers\AdminController::class, 'payment_report_view'])->name('payment_report_view');
Route::post('/commission_report', [App\Http\Controllers\AdminController::class, 'commission_report'])->name('commission_report');
Route::get('/commission_report_view', [App\Http\Controllers\AdminController::class, 'commission_report_view'])->name('commission_report_view');
Route::post('/enquiry_reply/{id}', [App\Http\Controllers\AdminController::class, 'enquiry_reply'])->name('enquiry_reply');
Route::get('/admin_enquiry_view', [App\Http\Controllers\AdminController::class, 'admin_enquiry_view'])->name('admin_enquiry_view');
Route::get('/commission_payment', [App\Http\Controllers\AdminController::class, 'commission_payment'])->name('commission_payment');
Route::post('/commission_payment_confirmation', [App\Http\Controllers\AdminController::class, 'commission_payment_confirmation'])->name('commission_payment_confirmation');
Route::get('/approved_commission_requests', [App\Http\Controllers\AdminController::class, 'approved_commission_requests'])->name('approved_commission_requests');
Route::get('/changecommissionstatus/{id}', [App\Http\Controllers\AdminController::class, 'changecommissionstatus'])->name('changecommissionstatus');
Route::post('/reject_commission_remarks/{id}', [App\Http\Controllers\AdminController::class, 'reject_commission_remarks'])->name('reject_commission_remarks');
Route::get('/approve_commission_request/{id}', [App\Http\Controllers\AdminController::class, 'approve_commission_request'])->name('approve_commission_request');
Route::get('/reject_commission_request/{id}', [App\Http\Controllers\AdminController::class, 'reject_commission_request'])->name('reject_commission_request');
Route::get('/commission_detailed_view/{id}', [App\Http\Controllers\AdminController::class, 'commission_detailed_view'])->name('commission_detailed_view');
Route::get('/admin_commission_request_view', [App\Http\Controllers\AdminController::class, 'admin_commission_request_view'])->name('admin_commission_request_view');
Route::post('/admin_change_password_action', [App\Http\Controllers\AdminController::class, 'admin_change_password_action'])->name('admin_change_password_action');
Route::get('/admin_change_password', [App\Http\Controllers\AdminController::class, 'admin_change_password'])->name('admin_change_password');
Route::get('/customerrequests',[App\Http\Controllers\AdminController::class, 'customerrequests'])->name('customerrequests');
Route::get('/customerkycdetails/{id}',[App\Http\Controllers\AdminController::class, 'customerkycdetails'])->name('customerkycdetails');
Route::get('/approvecustomer/{id}',[App\Http\Controllers\AdminController::class, 'approvecustomer'])->name('approvecustomer');
Route::get('/rejectcustomer/{id}',[App\Http\Controllers\AdminController::class, 'rejectcustomer'])->name('rejectcustomer');
Route::get('/approvekyc/{id}',[App\Http\Controllers\AdminController::class, 'approvekyc'])->name('approvekyc');
Route::get('/rejectkyc/{id}',[App\Http\Controllers\AdminController::class, 'rejectkyc'])->name('rejectkyc');
Route::get('/changekycstatus/{id}',[App\Http\Controllers\AdminController::class, 'changekycstatus'])->name('changekycstatus');
Route::get('/approvedrequests',[App\Http\Controllers\AdminController::class, 'approvedrequests'])->name('approvedrequests');
Route::get('/rejectedrequests',[App\Http\Controllers\AdminController::class, 'rejectedrequests'])->name('rejectedrequests');
Route::get('/blockedusers',[App\Http\Controllers\AdminController::class, 'blockedusers'])->name('blockedusers');
Route::get('/approveaccount/{id}',[App\Http\Controllers\AdminController::class, 'approveaccount'])->name('approveaccount');
Route::get('/rejectaccount/{id}',[App\Http\Controllers\AdminController::class, 'rejectaccount'])->name('rejectaccount');
Route::get('/adminuserview/{id}', [App\Http\Controllers\AdminController::class, 'adminapprovedcustomerview'])->name('adminuserview');
Route::get('/admincustomerview/{id}', [App\Http\Controllers\AdminController::class, 'admincustomerview'])->name('admincustomerview');
Route::post('/rejectkycinput/{id}',[App\Http\Controllers\AdminController::class, 'rejectkycinput'])->name('rejectkycinput');
Route::get('/rejectkycremarks/{id}', [App\Http\Controllers\AdminController::class, 'rejectkycremarks'])->name('rejectkycremarks');
Route::get('/admincustomerprofileupdate/{id}', [App\Http\Controllers\AdminController::class, 'admincustomerprofileupdate'])->name('admincustomerprofileupdate');
Route::post('/adminupdatecustomer/{id}',[App\Http\Controllers\AdminController::class,'adminupdatecustomer'])->name('adminupdatecustomer');
Route::get('/terminatecustomer/{id}',[App\Http\Controllers\AdminController::class,'terminatecustomer'])->name('terminatecustomer');
Route::get('/unblockcustomer/{id}',[App\Http\Controllers\AdminController::class,'unblockcustomer'])->name('unblockcustomer');
Route::get('/deletecustomer/{id}',[App\Http\Controllers\AdminController::class,'deletecustomer'])->name('deletecustomer');
Route::post('/updateremarks/{id}',[App\Http\Controllers\AdminController::class,'updateremarks'])->name('updateremarks');
Route::post('/updateaccountremarks/{id}',[App\Http\Controllers\AdminController::class,'updateaccountremarks'])->name('updateaccountremarks');
Route::get('/changeaccountstatus/{id}',[App\Http\Controllers\AdminController::class, 'changeaccountstatus'])->name('changeaccountstatus');
Route::get('/changeaccountstatustoapprove/{id}',[App\Http\Controllers\AdminController::class, 'changeaccountstatustoapprove'])->name('changeaccountstatustoapprove');
Route::get('/accountrequests',[App\Http\Controllers\AdminController::class, 'accountrequests'])->name('accountrequests');
Route::get('/pending_document',[App\Http\Controllers\AdminController::class, 'pending_document'])->name('pending_document');
Route::post('/adminedituploadedbankdetails/{id}',[App\Http\Controllers\AdminController::class,'adminedituploadedbankdetails'])->name('adminedituploadedbankdetails');
Route::post('/adminupdateuploadedkyc/{id}',[App\Http\Controllers\AdminController::class,'adminupdateuploadedkyc'])->name('adminupdateuploadedkyc');
Route::get('/admin_progress_view', [App\Http\Controllers\AdminController::class, 'admin_progress_view'])->name('admin_progress_view');
Route::post('/get_network_tree/{id}', [App\Http\Controllers\AdminController::class, 'get_network_tree'])->name('get_network_tree');
Route::get('/get_network_tree_view/{id}', [App\Http\Controllers\AdminController::class, 'get_network_tree_view'])->name('get_network_tree_view');
Route::post('/get_full_network_tree',[App\Http\Controllers\AdminController::class,'get_full_network_tree'])->name('get_full_network_tree');
Route::get('/get_full_network_tree',[App\Http\Controllers\AdminController::class,'get_full_network_tree'])->name('get_full_network_tree');
Route::get('/admin_payment_history',[App\Http\Controllers\AdminController::class,'admin_payment_history'])->name('admin_payment_history');
Route::get('/customer_bank_report', [App\Http\Controllers\AdminController::class, 'customer_bank_report'])->name('customer_bank_report');
Route::post('/adminaddmorekycimage/{id}', [App\Http\Controllers\AdminController::class, 'adminaddmorekycimage'])->name('adminaddmorekycimage');
Route::get('/admindeletekycimage/{id}/{name}', [App\Http\Controllers\AdminController::class, 'admindeletekycimage'])->name('admindeletekycimage');
Route::get('/admin_cancelled_view',[App\Http\Controllers\AdminController::class, 'admin_cancelled_view'])->name('admin_cancelled_view');
Route::get('/admincancelaccount/{id}',[App\Http\Controllers\AdminController::class,'admincancelaccount'])->name('admincancelaccount');


Route::post('/storekyc',[App\Http\Controllers\KycController::class, 'storekyc'])->name('storekyc');
Route::get('/edituploadedkyc/{id}',[App\Http\Controllers\KycController::class,'edituploadedkyc'])->name('edituploadedkyc');
Route::post('/updateuploadedkyc/{id}',[App\Http\Controllers\KycController::class,'updateuploadedkyc'])->name('updateuploadedkyc');
Route::get('/editkycimage/{id}',[App\Http\Controllers\KycController::class,'editkycimage'])->name('editkycimage');
Route::post('/updatekycimage/{id}',[App\Http\Controllers\KycController::class,'updatekycimage'])->name('updatekycimage');
Route::post('/addmorekycimage/{id}',[App\Http\Controllers\KycController::class,'addmorekycimage'])->name('addmorekycimage');
Route::get('/deletekycimage/{id}/{name}',[App\Http\Controllers\KycController::class,'deletekycimage'])->name('deletekycimage');



Route::get('/otpview',[App\Http\Controllers\VerifyOtpController::class,'otpview'])->name('otpview');
Route::post('/verifyOtp',[App\Http\Controllers\VerifyOtpController::class,'verifyOtp'])->name('verifyOtp');
Route::get('/resendOtp',[App\Http\Controllers\VerifyOtpController::class,'resendOtp'])->name('resendOtp');



Route::get('/emailverification',[App\Http\Controllers\VerifyemailController::class,'emailverification'])->name('emailverification');
Route::post('/verifyemail',[App\Http\Controllers\VerifyemailController::class,'verifyemail'])->name('verifyemail');
Route::get('/resendemailOtp',[App\Http\Controllers\VerifyemailController::class,'resendemailOtp'])->name('resendemailOtp');


Route::get('/subscriptionpayment',[App\Http\Controllers\PaymentController::class,'subscriptionpayment'])->name('subscriptionpayment');
Route::post('/payment',[App\Http\Controllers\PaymentController::class,'payment'])->name('payment');
Route::get('/walletpayment',[App\Http\Controllers\PaymentController::class,'walletpayment'])->name('walletpayment');
Route::get('/walletconfirmation',[App\Http\Controllers\PaymentController::class,'walletconfirmation'])->name('walletconfirmation');
Route::post('/cardpayment',[App\Http\Controllers\PaymentController::class,'cardpayment'])->name('cardpayment');
Route::post('/cardpaymentverify',[App\Http\Controllers\PaymentController::class,'cardpaymentverify'])->name('cardpaymentverify');
Route::post('/cardpaymentaction',[App\Http\Controllers\PaymentController::class,'cardpaymentaction'])->name('cardpaymentaction');
Route::get('/paymentsuccess',[App\Http\Controllers\PaymentController::class,'paymentsuccess'])->name('paymentsuccess');
Route::get('/payment_history',[App\Http\Controllers\PaymentController::class,'payment_history'])->name('payment_history');

Route::get('/admin_subscription_payment/{id}',[App\Http\Controllers\SubscriptionController::class,'admin_subscription_payment'])->name('admin_subscription_payment');
Route::post('/admin_payment/{id}',[App\Http\Controllers\SubscriptionController::class,'admin_payment'])->name('admin_payment');
Route::post('/cashpayment/{id}',[App\Http\Controllers\SubscriptionController::class,'cashpayment'])->name('cashpayment');
Route::get('/cashconfirmation/{id}',[App\Http\Controllers\SubscriptionController::class,'cashconfirmation'])->name('cashconfirmation');
Route::get('/bankconfirmation/{id}',[App\Http\Controllers\SubscriptionController::class,'bankconfirmation'])->name('bankconfirmation');
Route::post('/bankpayment/{id}',[App\Http\Controllers\SubscriptionController::class,'bankpayment'])->name('bankpayment');
Route::get('/admin_paymentsuccess/{id}',[App\Http\Controllers\SubscriptionController::class,'admin_paymentsuccess'])->name('admin_paymentsuccess');

});

// Route::get('/new_register', function (Request $request) {
//     if (! $request->hasValidSignature()) {
//         abort(401);
//     }

//     // ...
// })->name('new_register');

Route::group(['middleware' => 'prevent-back-history'],function(){
	Auth::routes(['verify'=>true]);
});



