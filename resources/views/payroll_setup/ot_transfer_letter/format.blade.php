@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/ot-transfer-letter-format')}}" style="color:#6c757d;">OT Transfer Letter Format</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        @if($format != "")
            <div id="printArea" class="collapse">
                <div style="font-size: 14px; font-family: Arial, Helvetica, sans-serif">{!! $format->top_text !!}</div>
                <div style="padding-top:40px;padding-bottom:40px;">
                    <table style="width:100%">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Bank</th>
                            <th>Branch</th>
                            <th>Account No.</th>
                            <th>Amount in TK</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>110049</td>
                            <td>Demo Employee</td>
                            <td>Demo Designation</td>
                            <td>Demo Bank</td>
                            <td>Demo Branch</td>
                            <td>111222333444</td>
                            <td>50,000</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div style="font-size: 14px; font-family: Arial, Helvetica, sans-serif">{!! $format->bottom_text !!}</div>
            </div>
        @endif

        <!--div-->
        <div class="col-xl-12">
            <form action="{{url('ot-transfer-letter-format')}}" method="POST">
                {{ csrf_field() }}
            <div class="card">

                <div class="card-header">
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">OT Transfer Letter Top</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if($format != "")
                            <a href="javascript:void(0)" onclick="printElem()" class="btn btn-info">Demo</a>&nbsp;
                            @endif
                            <input type="submit" class="btn btn-success" value="Update"/>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="ql-wrapper ql-wrapper-demo bg-gray-100">
                        <textarea name="editor1">@if($format != ""){{$format->top_text}}@endif</textarea>
                    </div>
                </div>

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">OT Transfer Letter Bottom</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="ql-wrapper ql-wrapper-demo bg-gray-100">
                        <textarea name="editor2">@if($format != ""){{$format->bottom_text}}@endif</textarea>
                    </div>
                </div>
            </div>
            </form>
        </div>

    </div>
    
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'editor1' );
        CKEDITOR.replace( 'editor2' );

        function printElem() {
            var mywindow = window.open('', 'PRINT');
            mywindow.document.write('<style>table {border-collapse: collapse;} th, td {border: 1px solid black;font-family:arial;font-size:13px;padding:7px;} .div-padding-30{padding:30px;}</style>');
            mywindow.document.write(document.getElementById('printArea').innerHTML);

            setTimeout(function () {
                mywindow.focus();
                mywindow.print();
                mywindow.close();

                //window.location = "/mr"
            }, 1000);
        }
    </script>
@endsection
