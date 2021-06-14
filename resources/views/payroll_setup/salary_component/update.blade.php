@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/salary-components')}}" style="color:#6c757d; font-weight: bold">Salary Component</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/salary-components/update/'.$salary->id)}}" style="color:#6c757d;">Update</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Update Salary Component</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('salary-components/update/'.$salary->id)}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div class="pd-30 pd-sm-40 bg-gray-200">
                                            <div class="row row-xs">

                                                <div class="col-md-6 mg-t-10">
                                                    <label for="component_type" class="col-form-label">Component Type:</label>
                                                    <select id="component_type" name="component_type" onclick="hideShowElement(this.value)" class="form-control select2-no-search pa" required>
                                                        <option label="Choose One"></option>
                                                        <option value="Earnings" @if($salary->component_type == "Earnings") selected @endif>Earnings</option>
                                                        <option value="Deduction" @if($salary->component_type == "Deduction") selected @endif>Deduction</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mg-t-10">
                                                    <label for="component_name" class="col-form-label">Component Name:</label>
                                                    <input class="form-control" name="component_name" placeholder="Enter Name" value="{{$salary->component_name}}" type="text" required>
                                                </div>

                                                <div @if($salary->component_type == "Deduction") style="display:none;" @endif id="for_earnings" class="@if($company->quickbooks != 1)col-md-12 @else col-md-6 @endif mg-t-10">
                                                    <label for="reference_1" class="col-form-label">Reference:</label>
                                                    <select id="reference_1" name="reference_1" class="form-control select2-no-search pa">
                                                        <option label="Choose One"></option>
                                                        <option value="Basic Salary" @if($salary->component_reference == "Basic Salary") selected @endif>Basic Salary</option>
                                                        <option value="House Rent" @if($salary->component_reference == "House Rent") selected @endif>House Rent</option>
                                                        <option value="Convenience" @if($salary->component_reference == "Convenience") selected @endif>Conveyance</option>
                                                        <option value="Medical" @if($salary->component_reference == "Medical") selected @endif>Medical</option>
                                                        {{--<option value="Festival Bonus" @if($salary->component_reference == "Festival Bonus") selected @endif>Festival Bonus</option>--}}
                                                        <option value="PF Company Portion" @if($salary->component_reference == "PF Company Portion") selected @endif>PF Company Portion</option>
                                                        <option value="Gratuity" @if($salary->component_reference == "Gratuity") selected @endif>Gratuity</option>
                                                        <option value="General Earnings" @if($salary->component_reference == "General Earnings") selected @endif>General Earnings</option>
                                                    </select>
                                                </div>

                                                <div @if($salary->component_type == "Earnings") style="display:none;" @endif id="for_deduction" class="@if($company->quickbooks != 1)col-md-12 @else col-md-6 @endif mg-t-10">
                                                    <label for="reference_2" class="col-form-label">Reference:</label>
                                                    <select id="reference_2" name="reference_2" class="form-control select2-no-search pa">
                                                        <option label="Choose One"></option>
                                                        <option value="Income Tax" @if($salary->component_reference == "Income Tax") selected @endif>Income Tax</option>
                                                        <option value="PF Employee Portion"  @if($salary->component_reference == "PF Employee Portion") selected @endif>PF Employee Portion</option>
                                                        <option value="General Deduction" @if($salary->component_reference == "General Deduction") selected @endif>General Deduction</option>
                                                    </select>
                                                </div>

                                                @if($company->quickbooks == 1)
                                                    <div class="col-md-6 mg-t-10">
                                                        <label for="quickbooks_ledger" class="col-form-label">QuickBooks Ledger:</label>
                                                        <select id="quickbooks_ledger" name="quickbooks_ledger" class="form-control select2-no-search pa" required>
                                                            <option label="Choose One"></option>
                                                            <option value="General Earnings" @if($salary->quickbooks_ledger == "General Earnings") selected @endif>General Earnings</option>
                                                            <option value="General Deduction" @if($salary->quickbooks_ledger == "General Deduction") selected @endif>General Deduction</option>
                                                        </select>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="row pd-t-10">
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
        </div>

    </div>

    <script>

        function hideShowElement(value) {
            if(value == "Deduction") {
                $('#for_deduction').show();
                $('#for_earnings').hide();
            }else{
                $('#for_earnings').show();
                $('#for_deduction').hide();
            }
        }
    </script>

@endsection