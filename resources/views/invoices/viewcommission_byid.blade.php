<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/admin/css/style.css">
    <link rel="shortcut icon" href="{{env('APP_URL')}}/vendors/admin/images/favicon.png" />
    <script src="{{env('APP_URL')}}/vendors/base/vendor.bundle.base.js"></script>
  </head>
<body>
<br><button type="button" style="float:right;" class="btn btn-primary no-printme" onclick="window.print()"><i class="mdi mdi-printer"></i> Print</button><br><br>

<style>
.print_area {
	display: none;
}
@media print {
	.no-printme  {
		display: none;
	}
	.printme  {
		display: block;
	}
}
html, body{
    height:100%;
    width:100%;
    padding:0;
    margin:0;
    font-family: Serif;
}
h1   { text-align:center;}
p    {text-align:center;}

table,th,td{
   color:black;
   padding-left:5px;
   border-color:black;
   padding: 5px;
}
th{
   text-align:center;
   border-color:black;
}
.no-border {
   border:0;
   
}
.tbl3,.td,.footer{
   text-align:center;
   border-color:black;
}
.address{
    
    white-space:pre-wrap; 
    word-wrap:break-word;
    align:justify;

}

fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 1.5em 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }

</style>

<div class="container" id="print_area">
@php 
   $commission_payment=$results['commission_payment'];
   $user=$results['user'];
   $title=$results['title'];
   $date=$results['payment_date'];
   $voucher_no=$results['voucher_no'];
@endphp

   <div style="background-color:white;color:black;padding:20px;">
      <h3 style="text-align:left;">GSTIN:32AATCA7075P1ZW
         <span style="float:right;">PHONE:+91 9605082808</span>
      </h3><br>
      <h1><b>AFPA GENERAL TRADERS (OPC) PVT LTD</b></h1>
      <p> <b>AMEERA MAHAL,(A & A APARTMENTS),GROUND FLOOR, FIRE STATION WEST ROAD,</b></p>
      <p><b>CHANGANACHERRY-1, KOTTAYAM DIST; KERALA, INDIA, PIN CODE: 686 101</b></p>
      <p><b>Company TAN : TVDA03224E</b></p>
      <p><b>E-mail: info@afpageneraltraders.com</b></p><BR>

      <table class="tbl1" border = "1" width="100%" cellspacing="0" cellpadding="0">
         <tr><th><h3><b>PAYMENT VOUCHER</b></h3></th></tr>
      </table>
      <table class="tbl2" border = "1" width="100%" cellspacing="0" cellpadding="0">
            <tr><td width="15%" class="no-border">Voucher No. </td><td class="no-border">: {{$voucher_no}}</td></tr>
            <tr><td width="15%"class="no-border"> Payment Date</td><td class="no-border">: {{\App\Helper\PaymentHelper::convert_date_format($date)}} </td></tr>
            <tr><td width="15%"class="no-border"> State</td><td class="no-border">: Kerala
            <table class="tbl3" border="1" align="right" width="20%">
            <tr><td>State Code</td>
            <td>32</td></tr>
            </table></td></tr>
            
         
      </table>
      <table class="tbl3" border="1"  width="100%">
       <tr><td width="30%"><i>Details of Receiver</i></td>
    <td width="30%"><i>Billed to</i></td>
    </table>
   
    <table class="tbl2" border = "1" width="100%" cellspacing="0" cellpadding="0">
         @if($user->type=='Corporate')
         <tr><td width="15%" class="no-border">Customer ID</td><td class="no-border">: {{ \App\Helper\PaymentHelper::generate_user_id($results['id'])}} </td></tr>
         <tr><td  width="15%" class="no-border">Customer Name </td><td class="no-border">: {{$user->name}} </td></tr>
         <tr><td  width="15%" class="no-border"> Address </td><td class="no-border address">: {{$user->address}} {{$user->phone}}</td></tr>
         <tr><td  width="15%" class="no-border"> GSTIN </td><td class="no-border">: {{$user->gstin}}  </td></tr>
         <tr><td  width="15%" class="no-border"> State </td><td class="no-border"> :  
         <table class="tbl3" border="1" align="right" width="20%">
            <tr><td>State Code</td>
            <td>32</td></tr>
            </table></td></tr>
            @else
            <tr><td  width="15%" class="no-border"> Customer ID </td><td class="no-border">: {{ \App\Helper\PaymentHelper::generate_user_id($results['id'])}} </td></tr>
            <tr><td  width="15%" class="no-border"> Customer Name </td><td class="no-border">: {{$user->name}}  </td></tr>
            <tr><td  width="15%" class="no-border"> Address </td><td class="no-border address" >: {{$user->address}} {{$user->phone}} </td></tr>
            <tr><td  width="15%" class="no-border">State </td><td class="no-border">: 
            <table class="tbl3" border="1" align="right" width="20%">
            <table class="tbl3" border="1" align="right" width="20%">
            <tr><td>State Code</td>
            <td>32</td></tr>
            </table></td></tr>
            @endif
            
   
         <table border = "1" width="100%" cellspacing="0" cellpadding="0">
            <th width="3%" class="th" rowspan="2">Sl. No</th>
            <th width="27%" class="th" rowspan="2">Description</th>
            <th width="6%" class="th" rowspan="2">Amount</th>
            <th width="4%" class="th" rowspan="2">TDS Percentage</th>
            <th width="6%" class="th" rowspan="2">TDS Amount</th>
            <th width="12%"class="th"  rowspan="2">Total</th>
            <tr>
               
            </tr>
    
      @php 
      $no=1; @endphp
      @foreach($commission_payment as $payment)
      <tr>
            <td class="td"  >{{$no++}}</td>
            <td class="td"  >{{$title}}</td>
            <td  class="td" >@php echo \App\Helper\PaymentHelper::currency($payment['amount']) @endphp</td>
            <td  class="td" >{{$payment['tds_percentage']}}%</td> 
            <td class="td">{{\App\Helper\PaymentHelper::currency($payment['tds_amount'])}}</td> 
            <td  class="td" >{{\App\Helper\PaymentHelper::currency($payment['total'])}}</td>
      </tr>
      @endforeach
      <tr>
      <th width="3%"class="th" ></th>
            <th width="27%" class="th"  >TOTAL</th>
            <th width="6%" class="th"></th>
            <th width="4%" class="th" ></th>
            <th width="6%" class="th"></th>
            <th width="12%" class="th" >{{\App\Helper\PaymentHelper::currency($payment['total'])}}</th>
            
               </tr>
      </table>

      <table border = "1" width="100%"  cellspacing="0" cellpadding="0">
      <td width="60%" style="padding-left:20px">
            <br><br><b>Amount in Words:</b><span>
            @php echo \App\Helper\PaymentHelper::convert_amount_to_words($payment['total']) @endphp
            </span><br><br>
            <fieldset class="scheduler-border">
    <legend class="scheduler-border">OUR BANKING DETAILS</legend>
    <div class="control-group">
    Bank Name: ICICI BANK<br>
A/c Name: AFPA GENERAL TRADERS (OPC)PVT LTD<br>
A/c No. 627105001545<br>
Branch : Changanacherry<br>
IFS Code : ICIC0006271
        
    </div>
</fieldset>
            </td> 
            
         <td width="60%" class="footer">
         <br>
           For AFPA GENERAL TRADERS<br>
           <br><br><br>
           Authorised Signatory
         </td> 
      </table><br>
      <b>Note:</b> This is a computer generated payment voucher equally valid as original. Hence there is no need for a physical signature.
   </div>
</div>
</body>
</html>