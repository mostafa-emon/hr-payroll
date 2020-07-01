@extends('layouts.master')

@section('content')
  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('mr') }}">Report</a>
      <span class="breadcrumb-item active">Void Voucher</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Void Voucher</h4>
    </div>
  </div>

  <div class="br-pagebody pd-t-15">
    <div class="br-section-wrapper">

      <div class="text-right mg-b-15">
        <a class="btn btn-info btn-sm pointer" href="{{url('export-void-voucher?voucher_type='.$voucher_type.'&from_date='.$from_date.'&to_date='.$to_date.'&payee_name='.$payee_name.'&amount='.$amount.'&memo='.$memo)}}">Excel</a>
        <a class="btn btn-success btn-sm pointer" onclick="printElem()" href="javascript:void(0)">Print</a>
      </div>
      
      <form action="{{ url('void-voucher') }}" method="POST">
          {{ csrf_field() }}
        <div class="row mg-b-30 b">
          <div class="col-md-2">
            <label class="tx-black tx-13">Voucher Type</label>
            <select class="form-control" name="voucher_type" onchange="hideShow(this.value)">
              <option value="" selected>All</option>
              <option value="Cash-Payment-Voucher" @if($voucher_type == "Cash-Payment-Voucher") selected @endif>Cash Payment Voucher</option>
              <option value="Bank-Payment-Voucher" @if($voucher_type == "Bank-Payment-Voucher") selected @endif>Bank Payment Voucher</option>
              <option value="Cash-Receipt-Voucher" @if($voucher_type == "Cash-Receipt-Voucher") selected @endif>Cash Receipt Voucher</option>
              <option value="Bank-Receipt-Voucher" @if($voucher_type == "Bank-Receipt-Voucher") selected @endif>Bank Receipt Voucher</option>
              <option value="Contra-Voucher" @if($voucher_type == "Contra-Voucher") selected @endif>Contra Voucher</option>
              <option value="Journal-Voucher" @if($voucher_type == "Journal-Voucher") selected @endif>Journal Voucher</option>
            </select>
          </div>

          <div class="col-md-2">
            <label class="tx-black tx-13">From Date</label>
            <input type="text" id="dtpick1" name="from_date" value="{{date('d-m-Y',strtotime($from_date))}}" class="form-control" autocomplete="off"/>
          </div>

          <div class="col-md-2">
            <label class="tx-black tx-13">To Date</label>
            <input type="text" id="dtpick2" name="to_date" value="{{date('d-m-Y',strtotime($to_date))}}" class="form-control" autocomplete="off"/>
          </div>

          <div @if( $voucher_type == "Cash-Receipt-Voucher" || $voucher_type == "Bank-Receipt-Voucher") style="display:none" @endif id="payee_name" class="col-md-2">
            <label class="tx-black tx-13">Payee Name</label>
            <input type="text" name="payee_name" value="{{$payee_name}}" class="form-control"/>
          </div>

          <div @if($voucher_type == "Cash-Payment-Voucher" || $voucher_type == "Bank-Payment-Voucher" || $voucher_type == "Contra-Voucher" || $voucher_type == "Journal-Voucher" || $voucher_type =="") style="display:none" @endif id="received_from" class="col-md-2">
            <label class="tx-black tx-13">Received From</label>
            <input type="text" name="received_from" value="{{$received_from}}" class="form-control"/>
          </div>

          <div class="col-md-2">
            <label class="tx-black tx-13">Amount</label>
            <input type="text" name="amount" value="{{$amount}}" class="form-control"/>
          </div>

          <div class="col-md-2">
            <label class="tx-black tx-13">Memo</label>
            <input type="text" name="memo" value="{{$memo}}" class="form-control"/>
          </div>

          <div class="col-md-2" style="margin-top:28px">
            <input type="submit" class="btn btn-primary pointer" value="Search"/>
          </div>
          
        </div>
      </form>

      <style>
        table {
          border-collapse: collapse;
        }
        th, td {
          border: 1px solid black;
          font-family:arial;
          font-size:13px;
          padding:5px;
        }
        .no-border{border:none;}
      </style>

      <div id="printArea" class="table-responsive" style="color:black; margin-top:-20px;">
        <div class="div-padding-30">
          @include('reports.exports.void_voucher_table',$vouchers)
        </div>
      </div>
    </div>
  </div>

  <script>
    function printElem(){
      var mywindow = window.open('', 'PRINT');
      mywindow.document.write('<style>table {border-collapse: collapse;} th, td {border: 1px solid black;font-family:arial;font-size:13px;padding:7px;} .no-border{border:none;}</style>');
      mywindow.document.write(document.getElementById('printArea').innerHTML);

      setTimeout(function () {
          mywindow.focus();
          mywindow.print();
          mywindow.close();

          //window.location = "/mr"
      }, 1000);
    }

    function hideShow(value) {
      if(value == "Cash-Receipt-Voucher" || value == "Bank-Receipt-Voucher"){
        $('#received_from').show();
        $('#payee_name').hide();
      }else{
        $('#received_from').hide();
        $('#payee_name').show();
      }
    }
  </script>

@endsection