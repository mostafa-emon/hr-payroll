@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('currency') }}">Currency</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Currencies</h4>
    </div>
    <div style="float:right">
      @if(roles() != "" && in_array(8, json_decode(roles(),false)))
      <a href="{{ url('currency/add') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add Currency</a>
      @endif
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
              <th>Full Name</th>
              <th>Fraction Name</th>
              <th class="text-center">Default</th>
              @if(roles() != "" && in_array(9, json_decode(roles(),false)))
              <th>Update</th>
              @endif

              @if(roles() != "" && in_array(10, json_decode(roles(),false)))
              <th>Delete</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($currencies as $currency)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $currency->full_name }}</td>
                <td>{{ $currency->fraction_name }}</td>
                <td class="text-center">
                  @if($currency->default == 1)
                    <span class="badge badge-success">Default</span>
                  @endif
                </td>
                @if(roles() != "" && in_array(9, json_decode(roles(),false)))
                  <td>
                  <a class="btn btn-info btn-sm" href="{{url ('currency/update/'.$currency->id) }}"><i class= "fa fa-edit"></i> Update </a>
                  </td>
                @endif
                @if(roles() != "" && in_array(10, json_decode(roles(),false)))
                  <td>
                  <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmDelete({{$currency->id}})"><i class= "fa fa-minus-circle"></i> Delete</a>
                  </td>
                @endif 
              </tr>
            @endforeach
          </tbody>
        </table>
      </div><br>
      {{ $currencies -> links() }}
    </div>
  </div>

  <script>
    function confirmDelete(id){
      var result = confirm("Are you confirm to delete?");
      if (result) {
          window.location = 'currency/delete/'+id
      }
    }
  </script>

@endsection