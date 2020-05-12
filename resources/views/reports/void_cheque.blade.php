@extends('layouts.master')

@section('title', $title)

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
        <a class="breadcrumb-item" href="{{ url('mr') }}">Report</a>
        <span class="breadcrumb-item active">Void Cheque</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Void Cheques</h4>
    </div>
  </div>

  <div class="br-pagebody pd-t-15">
    <div class="br-section-wrapper">

        <form action="{{ url('void-cheque') }}" method="POST">
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

        <div class="table-responsive">
          <table 
            @if(roles() != "" && in_array(48, json_decode(roles(),false))) id="datatable1" @endif 
            @if(roles() != "" && !in_array(48, json_decode(roles(),false))) id="datatable2" @endif
            class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="text-center">Sl</th>
                  <th>Date</th>
                  <th>Bank</th>
                  <th>Account</th>
                  <th>Book No.</th>
                  <th>Cheque No.</th>
                  <th>Payee</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                @foreach($cheques as $cheque)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>&nbsp;{{ date('d-m-Y',strtotime($cheque->date)) }}&nbsp;</td>
                    <td>&nbsp;{{ $cheque->bank_name }}&nbsp;</td>
                    <td>&nbsp;{{ $cheque->ac_number }}&nbsp;</td>
                    <td>&nbsp;{{ $cheque->book_no }}&nbsp;</td>
                    <td>&nbsp;{{ $cheque->cheque_no }}&nbsp;</td>
                    <td>&nbsp;{{ $cheque->cheque_name }}&nbsp;</td>
                    <td>&nbsp;{{ $cheque->amount }}&nbsp;</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <br>
        </div>
    </div>
  </div>

  <script>
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