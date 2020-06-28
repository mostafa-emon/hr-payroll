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

  <form action="{{ url('mail-setup/update') }}" id="myform" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">

        @if(session()->has('message'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          {{ session()->get('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group">
                <label class="form-control-label mg-b-0-force">Mail Driver: <span class="tx-danger">*</span></label>
                <select name="mail_driver" class="form-control mg-l--4" required>
                  <option>smtp</option>
                </select>
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Host: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="host_name" placeholder="Host Name" value="@isset($emails){{$emails->host_name}}@endisset" required>
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Port: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="port_name" placeholder="Port Name" value="@isset($emails){{$emails->port_name}}@endisset" required>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">User Name: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="user_name" placeholder="User Name" value="@isset($emails){{$emails->user_name}}@endisset" required>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Password: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="password" placeholder="Enter Password" value="@isset($emails){{$emails->password}}@endisset" required>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Encryption: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="encryption" placeholder="tsl/ssl" value="@isset($emails){{$emails->encryption}}@endisset">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">From Address: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="from_address" placeholder="From Address" value="@isset($emails){{$emails->from_address}}@endisset" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">From Name: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="from_name" placeholder="From Name" value="@isset($emails){{$emails->from_name}}@endisset" required>
              </div>
            </div>

          </div>

          <div class="row pd-t-10 pd-b-20 text-right">
            <div class="col-md-6 text-left">
              <a href="javascript:void(0)" onclick="saveSettings()" class="btn btn-info pointer">Save Settings</a>
            </div>
            <div class="col-md-6">
              <a href="javascript:void(0)" onclick="showSendDetails()" class="btn btn-info pointer">Send Test Email</a>
            </div>
          </div>

          <div class="form-layout form-layout-2" id="sendDetails" style="display:none">
            <div class="row no-gutters">
  
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Email To:</label>
                  <input class="form-control" type="text" name="email_to" placeholder="Email To">
                </div>
              </div>
  
              <div class="col-md-6">
                <div class="form-group mg-md-l--1">
                  <label class="form-control-label">Subject:</label>
                  <input class="form-control" type="text" name="email_subject" placeholder="Subject">
                </div>
              </div>
  
              <div class="col-md-12">
                <div class="form-group bd-t-0-force">
                  <label class="form-control-label">Message:</label>
                  <textarea class="form-control" type="text" id="editor1"  name="editor1" rows="5" placeholder="Start Typing......."></textarea>
                  
                  <div class="pd-t-10">
                    <label class="ckbox pointer">
                      <input type="checkbox" name="send_as_attachment" value="1"><span>Send as attachment</span>
                    </label>
                  </div>
                </div>
              </div>
  
            </div>

          <div class="form-layout-footer bd pd-20 bd-t-0 text-right">
            <a href="javascript:void(0)" onclick="sendMail()" class="btn btn-success btn-sm pointer">Send</a>
          </div>


        </div>
      </div>
    </div>
    <input type="hidden" name="job"/>
  </form>
  
  <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace( 'editor1' );
    function showSendDetails(){
      $('#sendDetails').show();
    }

    function saveSettings() {
      $('#job').val('savesettings');
      $('#myform').submit();
    }

    function sendMail() {
      $('#job').val('sendmail');
      $('#myform').submit();
    }
  </script>
@endsection