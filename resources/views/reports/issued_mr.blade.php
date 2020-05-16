@extends('layouts.master')

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
        <a class="btn btn-info btn-sm pointer" id="excelButton" href="">Excel</a>
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

      <div id="printArea" class="table-responsive" style="color:black; margin-top:-20px;">
        <div class="div-padding-30">
          @include('reports.exports.issued_mr_table',$money_receipts)
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
      document.getElementById("excelButton").href="/export-issued-mr?site_office={{$site_office}}&customer={{$customer}}&from_date={{$from_date}}&to_date={{$to_date}}&total="+croreFormat; 
    }else{
      var millionFormat = '{{$total}}'.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      document.getElementById("grandTotal").innerHTML = millionFormat;
      document.getElementById("excelButton").href="/export-issued-mr?site_office={{$site_office}}&customer={{$customer}}&from_date={{$from_date}}&to_date={{$to_date}}&total="+millionFormat; 
    }

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
  </script>
@endsection