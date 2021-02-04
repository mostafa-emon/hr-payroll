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
            <li class="breadcrumb-item"><a href="{{url('/deposit-salary-tax')}}" style="color:#6c757d; font-weight: bold">Deposit Salary Tax</a></li>
            <li class="breadcrumb-item active"><a href="{{url('/deposit-salary-tax/add')}}" style="color:#6c757d;">Add</a></li>
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
                            <h4 class="card-title mg-b-0">ADD Deposit Salary Tax</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('deposit-salary-tax/add')}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div class="row row-xs">
                                            <div class="col-md-6 mg-t-10">
                                                <label for="From Month" style="font-weight:bold;" class="col-form-label">From Month*:</label>
                                                <input type="text" name="from" class="form-control monthpicker" autocomplete="off" placeholder="From Month" required>
                                            </div>
                                            <div class="col-md-6 mg-t-10">
                                                <label for="To Month" style="font-weight:bold;" class="col-form-label">To Month*:</label>
                                                <input type="text" name="to" class="form-control monthpicker" autocomplete="off" placeholder="To Month" required>
                                            </div>
                                            <div class="col-md-12 mg-t-10">
                                                <label for="Text 1" style="font-weight:bold;" class="col-form-label">যাহার মারফত প্রদান হইল তাহার নাম ও ঠিকানা।*:</label>
                                                <textarea class="form-control" rows="4" placeholder="যাহার মারফত প্রদান হইল তাহার নাম ও ঠিকানা........" name="text_1" type="text"></textarea>
                                            </div>
                                            <div class="col-md-12 mg-t-15">
                                                <label for="Text 2" style="font-weight:bold;" class="col-form-label">যে ব্যক্তির/প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম, পদবী ও ঠিকানা।*:</label>
                                                <textarea class="form-control" rows="4" placeholder="যে ব্যক্তির/প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম, পদবী ও ঠিকানা......." name="text_2" type="text"></textarea>
                                            </div>
                                            <div class="col-md-12 mg-t-15">
                                                <label for="Text 3" style="font-weight:bold;" class="col-form-label">কি বাবদ জমা দেওয়া হইল তাহার বিবরণ।*:</label>
                                                <textarea class="form-control" rows="4" placeholder="কি বাবদ জমা দেওয়া হইল তাহার বিবরণ........" name="text_3" type="text"></textarea>
                                            </div>
                                            <div class="col-md-12 mg-t-15">
                                                <label for="Text 4" style="font-weight:bold;" class="col-form-label">মুদ্রা ও নোটের বিবরণ/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ।*:</label>
                                                <div class="ql-wrapper ql-wrapper-demo bg-gray-100">
                                                    <textarea class="form-control" rows="4" placeholder="মুদ্রা ও নোটের বিবরণ/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ........" name="text_4" type="text"></textarea>
                                                </div>
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
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'text_1' );
        CKEDITOR.replace( 'text_2' );
        CKEDITOR.replace( 'text_3' );
        CKEDITOR.replace( 'text_4' );
    </script>

@endsection