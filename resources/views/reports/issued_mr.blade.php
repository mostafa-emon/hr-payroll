@extends('layouts.master')

@section('title', $title)

@section('content')
  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('mr') }}">Report</a>
      <span class="breadcrumb-item active">Issued MR</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Issued MR</h4>
    </div>
  </div>

  <div class="br-pagebody pd-t-15">
    <div class="br-section-wrapper">
      @if(session()->has('message'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          {{ session()->get('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      
      <form action="{{ url('issued-mr') }}" method="POST">
        {{ csrf_field() }}
      <div class="row mg-b-30 b">
        <div class="col-md-2">
          <label class="tx-black tx-13">Site Office</label>
          <select class="form-control" name="site_office">
            <option value="All" @if($site_office == "all") selected @endif>All</option>
            @foreach($site_offices as $site)
              <option value="{{$site->name}}" @if($site_office == $site->name) selected @endif>{{$site->name}}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">Customer</label>
          <select class="form-control" name="customer">
            <option value="All" @if($site_office == "all") selected @endif>All</option>
            @foreach($customers as $cus)
              <option value="{{$cus->name}}" @if($customer == $cus->name) selected @endif>{{$cus->name}}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">From Date</label>
          <input type="text" id="dtpick1" name="from_date" value="{{$from_date}}" class="form-control" autocomplete="off"/>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">To Date</label>
          <input type="text" id="dtpick2" name="to_date" value="{{$to_date}}" class="form-control" autocomplete="off"/>
        </div>

        <div class="col-md-2" style="margin-top:28px">
          <input type="submit" class="btn btn-primary pointer" value="Search"/>
        </div>
        
      </div>
      </form>

      <div class="text-right mg-b-15">
        <a class="btn btn-success btn-sm pointer" onclick="printElem()" href="javascript:void(0)">Print</a>
      </div>

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

      <div id="printArea" style="color:black;">
        <div class="div-padding-30">
        <table style="width:100%;">
          <thead>
            <tr>
              <td colspan="8" class="no-border" style="text-align: center; font-size:17px; font-weight:bold;">{{ $company->name}}</td>
            </tr>
            <tr>
              <td colspan="8" class="no-border" style="text-align: center;font-size:15px; font-weight:bold;">Issued Money Receipt</td>
            </tr>
            <tr>
              <td colspan="8" class="no-border" style="text-align: center;font-size:13px; font-weight:bold;">From {{ date('d-M-Y',strtotime($from_date)) }} to {{ date('d-M-Y',strtotime($to_date)) }}</td>
            </tr>
            <tr>
              <th style="text-align: center">Sl</th>
              <th style="text-align: center">Date</th>
              <th style="text-align: left">Invoice No</th>
              <th style="text-align: left">Site Office</th>
              <th style="text-align: left">Customer</th>
              <th style="text-align: left">Pay Method</th>
              <th style="text-align: center">Status</th>
              <th style="text-align: center">Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($money_receipts as $mr)
            <tr>
              <td style="text-align: center">{{$loop->iteration}}</td>
              <td style="text-align: center">{{ date('d-m-Y', strtotime($mr->created_at))}}</td>
              <td>{{$mr->site_office_prefix}}{{$mr->invoice_no}}{{$mr->site_office_suffix}}</td>
              <td>{{$mr->site_office_name}}</td>
              <td>{{$mr->customer_name}}</td>
              <td>{{$mr->payment_method}}</td>
              <td style="text-align: right">
                  @if($mr->status == 0)
                    @if($setting->approval_for_mr == 1)
                      <span style="color:#FF9633">Pending</span>
                    @else
                      <span style="color:green">Issued</span>
                    @endif
                  @endif
                  @if($mr->status == 1)
                    <span style="color:green">Approved</span>
                  @endif
                  @if($mr->status == 2)
                    <span style="color:red">Rejected</span>
                  @endif
                  @if($mr->status == 3)
                    <span style="color:red">Void</span>
                  @endif
              </td>
              <td style="text-align: right">{{ $mr->amount }}</td>
            </tr>
            @endforeach
          </tbody>

          <tfoot>
            <th colspan="7" style="text-align:right">Total</th>
            <th style="text-align:right"><span id="grandTotal"></span></th>
          </tfoot>
        </table>
        </div>
      </div>
    </div>
  </div>

  <script>
    var amount_in_word_format = '{{ $setting->amount_in_word_format }}';
    var removeUnwanted = '{{$total}}'.replace(/[^0-9.]/g, "")
    var makeDecimal  = (Math.round(removeUnwanted * 100) / 100).toFixed(2);
    var splitDecimal = makeDecimal.split(".");
    var mainPart     = splitDecimal[0];
    var decimalPart  = splitDecimal[1];

    if(amount_in_word_format == 'crore_lakh_thousand' || amount_in_word_format == 'crore_lac_thousand') {
      var croreFormat = mainPart.toString();
      var lastThree = croreFormat.substring(croreFormat.length-3);
      var otherNumbers = croreFormat.substring(0,croreFormat.length-3);
      if(otherNumbers != '')
          lastThree = ',' + lastThree;
      croreFormat = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
      croreFormat = croreFormat + '.' + decimalPart
      document.getElementById("grandTotal").innerHTML = croreFormat;
    }else{
      var millionFormat = '{{$total}}'.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      document.getElementById("grandTotal").innerHTML = millionFormat;
    }

    function printElem(){
      var mywindow = window.open('', 'PRINT');
      mywindow.document.write('<style>@page { size: landscape; } .div-padding-30{padding: 30px !important} table {border-collapse: collapse;} th, td {border: 1px solid black;font-family:arial;font-size:13px;padding:5px;} .no-border{border:none;}</style>');
      mywindow.document.write(document.getElementById('printArea').innerHTML);

      setTimeout(function () {
          mywindow.focus();
          mywindow.print();
          mywindow.close();

          //window.location = "/mr"
      }, 1000);
    }
  </script>
@endsection