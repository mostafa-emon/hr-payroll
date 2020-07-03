@extends('layouts.master')

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/mail-setup') }}">Email</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Email</h4>
  </div>

  <form action="{{ url('money-receipt-email') }}" id="myform" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">

        @if(session()->has('message'))
          @if(session()->get('message') == "Message sent Succesfully!")
          <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{ session()->get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @elseif(session()->get('message') == "Error sending mail!")
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session()->get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @else
          <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{ session()->get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

        @endif

        <div class="form-layout form-layout-2">
          <div class="form-layout form-layout-2" id="sendDetails">
            <div class="row no-gutters">
  
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Email To:</label>
                  <input class="form-control" type="text" name="email_to" placeholder="test mail to" value="{{ old('email_to') }}">
                </div>
              </div>
  
              <div class="col-md-6">
                <div class="form-group mg-md-l--1">
                  <label class="form-control-label">Subject:</label>
                  <input class="form-control" type="text" name="email_subject" placeholder="Subject" value="@if(isset($email->subject)){{ $email->subject }}@endif">
                </div>
              </div>
  
              <div class="col-md-12">
                <div class="form-group bd-t-0-force">
                  <label class="form-control-label">Body:</label>
                  <textarea class="form-control" type="text" id="editor1" name="editor1" rows="5" placeholder="Start Typing.......">@if(isset($email->body)){!! $email->body !!}@endif</textarea>
                  <input type="hidden" name="send_as_attachment" value="0">
                </div>
              </div>
  
            </div>
            <br>
            <div class="row">
              <div class="col-md-12 text-right">
                <input type="hidden" name="api_type" value="{{$api_type}}"/>
                <input type="hidden" name="document_id" value="{{$document_id}}"/>
                <input type="submit" class="btn btn-info btn-sm pointer" value="Send" style="width:100px"/>
              </div>
            </div>

        </div>
      </div>
    </div>
  </form>
  
  <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace( 'editor1' );
  </script>
@endsection