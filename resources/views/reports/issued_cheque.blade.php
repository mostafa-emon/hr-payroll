@extends('layouts.master')

section('title', $title)

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

        <form action="{{ url('issued-mr') }}" method="POST">
            {{ csrf_field() }}
        <div class="row mg-b-30 b">
            <div class="col-md-2">
                <label class="tx-black tx-13">Bank</label>
                <select class="form-control" name="bank_name">
                <option value="All" @if($bank_name == "all") selected @endif>All</option>
                @foreach($banks as $bk)
                    <option value="{{$bk->name}}" @if($bank_name == $bk->name) selected @endif>{{$bk->name}}</option>
                @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="tx-black tx-13">Supplier</label>
                <select class="form-control" name="supplier">
                <option value="All" @if($supplier_name == "all") selected @endif>All</option>
                @foreach($suppliers as $sup)
                    <option value="{{$sup->name}}" @if($supplier_name == $sup->name) selected @endif>{{$sup->name}}</option>
                @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="tx-black tx-13">From Date</label>
                <input type="text" id="dtpick1" name="from_date" value="{{$from_date}}" class="form-control"/>
            </div>

            <div class="col-md-2">
                <label class="tx-black tx-13">To Date</label>
                <input type="text" id="dtpick2" name="to_date" value="{{$to_date}}" class="form-control"/>
            </div>

            <div class="col-md-2" style="margin-top:28px">
                <input type="submit" class="btn btn-primary pointer" value="Search"/>
            </div>
        
        </div>
        </form>

        <div class="table-responsive">
            <table id="datatable1" class="table display responsive nowrap">
                <thead>
                  <tr>
                    <th class="text-center">Sl</th>
                    <th>Bank</th>
                    <th>Account No.</th>
                    <th>Book No.</th>
                    <th>Cheque No.</th>
                    <th>Payee</th>
                    <th>Amount</th>
                    <th class="text-center">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($cheques as $cheque)
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td>{{ $cheque->bank_name }}</td>
                      <td>{{ $cheque->ac_number }}</td>
                      <td>{{ $cheque->book_no }}</td>
                      <td>{{ $cheque->cheque_no }}</td>
                      <td>{{ $cheque->cheque_name }}</td>
                      <td>{{ $cheque->amount }}</td>
                      <td class="text-center">
                        @if($cheque->status == 0)
                          @if($setting->approval_for_cheque == 1)
                            <span class="badge badge-warning">Pending</span>
                          @else
                            <span class="badge badge-success">Issued</span>
                          @endif
                        @endif
                        @if($cheque->status == 1)
                          <span class="badge badge-success">Approved</span>
                        @endif
                        @if($cheque->status == 2)
                          <span class="badge badge-danger">Rejected</span>
                        @endif
                        @if($cheque->status == 3)
                          <span class="badge badge-danger">Void</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
            <br>
        </div>
    </div>
  </div>

  <script>
  </script>

@endsection