@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('deductions-adjustment')}}" style="color:#6c757d;">Deductions Adjustment</a></li>

            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6" style="padding-top:15px">
                        </div>
    
                        @if($print == "Print")
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary" onclick="printElem()">Print</button>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div id="printArea">
                        @php 
                        $employee = get_employee_info($deduction->employee_id);
                        @endphp
                        <div class="div-padding-30">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="4" style="font-size:17px;text-align:center;border:none">{{get_company_name(Auth::user()->company_id)}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style="font-size:16px;text-align:center;border:none">Employee Name: {{$employee->name}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style="font-size:16px;text-align:center;border:none">Employee ID: {{$employee->employee_id}}</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align:center;">Sl</th>
                                        <th style="text-align:center;">Applicable Month</th>
                                        <th style="text-align:center;">Applicable Year</th>
                                        <th style="text-align:center;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align:center;">1</td>
                                        <td style="text-align:center;">{{$deduction->month}}</td>
                                        <td style="text-align:center;">{{$deduction->year}}</td>
                                        <td style="text-align:center;">{{$deduction->amount}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div style="margin-top:25px;font-size:16px;">
                                <div style="font-weight:bold;">Note:</div> {{$deduction->note}}
                            </div>
                        </div>

                    </div>
                    @if($print == "")
                    <div style="margin-top:25px;font-size:16px;">
                        <div style="font-weight:bold;">Attachment:</div>
                        <a href="{{asset('storage/'.$deduction->attach_file)}}" target="_blank">Show File</a>
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

            }, 1000);
        }

    </script>

@endsection