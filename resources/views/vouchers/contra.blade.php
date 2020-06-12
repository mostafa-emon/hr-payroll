@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('voucher-contra-voucher') }}">Contra Voucher</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Contra Voucher</h4>
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
              <th class="text-center wd-5p">Sl</th>
              <th class="wd-20p">Name</th>
              <th class="text-center wd-15p">Top</th>
              <th class="text-center wd-15p">Left</th>
              <th class="text-center wd-15p">Rotate</th>
              @if(roles() != "" && in_array(51, json_decode(roles(),false)))
              <th class="text-center wd-15p">Update</th>
              @endif

              @if(roles() != "" && in_array(52, json_decode(roles(),false)))
              <th class="text-center wd-15p">Delete</th>
              @endif
            </tr>
          </thead>
          <tbody>
            {{--@foreach($printers as $printer)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $printer->print_name }}</td>
                <td class="text-center">{{ $printer->top }}</td>
                <td class="text-center">{{ $printer->left }}</td>
                <td class="text-center">{{ $printer->rotate }}</td>
                @if(roles() != "" && in_array(51, json_decode(roles(),false)))
                  <td class="text-center">
                    <a class="btn btn-info btn-sm" href="{{url ('printer/update/'.$printer->id) }}"><i class= "fa fa-edit"></i> Update </a>
                  </td>
                @endif
                @if(roles() != "" && in_array(52, json_decode(roles(),false)))
                  <td class="text-center">
                    <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmDelete({{$printer->id}})"><i class= "fa fa-minus-circle"></i> Delete</a>
                  </td>
                @endif
              </tr>
            @endforeach--}}
          </tbody>
        </table>
      </div><br>
    </div>
  </div>

  <script>
    function confirmDelete(id){
      var result = confirm("Are you confirm to delete?");
      if (result) {
          window.location = 'printer/delete/'+id
      }
    }
  </script>

@endsection