<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
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
   border-color:black;
   height:50;
  
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
    .td-right{
   text-align:right;
   border-color:black;
}
.td-left{
   text-align:left;
   border-color:black;
}

</style>

<div class="container" id="print_area">
@php 
   $commission_payment=$results['commission_payment'];
 
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

      <table border = "1" width="100%" cellspacing="0" cellpadding="0">
         <tr><th><h3><b>COMMISSION REQUESTS
         [ From {{\App\Helper\PaymentHelper::convert_date_format($start_date)}} to {{\App\Helper\PaymentHelper::convert_date_format($end_date)}} ]</b></h3></th></tr>
      </b></h3></th></tr>
      </table>

         <table border = "1" width="100%" cellspacing="0" cellpadding="0">
            <th  class="th">Sl. No</th>
            <th  class="th">Date</th>
            <th  class="th">Name</th>
            <th  class="th">Email</th>
            <th class="th">Phone</th>
            <th  class="th">Account Number</th>
            <th  class="th">Amount</th>
            <th  class="th">TDS Percentage</th>
            <th  class="th">TDS Amount</th>
            <th class="th" >Total</th>
            <th  class="th">Remarks if any</th>
    
      @php 
      $no=1; 
      $grand_total=0;
      @endphp

      @foreach($commission_payment as $payment)
      @php
        $grand_total +=$payment['total'];
        @endphp
      <tr>
            <td class="td">{{$no++}}</td>
            <td class="td"  >{{\App\Helper\PaymentHelper::convert_date_format($payment['date'])}}</td>
            <td class="td"  >{{$payment['name']}}</td>
            <td class="td"  >{{$payment['email']}}</td>
            <td class="td"  >{{$payment['phone']}}</td>
            <td class="td"  >{{$payment['acct_no']}}</td>
            <td  class="td-right" >@php echo \App\Helper\PaymentHelper::currency($payment['amount']) @endphp</td>
            <td  class="td" >{{$payment['tds_percentage']}}%</td> 
            <td class="td-right">{{\App\Helper\PaymentHelper::currency($payment['tds_amount'])}}</td> 
            <td  class="td -right" >{{\App\Helper\PaymentHelper::currency($payment['total'])}}</td>
            <td  class="td"></td>
      </tr>
      @endforeach
      <tr>
      <th width="3%"class="th" ></th>
            <th  class="th"  >TOTAL</th>
            <th class="th"></th>
            <th class="th" ></th>
            <th class="th"></th>
            <th class="th"></th>
            <th class="th"></th>
            <th class="th"></th>
            <th class="th"></th>
            <th  class="th" >{{\App\Helper\PaymentHelper::currency($grand_total)}}</th>
            <th class="th"></th>
            
            
               </tr>
      </table>

      <table border = "1" width="100%"  cellspacing="0" cellpadding="0">
      <td width="60%" style="padding-left:20px">
            <br><br><b>Amount in Words:</b><span>
            @php echo \App\Helper\PaymentHelper::convert_amount_to_words($grand_total) @endphp
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