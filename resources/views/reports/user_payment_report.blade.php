<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendors/admin/css/style.css">
    <link rel="shortcut icon" href="{{env('APP_URL')}}/vendors/admin//images/favicon.png" />
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
.td-right{
   text-align:right;
   border-color:black;
}
.td-left{
   text-align:left;
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
$user=$user_array['user'];
@endphp
   <div style="background-color:white;color:black;padding:20px;">
      <h3 style="text-align:left;">GSTIN:32AATCA7075P1ZW
         <span style="float:right;">PHONE:+91 9605082808</span>
      </h3><br>
      <h1><b>AFPA GENERAL TRADERS (OPC) PVT LTD</b></h1>
      <p> <b>AMEERA MAHAL,(A & A APARTMENTS),GROUND FLOOR, FIRE STATION WEST ROAD,</b></p>
      <p><b>CHANGANACHERRY-1, KOTTAYAM DIST; KERALA, INDIA, PIN CODE: 686 101</b></p>
      <p><b>E-mail: info@afpageneraltraders.com</b></p><br>

      <table class="tbl1" border = "1" width="100%" cellspacing="0" cellpadding="0">
         <tr><th width="70%" rowspan = "3" ><h3><b>PAYMENT REPORT 
         [ From {{\App\Helper\PaymentHelper::convert_date_format($start_date)}} to {{\App\Helper\PaymentHelper::convert_date_format($end_date)}} ]</b></h3></th></tr>
      </table>

      <table class="tbl2" border = "1" width="100%" cellspacing="0" cellpadding="0">
         @if($user->type=='Corporate')
         <tr><td width="15%" class="no-border">Customer ID</td><td class="no-border">: {{ \App\Helper\PaymentHelper::generate_user_id($user->id)}} </td></tr>
         <tr><td  width="15%" class="no-border">Customer Name </td><td class="no-border">: {{$user->name}} </td></tr>
         <tr><td  width="15%" class="no-border"> Address </td><td class="no-border address">: {{$user->address}} {{$user->phone}}</td></tr>
         <tr><td  width="15%" class="no-border"> GSTIN </td><td class="no-border">: {{$user->gstin}}  </td></tr>
         <tr><td  width="15%" class="no-border"> State </td><td class="no-border"> :  
         <table class="tbl3" border="1" align="right" width="20%">
            <tr><td>State Code</td>
            <td>32</td></tr>
            </table></td></tr>
            @else
            <tr><td  width="15%" class="no-border"> Customer ID </td><td class="no-border">: {{ \App\Helper\PaymentHelper::generate_user_id($user->id)}} </td></tr>
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
        <tr>
            <th>Sl. No</th>
            <th>Date</th>
            <th>Invoice Number</th>
            <th>Amount</th>
            <th>SGST</th>
            <th>CGST</th>
            <th>Total GST</th>
            <th>KFC</th>
            <th>Total</th>
        </tr>
      @php $no=1; $tot_amount=0; $tot_gst=0 ; $tot_sgst=0 ;$tot_cgst=0 ;$grand_total=0; $tot_cess=0;
      @endphp 
      @foreach($results as $res)      
      @php
      $amounts=$res['subscription_fee'];
      $tot_amount += $amounts;

      $sgst=$res['sgst'];
      $tot_sgst += $sgst;

      $cgst=$res['cgst'];
      $tot_cgst += $cgst;

      $gst=$res['gst'];
      $tot_gst += $gst;
      
      $cess=$res['cess'];
      $tot_cess += $cess;
      $total=$res['amount'];
      $grand_total += $total;
      @endphp
        <tr>
            <td class="td">{{$no++}}</td>
            <td class="td">{{\App\Helper\PaymentHelper::convert_date_format($res['date'])}}</td>
            <td class="td">{{$res['invoice_number']}}</td>
            <td class="td-right">{{\App\Helper\PaymentHelper::currency($res['subscription_fee'])}}</td>
            <td class="td-right">{{\App\Helper\PaymentHelper::currency($res['sgst'])}}</td>
            <td class="td-right">{{\App\Helper\PaymentHelper::currency($res['cgst'])}}</td>
            <td class="td-right">{{\App\Helper\PaymentHelper::currency($res['gst'])}}</td>
            <td class="td-right">{{\App\Helper\PaymentHelper::currency($res['cess'])}}</td>
            <td class="td-right">{{\App\Helper\PaymentHelper::currency($res['amount'])}}</td> 
        </tr>
   @endforeach
    
        <tr>
            <th></th>
            <th>TOTAL</th>
            <th></th>
            <th class="td-right">{{\App\Helper\PaymentHelper::currency($tot_amount)}}</th>
            <th class="td-right">{{\App\Helper\PaymentHelper::currency($tot_sgst)}}</th>
            <th class="td-right">{{\App\Helper\PaymentHelper::currency($tot_cgst)}}</th>
            <th class="td-right">{{\App\Helper\PaymentHelper::currency($tot_gst)}}</th>
            <th class="td-right">{{\App\Helper\PaymentHelper::currency($tot_cess)}}</th>
            <th class="td-right">{{\App\Helper\PaymentHelper::currency($grand_total)}}</th> 
        </tr>

      </table>

      <table border = "1" width="100%"  cellspacing="0" cellpadding="0">
      <td width="60%" style="padding-left:20px">
            <b>Amount in Words:</b><span>
            {{\App\Helper\PaymentHelper::convert_amount_to_words($grand_total)}}
            </span><br><br>
            </td> 
            
         <td width="60%" class="footer">
         <br>
           For AFPA GENERAL TRADERS<br>
           <br><br><br>
           Authorised Signatory
         </td> 
      </table><br>
      <b>Note:</b> This is a computer generated payment report equally valid as original. Hence there is no need for a physical signature.
   </div>
</div>
</body>
</html>