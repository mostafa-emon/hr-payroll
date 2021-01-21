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
            <li class="breadcrumb-item"><a href="{{url('/salary-sheet')}}" style="color:#6c757d; font-weight: bold">Salary Sheet</a></li>
            <li class="breadcrumb-item active"><a href="{{url('/salary-sheet/create')}}" style="color:#6c757d;">Create</a></li>
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
                            <h4 class="card-title mg-b-0">Create Salary Sheet</h4>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('salary-sheet/create') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="salary_month" class="form-control monthpicker" autocomplete="off" placeholder="Salary Month">
                            </div>
                            <div id="festival_bonus" class="col-md-4">
                                <select name="festival_bonus" class="form-control" onchange="hide_show_element(this.value)">
                                    <option value="" label>Festival Bonus</option>
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                            </div>
                            <div id="religion" style="display:none;" class="col-md-4">
                                <select class="form-control" name="religion">
                                    <option value="" label>Religion*</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Christianity">Christianity</option>
                                    <option value="Hinduism">Hinduism</option>
                                    <option value="Buddhism">Buddhism</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 text-left" style="margin-top:10px;">
                                <input type="checkbox" name="confirmation_check" style="width: 20px; height: 20px;" value="1"/>
                                <div style="margin-top:-26px;padding-left:25px;">I confirm that I have given all thing correct</div>
                            </div>

                            <br>

                            <div class="col-md-1 text-center">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                    </form>

                </div>
                
            </div>
        </div>

    </div>
    
    <script>

        function hide_show_element(value) {
            if(value == "1") {
                $('#religion').show();
            }else{
                $('#religion').hide();
            }
        }

    </script>

@endsection