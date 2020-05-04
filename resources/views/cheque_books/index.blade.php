@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('cheque-books') }}">Cheque Books</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Cheque Books</h4>
    </div>
    <div style="float:right">
      <a href="{{ url('cheque-books/add') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add Book</a>
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
      <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table table-striped mg-b-0">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Bank</th>
              <th>Account Number</th>
              <th>Cheque Book No.</th>
              <th>No. of Leaves</th>
              <th>Starting Number</th>
              <th>Ending Number</th>
              <th>Update</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            @foreach($cheque_books as $cheque_book)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cheque_book->bank_name }}</td>
                <td>{{ $cheque_book->ac_number }}</td>
                <td>{{ $cheque_book->book_no }}</td>
                <td>{{ $cheque_book->no_of_leaves }}</td>
                <td>{{ $cheque_book->starting_number }}</td>
                <td>{{ $cheque_book->ending_number }}</td>
                <td>
                  <a class="btn btn-info btn-sm" href="{{url ('cheque-books/update/'.$cheque_book->id) }}"><i class= "fa fa-edit"></i> Update </a>
                  </td>
                  <td>
                  <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmDelete({{$cheque_book->id}})"><i class= "fa fa-minus-circle"></i> Delete</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
   function confirmDelete(id){
     var result = confirm("Are you confirm to delete?");
     if (result) {
       window.location = 'cheque-books/delete/'+id
     }
   }
  </script>
@endsection