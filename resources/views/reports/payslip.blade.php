@extends('layouts.master')

@section('content')

        <style>
            .ui-datepicker-calendar {
                display: none;
            }
            .ui-datepicker-prev {
                display: none;
            }
            .ui-datepicker-next {
                display: none;
            }
        </style>

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/payslip-report')}}" style="color:#6c757d;">Pay Slip Report</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
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

                    @if(session()->has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Pay Slip Report</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if(count($employment_infos) > 0)
                                <a href="{{url('payslip-report')}}" class="btn btn-info">Reset</a>
                            @endif
                        </div>
                    </div>
                    <hr>
                    @if(count($employment_infos) == 0)
                    <form action="{{ url('payslip-report') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3" style="display:none;">
                                <input type="text" class="form-control" name="job" value="1"/>
                            </div>
                            <div class="col-md-6">
                                <label for="Department" style="font-weight:bold;" class="col-form-label">Department:</label>
                                <select name="department_id" id="department_id" class="form-control select2-no-search" @if(count($employment_infos) > 0) disabled @endif>
                                        <option label="All"></option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" @if($department_id == $department->id) selected @endif>{{$department->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="Designation" style="font-weight:bold;" class="col-form-label">Designation:</label>
                                <select name="designation_id" id="designation_id" class="form-control select2-no-search" @if(count($employment_infos) > 0) disabled @endif>
                                        <option label="All"></option>
                                        @foreach($designations as $designation)
                                            <option value="{{$designation->id}}" @if($designation_id == $designation->id) selected @endif>{{$designation->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="Currency" style="font-weight:bold;" class="col-form-label">Currency:</label>
                                <select name="currency_id" id="currency_id" class="form-control select2-no-search" @if(count($employment_infos) > 0) disabled @endif>
                                        <option label="All"></option>
                                        @foreach($currencies as $currency)
                                            <option value="{{$currency->id}}" @if($currency_id == $currency->id) selected @endif>{{$currency->currency_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="Month" style="font-weight:bold;" class="col-form-label">Month:</label>
                                <input type="text" name="date" class="form-control monthpicker" autocomplete="off" placeholder="Month" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                    </form>
                    @endif

                    @if(count($employment_infos) > 0)
                        <div class="card-body" id="printArea">
                            <div class="div-padding-30">
                                @include('reports.exports.payslip_list_table',$employment_infos)

                                <div class="table-responsive">
                                    <table style="width:100%;">
                                        <tr>
                                        <td colspan="1" style="padding-top:75px;padding-bottom:15px;border:none;">
                                            <div style="text-align:center;">__________________<br>Prepared By</div>
                                        </td>
                                        <td colspan="2" style="padding-top:75px;padding-bottom:15px;border:none;">
                                            <div style="text-align:center;">__________________<br>Checked By</div>
                                        </td>
                                        <td colspan="1" style="padding-top:75px;padding-bottom:15px;border:none;">
                                            <div style="text-align:center;">__________________<br>Approved By</div>
                                        </td>
                                        </tr>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    @endif

                </div>
                
            </div>
        </div>

    </div>

    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            font-family:arial;
            font-size:13px;
            padding:5px;
        }
    </style>
    
    <script>

        function printElem(){
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