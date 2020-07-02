@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('cheque-layouts') }}">Cheque Format</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Cheque Formats</h4>
    </div>
    <div style="float:right">
      @if(roles() != "" && in_array(23, json_decode(roles(),false)))
        <a href="{{ url('cheque-layouts/add') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add Layout</a>
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
              <th class="wd-40p">Bank</th>
              <th class="wd-15p text-center">Height</th>
              <th class="wd-15p text-center">Width</th>
              @if(roles() != "" && (in_array(24, json_decode(roles(),false))  || in_array(25, json_decode(roles(),false)) ))
              <th class="wd-25p text-center">Action</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($cheque_layouts as $cheque_layout)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $cheque_layout->bank_name }}</td>
                <td class="text-center">{{ $cheque_layout->height }}</td>
                <td class="text-center">{{ $cheque_layout->width }}</td>
                <td class="text-center">
                  @if(roles() != "" && in_array(24, json_decode(roles(),false)))
                    <a class="btn btn-info btn-sm" href="{{url ('cheque-layouts/duplicate/'.$cheque_layout->id) }}"><i class= "fa fa-copy"></i> Duplicate </a>
                  @endif
                  @if(roles() != "" && in_array(24, json_decode(roles(),false)))
                    <a class="btn btn-warning btn-sm" href="{{url ('cheque-layouts/update/'.$cheque_layout->id) }}"><i class= "fa fa-edit"></i> Update </a>
                  @endif
                  @if(roles() != "" && in_array(25, json_decode(roles(),false)))
                    <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmDelete({{$cheque_layout->id}})"><i class= "fa fa-minus-circle"></i> Delete</a>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div><br>
      {{ $cheque_layouts -> links() }}
    </div>
  </div>

  <script>
    function confirmDelete(id){
      var result = confirm("Are you confirm to delete?");
      if (result) {
          window.location = 'cheque-layouts/delete/'+id
      }
    }
  </script>

@endsection