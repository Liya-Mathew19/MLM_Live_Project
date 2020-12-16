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
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
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


<div id="content">
<div class="container" id="print_area">
   @php 
      $transaction=$results['transaction'];
      $user=$results['user'];
      $account=$results['account'];
   @endphp

   <div style="background-color:white;color:black;padding:20px;">
      <h3 style="text-align:left;">GSTIN:32AATCA7075P1ZW
         <span style="float:right;">PHONE:+91 9605082808</span>
      </h3><br>
      <h1><b>AFPA GENERAL TRADERS (OPC) PVT LTD</b></h1>
      <p> <b>AMEERA MAHAL,(A & A APARTMENTS),GROUND FLOOR, FIRE STATION WEST ROAD,</b></p>
      <p><b>CHANGANACHERRY-1, KOTTAYAM DIST; KERALA, INDIA, PIN CODE: 686 101</b></p>
      <p><b>E-mail: info@afpageneraltraders.com</b></p>

      <table class="tbl1" border = "1" width="100%" cellspacing="0" cellpadding="0">
         <tr>
            <th width="70%" rowspan = "3" ><h3><b>INVOICE</b></h3></th><td width="2%"></td>
            <td>Original For Receipient</td>
         </tr>
         <tr><td></td>
            <td>Duplicate for Supplier/Transporter</td>
         </tr>
         <tr><td></td>
            <td>Triplicate for Supplier</td>
         </tr>
      </table>
      <table class="tbl2" border = "1" width="100%" cellspacing="0" cellpadding="0">
     
         <td rowspan="4" width="60%">
            Reverse Charge &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp : <br><br>
            Invoice No. &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp :
            {{$transaction->invoice_number}} <br><br>
            Invoice Date &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp :
            {{ \App\Helper\PaymentHelper::convert_date_format($transaction->date)}} <br><br>
            State &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp : 
            Kerala
            <table class="tbl3" border="1" align="right" width="20%">
            <tr><td>State Code</td>
            <td>32</td></tr>
            </table>
         </td> 
            
         <td class="no-border">Transportation Mode : </td></tr>
         <tr><td class="no-border">Vehicle No. :</td></tr>
         <tr><td class="no-border">Date of Supply :</td></tr>
         <tr><td class="no-border">Place of Supply :</td></tr>
      </table>
      <table class="tbl3" border="1"  width="100%">
       <tr><td width="30%"><i>Details of Receiver</i></td>
    <td width="30%"><i>Billed to</i></td>
    <td><i>Details of Consignee</i></td>
    <td><i>Shipped to</i></td></tr>
    </table>



    <tr>
      <td>
         <table border="1" width="100%">
            @if($user->type=='Corporate')
            <tr><td class="no-border" width="10%">Name</td><td class="no-border" width="50%">: {{$user->name}} </td>
            <td style="border-right:none;border-bottom:none;border-top:none" ></td>
            <td class="no-border" >Name </td><td class="no-border">:</td></tr>

            <tr><td class="no-border" width="10%">Address</td><td class="address no-border">: {{$user->address}} {{$user->phone}} </td>
            <td style="border-right:none;border-bottom:none;border-top:none"></td><td class="no-border">Address </td><td class="no-border">:</td></tr>

            <tr><td class="no-border" width="10%">GSTIN</td><td class="no-border">: {{$user->gstin}} </td>
            <td style="border-right:none;border-bottom:none;border-top:none"></td>
            <td class="no-border">GSTIN </td><td class="no-border">:</td></tr>

            <tr><td class="no-border" width="10%">State</td><td class="no-border">: 
            <table class="tbl3" border="1" align="right" width="30%">
               <tr><td>State Code</td><td>32</td></tr>
            </table></td>

            <td style="border-right:none;border-bottom:none;border-top:none"></td>
            <td class="no-border">State </td><td class="no-border">:
               <table class="tbl3" border="1" align="right" width="50%">
                  <td>State Code</td><td>32</td>
               </table></td></tr>



            @else
            
            <tr><td class="no-border"  width="10%">Name</td><td class="no-border"  width="50%">: {{$user->name}} </td> 
            <td style="border-right:none;border-bottom:none;border-top:none"></td>
            <td class="no-border">Name </td><td class="no-border">:</td></tr>

            <tr><td class="no-border"  width="10%">Address</td><td class="address no-border">: {{$user->address}} {{$user->phone}} </td>
            <td style="border-right:none; border-bottom:none;border-top:none"></td>
            <td class="no-border">Address </td><td class="no-border">:</td></tr>

            <tr><td class="no-border" width="10%">State</td><td class="no-border">: 
               <table class="tbl3" border="1" align="right" width="30%">
                  <tr><td>State Code</td><td>32</td></tr>
               </table></td>
               <td style="border-right:none;border-bottom:none;border-top:none"></td><td class="no-border" >State </td><td class="no-border">:
               <table class="tbl3" border="1" align="right" width="50%">
                  <td>State Code</td><td>32</td>
               </table></td>
            </tr>
            @endif
         </table>
      </td>
   </tr>
   <table border = "1" width="100%" cellspacing="0" cellpadding="0">
      <th width="3%" class="th" rowspan="2">Sl. No</th>
      <th width="27%" class="th" rowspan="2">Name of Product / Service</th>
      <th width="6%" class="th" rowspan="2">HSN <br> ACS</th>
      <th width="4%" class="th" rowspan="2">Qty</th>
      <th width="6%" class="th" rowspan="2">Rate</th>
      <th width="12%"class="th"  rowspan="2">Amount</th>
      <th class="th" colspan="2">CGST</th> 
      <th class="th" colspan="2">SGST</th> 
      <th class="th" colspan="2">KFC</th> 
      <th class="th" rowspan="2">Total</th> 
      <tr>
         <th width="6%" class="th">Rate</th> 
         <th width="11%"class="th">Amount</th> 
         <th width="6%" class="th">Rate</th> 
         <th  width="11%" class="th">Amount</th>
         <th width="6%" class="th">Rate</th> 
         <th  width="11%" class="th">Amount</th>
      </tr>
    
      @php 
      $no=1;  $qty_total=0; $rate_total=0; $amount_total=0; $cgst_rate=0; $cgst_amount=0; $sgst_rate=0; $sgst_amount=0; 
      $grand_total=0; $cess_total=0;@endphp
      @foreach($account as $accounts)
      @php 
         $qty=$accounts['qty']; 
         $rate=$accounts['subscription_fee']; 
         $amount=$qty*$rate;
         $cgst_r=$accounts['cgst_rate']*$qty; 
         $cgst_a=$accounts['cgst_amount']*$qty;
         $sgst_r=$accounts['sgst_rate']*$qty;
         $sgst_a=$accounts['sgst_amount']*$qty;
         if(!empty($user->gstin))
         {
            $cess=(0*$amount)/100;
         }
         else
         {
         $cess=($accounts['cess']*$amount)/100;
         }

         $total=$amount+$cgst_a+$sgst_a+$cess; 

         $qty_total += $qty;
         $rate_total += $rate;
         $amount_total += $amount;
         $cgst_rate += $cgst_r;
         $cgst_amount += $cgst_a;
         $sgst_rate += $sgst_r;
         $sgst_amount += $sgst_a;
         $grand_total += $total;
         $cess_total += $cess;

      @endphp
      <tr>
            <td class="td"  >{{$no++}}</td>
            <td class="td"  >{{$accounts['title']}}</td>
            <td class="td"> 9971</td>
            <td class="td" >{{$accounts['qty']}}</td>
            <td  class="td" >@php echo \App\Helper\PaymentHelper::currency($accounts['subscription_fee']) @endphp</td>
            <td class="td"  >{{\App\Helper\PaymentHelper::currency($amount)}}</td>
            <td  class="td" >{{$accounts['cgst_rate']}}%</td> 
            <td class="td">{{\App\Helper\PaymentHelper::currency($cgst_a)}}</td> 
            <td  class="td" >{{$accounts['sgst_rate']}}%</td> 
            <td  class="td" >{{\App\Helper\PaymentHelper::currency($sgst_a)}}</td>
            @if(!empty($user->gstin))
            <td class="td">0%</td>
            <td class="td">{{$cess}}</td>
            @else
            <td class="td">{{$accounts['cess']}}%</td>
            <td class="td">{{$cess}}</td>
            @endif
            <td class="td">{{\App\Helper\PaymentHelper::currency($total)}}</td>
      </tr>
      @endforeach
      <tr>
      <th width="3%"class="th" ></th>
            <th width="27%" class="th"  >TOTAL</th>
            <th width="6%" class="th"></th>
            <th width="4%" class="th" ></th>
            <th width="6%" class="th"></th>
            <th width="12%" class="th" >{{\App\Helper\PaymentHelper::currency($amount_total)}}</th>
            <th width="6%" class="th"></th> 
            <th width="11%" class="th">{{\App\Helper\PaymentHelper::currency($cgst_amount)}}</th> 
            <th width="6%" class="th"></th> 
            <th  width="11%" class="th" >{{\App\Helper\PaymentHelper::currency($sgst_amount)}}</th>
            <th width="6%" class="th"></th>
            <th  width="11%" class="th">{{\App\Helper\PaymentHelper::currency($cess_total)}}</th>
            <th class="th">{{\App\Helper\PaymentHelper::currency($grand_total)}}</th>
               </tr>
      </table>

      <table border = "1" width="100%"  cellspacing="0" cellpadding="0">
      <td width="60%" style="padding-left:20px">
            <br><br><b>Amount in Words:</b><span>
            @php echo \App\Helper\PaymentHelper::convert_amount_to_words($grand_total) @endphp
            </span><br><br>
            <fieldset class="scheduler-border">
               <legend class="scheduler-border">BANK DETAILS</legend>
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
      <b>Note:</b> This is a computer generated receipt equally valid as original. Hence there is no need for a physical signature.
   </div>
</div>
</div>
</body>
</html>