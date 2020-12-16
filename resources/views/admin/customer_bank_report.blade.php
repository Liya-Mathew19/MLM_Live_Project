@extends('layouts.admin')
@section('content')
<!-- <button type="button" style="float:right;" class="btn btn-primary no-printme" onclick="window.print()"><i class="mdi mdi-printer"></i> Print</button><br><br> -->
<button type="button" style="float:right;" class="btn btn-primary " onclick="exportTableToExcel('tblData')"><i class="mdi mdi-file-export"></i> Export Table</button><br><br><br>
<script>
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'customer_bank_report.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>
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
	      <h4 class="card-title">CUSTOMER BANK DETAILS</b></h3></th></tr>
         </h4>
      </div>
   @if($users==null)
   <center><b><font color="red">{{__('No Reports Found !!')}}</font></b></center>
            @else
      <div class="table-responsive">
         <table id ="tblData" class="table table-bordered">
            <thead>
               <tr>
                  <th><b>Sl No.</b></th>
                  <th><b> Name</b></th>
                  <th> <b>Bank Name</b></th>
                  <th><b> Account Number</b></th>
                  <th><b> IFSC Code</b></th>
                  <th><b> PAN Number</b></th>
               </tr>
            </thead>
            @php
                $no=1;
            @endphp
            @foreach($users as $user)
            <tbody>
               <tr>
                  <td>{{$no++}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->bank_name}}</td>
                  <td>{{$user->acct_no}}</td>
                  <td>{{$user->ifsc_code}}</td>
                  <td>{{$user->identification_number}}</td>
               </tr>
            </tbody>
            @endforeach
         </table>
      </div>
      @endif
   </div>
</div>
@endsection