@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('voucher-formats') }}">Voucher Format</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Voucher Formats</h4>
    </div>
    <div style="float:right">
      @if(roles() != "" && in_array(26, json_decode(roles(),false)))
        <a href="{{ url('voucher-formats/add') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add Format</a>
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
              <th class="wd-5p text-center">Sl</th>
              <th class="wd-20p">Title</th>
              <th class="wd-35p text-center">Type</th>
              <th class="wd-20p text-center">Default</th>
              @if(roles() != "" && (in_array(26, json_decode(roles(),false))  || in_array(27, json_decode(roles(),false))  || in_array(28, json_decode(roles(),false))))
              <th class="wd-20p text-center">Update</th>
              <th class="wd-20p text-center">Delete</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($voucher_formats as $voucher_format)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $voucher_format->title }}</td>
                <td class="text-center">{{ $voucher_format->type }}</td>
                <td class="text-center">
                  @if($voucher_format->default == 1)
                    <span class="badge badge-success">Default</span>
                  @endif
                </td>
                <td class="text-center">
                  <a class="btn btn-info btn-sm" href="{{url('voucher-formats/update/'.$voucher_format->id)}}"><i class="fa fa-edit"></i> Update </a>
                </td>
                <td class="text-center">
                  <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmDelete({{$voucher_format->id}})"><i class= "fa fa-minus-circle"></i> Delete </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div><br>
      {{ $voucher_formats -> links() }}
    </div>
  </div>

  <script>
    function confirmDelete(id){
      var result = confirm("Are you confirm to delete?");
      if (result) {
          window.location = 'voucher-formats/delete/'+id
      }
    }
  </script>

@endsection