@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/printer') }}">Printer</a>
      <span class="breadcrumb-item active">Update</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Update Printer</h4>
  </div>

  <form action="{{ url('printer/update/'.$printers->id) }}" method="POST">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">

            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">Printer Name: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="print_name" placeholder="Enter Printer Name" value="{{$printers->print_name}}">
              </div>
            </div>

            <div class="col-md-6 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Top: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="top" placeholder="Enter Top" value="{{$printers->top}}">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Left: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="left" placeholder="Enter Left" value="{{$printers->left}}">
              </div>
            </div>

            <div class="col-md-6 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Rotate: <span class="tx-danger">*</span></label>
                <select id="select2-a" class="form-control mg-l--4" name="rotate" data-placeholder="Rotate">
                  <option value="0" @if($printers->rotate == "0") selected @endif>0 Degree</option>
                  <option value="90" @if($printers->rotate == "90") selected @endif>90 Degree</option>
                  <option value="180" @if($printers->rotate == "180") selected @endif>180 Degree</option>
                  <option value="270" @if($printers->rotate == "270") selected @endif>270 Degree</option>
                </select>
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

@endsection