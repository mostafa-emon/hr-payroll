@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/settings') }}">Settings</a>
    </nav>
  </div>

  

  <form action="{{ url('settings/update') }}" method="POST" enctype="multipart/form-data">
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
        
        <div class="form-layout form-layout-4">
            <h6 class="mg-b-30 tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">SETTINGS</h6>
            <div class="row">
                <label class="col-sm-3 form-control-label">Voucher Number:</label>
                <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="voucher_number">
                        <option value="manual" @if(isset($settings) && $settings->voucher_number == "manual") selected @endif>Manual</option>
                        <option value="auto" @if(isset($settings) && $settings->voucher_number == "auto") selected @endif>Automatic</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <label class="mg-t-20 col-sm-3 form-control-label">CPV Format:</label>
                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Prefix" class="form-control" name="cash_payment_voucher_prefix" value="{{$settings->cash_payment_voucher_prefix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Suffix" class="form-control" name="cash_payment_voucher_suffix" value="{{$settings->cash_payment_voucher_suffix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Start From" class="form-control" name="cash_payment_voucher_start_from" value="{{$settings->cash_payment_voucher_start_from}}"/>
                </div>

            </div>

            <div class="row">
                <label class="mg-t-20 col-sm-3 form-control-label">BPV Format:</label>
                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Prefix" class="form-control" name="bank_payment_voucher_prefix" value="{{$settings->bank_payment_voucher_prefix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Suffix" class="form-control" name="bank_payment_voucher_suffix" value="{{$settings->bank_payment_voucher_suffix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Start From" class="form-control" name="bank_payment_voucher_start_from" value="{{$settings->bank_payment_voucher_start_from}}"/>
                </div>

            </div>

            <div class="row">
                <label class="mg-t-20 col-sm-3 form-control-label">CRV Format:</label>
                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Prefix" class="form-control" name="cash_receipt_voucher_prefix" value="{{$settings->cash_receipt_voucher_prefix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Suffix" class="form-control" name="cash_receipt_voucher_suffix" value="{{$settings->cash_receipt_voucher_suffix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Start From" class="form-control" name="cash_receipt_voucher_start_from" value="{{$settings->cash_receipt_voucher_start_from}}"/>
                </div>

            </div>

            <div class="row">
                <label class="mg-t-20 col-sm-3 form-control-label">BRV Format:</label>
                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Prefix" class="form-control" name="bank_receipt_voucher_prefix" value="{{$settings->bank_receipt_voucher_prefix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Suffix" class="form-control" name="bank_receipt_voucher_suffix" value="{{$settings->bank_receipt_voucher_suffix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Start From" class="form-control" name="bank_receipt_voucher_start_from" value="{{$settings->bank_receipt_voucher_start_from}}"/>
                </div>

            </div>

            <div class="row">
              <div class="col-md-3" style="margin-top:25px; margin-bottom:7px;font-size:16px"></div>
              <div class="col-sm-9 mg-sm-t-0" style="margin-top:28px; margin-bottom:7px;">
                <div>
                  <input type="checkbox" style="width: 18px; height: 18px;float:left;" name="cash_receipt_voucher_sales_receipt" value="1" @if($settings->cash_receipt_voucher_sales_receipt == 1) checked @endif/>
                  <span style="font-size:16px;padding-left:10px;margin-top:-3px">Create Receipt Voucher from Sales Receipt?</span>
                </div>
              </div>
              
            </div>

            <div class="row">
                <label class="mg-t-20 col-sm-3 form-control-label">CONTRA Format:</label>
                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Prefix" class="form-control" name="contra_voucher_prefix" value="{{$settings->contra_voucher_prefix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Suffix" class="form-control" name="contra_voucher_suffix" value="{{$settings->contra_voucher_suffix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Start From" class="form-control" name="contra_voucher_start_from" value="{{$settings->contra_voucher_start_from}}"/>
                </div>

            </div>

            <div class="row">
                <label class="mg-t-20 col-sm-3 form-control-label">JV Format:</label>
                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Prefix" class="form-control" name="journal_voucher_prefix" value="{{$settings->journal_voucher_prefix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Suffix" class="form-control" name="journal_voucher_suffix" value="{{$settings->journal_voucher_suffix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Start From" class="form-control" name="journal_voucher_start_from" value="{{$settings->journal_voucher_start_from}}"/>
                </div>

            </div>

            <div class="row mg-t-20">
                <label class="col-sm-3 form-control-label">Voucher Size:</label>
                <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="voucher_size">
                        <option value="full_page" @if(isset($settings) && $settings->voucher_size == "full_page") selected @endif>Full Page</option>
                        <option value="half_page" @if(isset($settings) && $settings->voucher_size == "half_page") selected @endif>Half Page</option>
                    </select>
                </div>
            </div>
            
            <div class="row mg-t-20">
                <label class="col-sm-3 form-control-label">MR Number:</label>
                <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="mr_number">
                        <option value="manual" @if(isset($settings) && $settings->mr_number == "manual") selected @endif>Manual</option>
                        <option value="auto" @if(isset($settings) && $settings->mr_number == "auto") selected @endif>Automatic</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <label class="mg-t-20 col-sm-3 form-control-label">MR Format:</label>
                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Prefix" class="form-control" name="mr_prefix" value="{{$settings->mr_prefix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Suffix" class="form-control" name="mr_suffix" value="{{$settings->mr_suffix}}"/>
                </div>

                <div class="col-sm-3 mg-sm-t-0" style="margin-top:20px">
                  <input type="text" placeholder="Start From" class="form-control" name="mr_start_from" value="{{$settings->mr_start_from}}"/>
                </div>

            </div>

            <div class="row mg-t-20">
                <label class="col-sm-3 form-control-label">MR Size:</label>
                <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="mr_size">
                        <option value="full_page" @if(isset($settings) && $settings->mr_size == "full_page") selected @endif>Full Page</option>
                        <option value="half_page" @if(isset($settings) && $settings->mr_size == "half_page") selected @endif>Half Page</option>
                    </select>
                </div>
            </div>

            <div class="row mg-t-20">
                <label class="col-sm-3 form-control-label">Amount in Word Format:</label>
                <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="amount_in_word_format">
                        <option value="crore_lakh_thousand" @if(isset($settings) && $settings->amount_in_word_format == "crore_lakh_thousand") selected @endif>Crore-Lakh-Thousand</option>
                        <option value="crore_lac_thousand" @if(isset($settings) && $settings->amount_in_word_format == "crore_lac_thousand") selected @endif>Crore-Lac-Thousand</option>
                        <option value="billion_million_thousand" @if(isset($settings) && $settings->amount_in_word_format == "billion_million_thousand") selected @endif>Billion-Million-Thousand</option>
                    </select>
                </div>
            </div>

            <div class="row mg-t-20" style="display: none">
                <label class="col-sm-3 form-control-label">Approval for MR:</label>
                <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="approval_for_mr">
                        <option value="1" @if(isset($settings) && $settings->approval_for_mr == 1) selected @endif>Active</option>
                        <option value="0" @if(isset($settings) && $settings->approval_for_mr == 0) selected @endif>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="row mg-t-20" style="display: none">
                <label class="col-sm-3 form-control-label">Approval for Cheque:</label>
                <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <select class="form-control" name="approval_for_cheque">
                        <option value="1" @if(isset($settings) && $settings->approval_for_cheque == 1) selected @endif>Active</option>
                        <option value="0" @if(isset($settings) && $settings->approval_for_cheque == 0) selected @endif>Inactive</option>
                    </select>
                </div>
            </div>
            @if(roles() != "" && in_array(88, json_decode(roles(),false)))
            <div class="form-layout-footer mg-t-30">
                <button class="btn btn-info pointer">Update</button>
            </div>
            @endif
        </div>
      </div>
    </div>
  </form>

  <script>
    function preview_image(event) 
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('logo');
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
}
  </script>
@endsection