@extends('layouts.master')

@section('content')

    <div class="row mb-2">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('/smtp-settings')}}" style="color:#6c757d;">SMTP Settings</a></li>
        </ol>
        </div>
    </div>

    <div style="margin-top:-20px;margin-bottom:15px;" class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">SMTP Settings</h4>
            </div>
        </div>
    </div>

    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card  box-shadow-0">
                <div class="card-header">
                </div>
                <div class="card-body pt-0">
                    @if(session()->has('message'))
                        @if(session()->get('message') == "Message sent Succesfully!")
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                    @endif
                    <form class="form-horizontal" action="{{ url('mail-setup/update') }}" id="myform" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="col-form-label" style="font-size:15px;color:#3b5998;">Mail Driver:</label>
                                        <select name="mail_driver" class="form-control" required>
                                            <option>smtp</option>
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="col-form-label" style="font-size:15px;color:#3b5998;">Host:</label>
                                    <input class="form-control" type="text" name="host_name" placeholder="Host Name" value="@if(old('host_name') != ""){{old('host_name')}}@elseif(isset($emails)){{$emails->host_name}}@endif" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="col-form-label" style="font-size:15px;color:#3b5998;">Port:</label>
                                    <input class="form-control" type="text" name="port_name" placeholder="Port Name" value="@if(old('port_name') != ""){{old('port_name')}}@elseif(isset($emails)){{$emails->port_name}}@endif" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="col-form-label" style="font-size:15px;color:#3b5998;">User Name:</label>
                                    <input class="form-control" type="text" name="user_name" placeholder="User Name" value="@if(old('user_name') != ""){{old('user_name')}}@elseif(isset($emails)){{$emails->user_name}}@endif" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="col-form-label" style="font-size:15px;color:#3b5998;">Password:</label>
                                    <input class="form-control" type="text" name="password" placeholder="Enter Password" value="@if(old('password') != ""){{old('password')}}@elseif(isset($emails)){{$emails->password}}@endif" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="col-form-label" style="font-size:15px;color:#3b5998;">Encryption:</label>
                                    <select class="form-control" name="encryption">
                                        <option value="tls" @if(old('encryption') != "" && old('encryption') == "tls") selected @elseif(isset($emails) && $emails->encryption == "tls") selected @endif>tls</option>
                                        <option value="ssl" @if(old('encryption') != "" && old('encryption') == "ssl") selected @elseif(isset($emails) && $emails->encryption == "ssl") selected @endif>ssl</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-form-label" style="font-size:15px;color:#3b5998;">From Name:</label>
                                    <input class="form-control" type="text" name="from_name" placeholder="From Name" value="@if(old('from_name') != ""){{old('from_name')}}@elseif(isset($emails)){{$emails->from_name}}@endif" required>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row" id="sendDetails">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="col-form-label" style="font-size:15px;color:#3b5998;">Send Mail To:</label>
                                    <input class="form-control" type="text" name="email_to" placeholder="Mail To" value="{{ old('email_to') }}">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="name" class="col-form-label" style="font-size:15px;color:#3b5998;">Subject:</label>
                                    <input class="form-control" type="text" name="email_subject" placeholder="Subject" value="@if(old('email_subject') != ""){{old('email_subject')}}@elseif(isset($emails)){{$emails->subject}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="col-form-label" style="font-size:15px;color:#3b5998;">Send As Attachment:</label>
                                    <select class="form-control" name="send_as_attachment">
                                        <option value="1" @if(old('send_as_attachment') != "" && old('send_as_attachment') == "1") selected @endif>Yes</option>
                                        <option value="0" @if(old('send_as_attachment') != "" && old('send_as_attachment') == "0") selected @endif>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-form-label" style="font-size:15px;color:#3b5998;">Body:</label>
                                    <textarea class="form-control" type="text" id="editor1" name="editor1" rows="5" placeholder="Start Typing.......">@if(old('editor1') != ""){{old('editor1')}}@elseif(isset($emails)){{$emails->body}}@endif</textarea>
                                    <input type="hidden" id="job" name="job"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0 mt-3 justify-content-end">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="javascript:void(0)" onclick="saveSettings()" class="btn btn-primary pointer">Save Settings</a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="javascript:void(0)" onclick="sendMail()" class="btn btn-primary pointer"><i class="fa fa-paper-plane"></i>	&nbsp;Send Email</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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