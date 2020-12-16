@extends('layouts.admin')
@section('content')
<button type="button" style="float:right;" class="btn btn-primary no-printme" onclick="window.print()"><i class="mdi mdi-printer"></i> Print</button><br><br>
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
.td-right{
   text-align:right;
  
}
.td-left{
   text-align:left;
  
}
.td-center{
   text-align:center;
}
</style>

<div id="print_area">
   <div class="card card-danger card-outline card-outline-danger">
      <div class="card-header">
	      <h4 class="card-title">DOWNLINE REPORT
               [ {{$monthName}},{{$year}} ]</b></h3></th></tr>
         </h4>
      </div>
      

      <div class="table-responsive">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th class="td-center"><b>Level</b></th>
                  <th class="td-center"><b> Total Members</b></th>
                  <th class="td-center"> <b>Active Members</b></th>
                  <th class="td-center"><b> Inactive Members</b></th>
                  <th class="td-center"><b> Registration Under Progress</b></th>
                  <th class="td-center"><b> Cancelled Members</b></th>
                  <th class="td-center"><b> Rejected Members</b></th>
                  <th class="td-center"><b> Amount</b></th>
               </tr>
            </thead>
        
            <tbody>
            @php
               $total_members=0;$active=0;$inactive=0;$progress=0;$cancelled=0;$rejected=0;$grand_total=0;$no=1;
            @endphp
           @foreach($members as $accounts)
            @php
               $total_members += $accounts['total_members'];
               $active += $accounts['active'];
               $inactive += $accounts['inactive'];
               $progress += $accounts['progress'];
               $cancelled += $accounts['cancelled'];
               $rejected += $accounts['rejected'];
               $grand_total += $accounts['total_commission_amount'];
            @endphp
               <tr>
                  <td class="td-center">{{$accounts['position']}}</td>
                  <td class="td-center">{{$accounts['total_members']}}</td>
                  <td class="td-center"><label class="badge badge-success"><big>{{$accounts['active']}}</big></label></td>
                  <td class="td-center"><label class="badge badge-danger"><big>{{$accounts['inactive']}}</big></label></td>
                  <td class="td-center">{{$accounts['progress']}}</td>
                  <td class="td-center">{{$accounts['cancelled']}}</td>
                  <td class="td-center">{{$accounts['rejected']}}</td>
                  <td class="td-right">	&#x20B9; {{\App\Helper\PaymentHelper::currency($accounts['total_commission_amount'])}}</td>
               </tr>
            @endforeach
            <tr>
                  <th class="td-center"><b>Grand Total</b></th>
                  <th class="td-center"><b> {{$total_members}}</b></th>
                  <th class="td-center"> <b>{{$active}}</b></th>
                  <th class="td-center"><b> {{$inactive}}</b></th>
                  <th class="td-center"><b>{{$progress}} </b></th>
                  <th class="td-center"><b>{{$cancelled}} </b></th>
                  <th class="td-center"><b>{{$rejected}} </b></th>
                  <th class="td-right"><b> 	&#x20B9;{{\App\Helper\PaymentHelper::currency($grand_total)}}</b></th>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection