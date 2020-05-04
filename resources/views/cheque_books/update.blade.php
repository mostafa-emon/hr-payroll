@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/cheque-books') }}">Cheque Books</a>
      <span class="breadcrumb-item active">Update</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Update Book</h4>
  </div>

  <form action="{{ url('cheque-books/update/'.$cheque_book->id) }}" method="POST">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">
            
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-control-label mg-b-0-force">Bank Name: <span class="tx-danger">*</span></label>
                <select name="bank_id" class="form-control mg-l--4" onchange="get_accounts(this.value)">
                  <option selected disabled>Select Bank</option>
                      @foreach($banks as $bank)
                          <option value="{{ $bank->id }}" @if($cheque_book->bank_id == $bank->id) selected @endif>{{ $bank->name }}</option>
                      @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label mg-b-0-force">Account Number: <span class="tx-danger">*</span></label>
                <select id="account_id" name="account_id" class="form-control mg-l--4">
                  <option selected disabled>Select Account</option>
                  @foreach($accounts as $account)
                      <option value="{{ $account->id }}" @if($cheque_book->account_id == $account->id) selected @endif>{{ $account->ac_number }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Book Number: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="book_no" placeholder="Enter Book Number" value="{{$cheque_book->book_no}}">
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">No. of Leaves: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="no_of_leaves" placeholder="Enter No. of Leaves" value="{{$cheque_book->no_of_leaves}}">
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label">Starting Number: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="starting_number" placeholder="Enter Starting Number" value="{{$cheque_book->starting_number}}">
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label">Ending Number: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="ending_number" placeholder="Enter Ending Number" value="{{$cheque_book->ending_number}}">
              </div>
            </div>

          </div>

          <div class="form-layout-footer bd pd-20 bd-t-0">
            <input type="submit" value="Submit" class="btn btn-info pointer"/>
          </div>

        </div>
      </div>
    </div>
  </form>

  <script>
    function get_accounts(bank_id) {
      $.ajax({
          type: 'GET',
          url: '/get-account-by-bank/'+bank_id,
          success:function(data) {
            $('#account_id').html('');
            $('#account_id').append('<option value="" disabled selected>Select Account</option>');
            $('#account_id').append(data);
          }
      });
    }
  </script>
@endsection