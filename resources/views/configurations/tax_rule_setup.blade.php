@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/general-settings')}}" style="color:#6c757d;">Tax Rule Setup</a></li>
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

                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Tax Rule Setup</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
                            <form method="POST" action="{{url('tax-rule-setup/update')}}">
                                {{ csrf_field() }}
                                <div class="card">
                                    <div class="card-body">
                                        <div style="font-weight:bold;font-size:18px;text-align:center;">
                                            Salary Tax (TDS) Calculation Rules
                                        </div>

                                        <div style="font-weight:bold;text-align:center;padding-top:8px;">
                                            [As Per ITO-1984, U/S-21, Schedule-24/A]
                                        </div>

                                        <div style="padding:2px;padding-top:5px;">
                                            <b>Income Year &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b>
                                            <input type="text" name="income_year">
                                        </div>

                                        <div style="padding:2px;padding-top:5px;">
                                            <b>Assesment Year &nbsp;:</b>
                                            <input type="text" name="income_year">
                                        </div>
                                        <br>

                                        <div style="font-weight:bold;">
                                            Table-1. Calculation of Taxable Income:
                                        </div>

                                        <div class="table-responsive">
                                            <table style="width: 100%;border-collapse: collapse;">
                                                <tr>
                                                    <th style="border: 1px solid black;text-align:center;">Component Name</th>
                                                    <th colspan="6" style="border: 1px solid black;text-align:center;">Present Tax Rule</th>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:left;">Basic Salary</td>
                                                    <td colspan="6" style="border: 1px solid black;text-align:center;">Full Amount is Taxable</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:left;">House Rent Allowance</td>
                                                    <td style="border: 1px solid black;text-align:left;">Non-Taxable Limit is</td>
                                                    <td style="border: 1px solid black;text-align:center;">BDT</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;font-weight:bold;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;">or</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;font-weight:bold;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:left;">of Basic Salary-Whichever is Lower</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:left;">Conveyance Allowance</td>
                                                    <td style="border: 1px solid black;text-align:left;">Non-Taxable Limit is</td>
                                                    <td style="border: 1px solid black;text-align:center;">BDT</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;font-weight:bold;" name="income_year" value="Actual"></td>
                                                    <td style="border: 1px solid black;text-align:center;">or</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;font-weight:bold;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:left;">Per Year-Whichever is Lower</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:left;">Medical Allowance</td>
                                                    <td style="border: 1px solid black;text-align:left;">Non-Taxable Limit is</td>
                                                    <td style="border: 1px solid black;text-align:center;">BDT</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;font-weight:bold;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;">or</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;font-weight:bold;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:left;">of Basic Salary-Whichever is Lower</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:left;">Festival Bonuses</td>
                                                    <td colspan="6" style="border: 1px solid black;text-align:center;">Full Amount is Taxable</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:left;">PF (Company Portion)</td>
                                                    <td colspan="6" style="border: 1px solid black;text-align:center;">Full Amount is Taxable</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:left;">Other (If Any)</td>
                                                    <td colspan="6" style="border: 1px solid black;text-align:center;">Full Amount is Taxable</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <br>

                                        <div style="font-weight:bold;">
                                            Table-2: Final Tax Amount Calculation:
                                        </div>
                                        <div class="table-responsive">
                                            <table style="width: 100%;border-collapse: collapse;">
                                                <tr>
                                                    <th rowspan="2" style="border: 1px solid black;text-align:center;vertical-align: middle;">Sl <br> No</th>
                                                    <th rowspan="2" style="border: 1px solid black;text-align:center;vertical-align: middle;">Slab</th>
                                                    <th colspan="2" style="border: 1px solid black;text-align:center;vertical-align: middle;">Total Income</th>
                                                    <th rowspan="2" style="border: 1px solid black;text-align:center;vertical-align: middle;">Tax Rate</th>
                                                </tr>
                                                <tr>
                                                    <th style="border: 1px solid black;text-align:center;vertical-align: middle;">For Below 65 Aged Male</th>
                                                    <th style="border: 1px solid black;text-align:center;vertical-align: middle;">For Female & 65+ Aged Male</th>
                                                </tr>

                                                <tr>
                                                    <td style="border: 1px solid black;text-align:center;">1</td>
                                                    <td style="border: 1px solid black;text-align:center;">First</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:center;">2</td>
                                                    <td style="border: 1px solid black;text-align:center;">Next</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:center;">3</td>
                                                    <td style="border: 1px solid black;text-align:center;">Next</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:center;">4</td>
                                                    <td style="border: 1px solid black;text-align:center;">Next</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:center;">5</td>
                                                    <td style="border: 1px solid black;text-align:center;">Next</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;text-align:center;">6</td>
                                                    <td style="border: 1px solid black;text-align:center;">Rest</td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                    <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <br>

                                        <div style="font-weight:bold;">
                                            Table-3: Calculation of Investment Allowance
                                        </div>
                                        <table style="width: 100%;border-collapse: collapse;">
                                            <tr>
                                                <td style="border: 1px solid black;text-align:center;">A</td>
                                                <td style="border: 1px solid black;text-align:left;">As Per</td>
                                                <td style="border: 1px solid black;text-align:left;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                <td style="border: 1px solid black;text-align:left;">of Total Income (From Table-1)</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;text-align:center;">B</td>
                                                <td style="border: 1px solid black;text-align:left;">As Per</td>
                                                <td colspan="2" style="border: 1px solid black;text-align:left;">Actual Investment Amount Including PF (Both Portion)</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;text-align:center;">C</td>
                                                <td style="border: 1px solid black;text-align:left;">As Per</td>
                                                <td style="border: 1px solid black;text-align:left;">Maximum Investment Amount Allowed BDT</td>
                                                <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                            </tr>
                                        </table>
                                        <table style="width: 100%;border-collapse: collapse;">
                                            <tr>
                                                <td style="border-left: 1px solid black;text-align:left;">Investment Allowance Amount is</td>
                                                <td style="border-left: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                <td style="border-left: 1px solid black;text-align:center;">of the lowest amount of A, B and C (of Table-3), if the Total <br>Taxable Income (from Table-1) is Equal or less than BDT</td>
                                                <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;text-align:left;vertical-align:middle">Investment Allowance Amount is</td>
                                                <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                                <td style="border: 1px solid black;text-align:center;">of the lowest amount of A, B and C (of Table-3), if the Total <br>Taxable Income (from Table-1) is more than BDT</td>
                                                <td style="border: 1px solid black;text-align:center;"><input type="text" style="text-align:center;" name="income_year"></td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                                <div class="row pd-t-15">
                                    <div class="col-md-12 text-center">
                                        <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Submit"/>
                                    </div>
                                </div>
                            </form>
						</div>
					</div>
                </div>
            </div>
        </div>

    </div>

@endsection