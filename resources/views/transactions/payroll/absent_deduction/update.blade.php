@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/absent-deduction')}}" style="color:#6c757d; font-weight: bold">Absent Deduction</a></li>
                <li class="breadcrumb-item active"><a href="{{url('absent-deduction/update/'.$deduction->id)}}" style="color:#6c757d;">Update</a></li>
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
                    
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Update Absent Deduction</h4>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <form method="post" action="{{url('absent-deduction/update/'.$deduction->id)}}">
                            {{ csrf_field() }}

                            <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width:25%;">Employee Name</th>
                                        <th class="text-center" style="width:20%;">Employee ID</th>
                                        <th class="text-center" style="width:25%;">Total Absent Days</th>
                                        <th class="text-center" style="width:25%;">Total Deduction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $employee = get_employee_info($deduction->employee_id); @endphp
                                    <tr>
                                        <td style="vertical-align: middle;" class="text-center">{{$employee->name}}</td>
                                        <td style="vertical-align: middle;" class="text-center">
                                            {{$employee->employee_id}}
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <input type="text" id="total_absent_days" name="total_absent_days" class="form-control" value="{{$deduction->total_absent_days}}" oninput="calculateTotalDeduction()" required/>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <input type="hidden" id="per_day_salary" name="per_day_salary" class="form-control" value="{{round($deduction->deduction / $deduction->total_absent_days)}}"/>
                                            <input type="text" id="deduction" name="deduction" class="form-control" value="{{$deduction->deduction}}" readonly/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pd-t-15 text-center">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Submit"/>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
    
    <script>

    function calculateTotalDeduction() {
        var per_day_salary = $("#per_day_salary").val();
        var total_absent_days = $("#total_absent_days").val();
        var total = per_day_salary * total_absent_days;
        $("#deduction").val(total);
    }

    </script>

@endsection