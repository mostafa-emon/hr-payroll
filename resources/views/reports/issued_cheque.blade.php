@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
        <a class="breadcrumb-item" href="{{ url('mr') }}">Report</a>
        <span class="breadcrumb-item active">Issued Cheque</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Issued Cheques</h4>
    </div>
  </div>

  <div class="br-pagebody pd-t-15">
    <div class="br-section-wrapper">

        <form action="{{ url('issued-cheque') }}" method="POST">
            {{ csrf_field() }}
        <div class="row mg-b-30 b">
            <div class="col-md-2">
                <label class="tx-black tx-13">Bank</label>
                <select class="form-control" name="bank_id" onchange="get_accounts(this.value)">
                <option value="All" @if($bank_name == "All") selected @endif>All</option>
                @foreach($banks as $bk)
                    <option value="{{$bk->id}}" @if($bank_name == $bk->name) selected @endif>{{$bk->name}}</option>
                @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="tx-black tx-13">Accounts</label>
                <select id="account_id" name="account_id" onchange="get_cheque_books(this.value)" class="form-control mg-l--4">
                  <option value="All" @if($ac_number == "All") selected @endif>All</option>
                  @if($accounts != "")
                    @foreach($accounts as $ac)
                      <option value="{{$ac->id}}" @if($ac_number == $ac->ac_number) selected @endif>{{$ac->ac_number}}</option>
                    @endforeach
                  @endif
                </select>
            </div>

            <div class="col-md-2">
              <label class="tx-black tx-13">Cheque Books</label>
              <select id="cheque_books" name="book_no" class="form-control" required>
                <option value="All" @if($cheque_book == "All") selected @endif>All</option>
                @if($cheque_books != "")
                  @foreach($cheque_books as $cb)
                    <option value="{{$cb->book_no}}" @if($cheque_book == $cb->book_no) selected @endif>{{$cb->book_no}}</option>
                  @endforeach
                @endif
              </select>
          </div>

            <div class="col-md-2">
                <label class="tx-black tx-13">Supplier</label>
                <select class="form-control" name="supplier">
                <option value="All" @if($supplier_name == "all") selected @endif>All</option>
                @foreach($suppliers as $sup)
                    <option value="{{$sup->cheque_name}}" @if($supplier_name == $sup->cheque_name) selected @endif>{{$sup->name}}</option>
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

            <div class="col-md-2" style="margin-top:10px">
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
            @include('reports.exports.issued_cheque_table',$cheques)
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
      document.getElementById("excelButton").href="/export-issued-cheque?bank_id={{$bank_name}}&account_id={{$ac_number}}&book_no={{$cheque_book}}&supplier={{$supplier_name}}&from_date={{$from_date}}&to_date={{$to_date}}&total="+croreFormat; 
    }else{
      var millionFormat = '{{$total}}'.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      document.getElementById("grandTotal").innerHTML = millionFormat;
      document.getElementById("excelButton").href="/export-issued-cheque?bank_id={{$bank_name}}&account_id={{$ac_number}}&book_no={{$cheque_book}}&supplier={{$supplier_name}}&from_date={{$from_date}}&to_date={{$to_date}}&total="+millionFormat; 
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

    function get_accounts(bank_id) {
      $.ajax({
          type: 'GET',
          url: '/get-account-by-bank/'+bank_id,
          success:function(data) {
            $('#account_id').html('');
            $('#account_id').append('<option value="All" @if($ac_number == "All") selected @endif>All</option>');
            $('#account_id').append(data);
          }
      });
    }

    function get_cheque_books(account_id) {
      $.ajax({
          type: 'GET',
          url: '/get-cheque-book-by-account/'+account_id,
          success:function(data) {
            $('#cheque_books').html('');
            $('#cheque_books').append('<option value="All" @if($ac_number == "All") selected @endif>All</option>');
            $('#cheque_books').append(data);
          }
      });
    }
  </script>

@endsection