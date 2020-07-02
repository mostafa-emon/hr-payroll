@extends('layouts.master')

@section('content')
  <style>
    input[type=checkbox] {
        transform: scale(1.5);
    }
  </style>

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/roles') }}">Roles</a>
      <span class="breadcrumb-item active">Update</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Update Role</h4>
  </div>

  <form action="{{ url('roles/update/'.$roles->id) }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="row">
          <div class="col-md-3">
            <label>Role Name:</label>
            <input type="text" name="role_name" value="{{ $roles->role_name }}" class="form-control" required/>
          </div>
          <div class="col-md-9">
          </div>
        </div>
        <br>
        <div class="table-responsive">
          <table class="table table-bordered" cellspacing="1" cellpadding="1">
            <thead>
              <tr>
                <th rowspan="2" style="vertical-align: middle; border: 1px solid #ced4da; text-align:center;">Sl No</th>
                <th rowspan="2" style="vertical-align: middle; border-top:1px solid #ced4da; border-bottom:1px solid #ced4da;">Features</th>
                <th colspan="7" style="text-align:center; border-left:1px solid #ced4da; border-top:1px solid #ced4da; border-bottom:1px solid #ced4da; border-right: 1px solid #ced4da;">Permissions</th>
              </tr>

              <tr>
                <th style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">Add</th>
                <th style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;">Update</th>
                <th style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;">Delete</th>
                <th style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">Approve</th>
                <th style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">Reject</th>
                <th style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">Void</th>
                <th style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">Print</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <th colspan="9" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;">Master Setup</td>
              </tr>
              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                <td style="border-bottom: 1px solid #ced4da;">Company Info</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="company_info_update" @if($roles->access != "" && in_array(1, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                <td style="border-bottom: 1px solid #ced4da;">Signatory</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="signatory_add" @if($roles->access != "" && in_array(2, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="signatory_update" @if($roles->access != "" && in_array(3, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="signatory_delete" @if($roles->access != "" && in_array(4, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                <td style="border-bottom: 1px solid #ced4da;">Voucher Formats</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="voucher_format_add" @if($roles->access != "" && in_array(5, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="voucher_format_update" @if($roles->access != "" && in_array(6, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="voucher_format_delete" @if($roles->access != "" && in_array(7, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                <td style="border-bottom: 1px solid #ced4da;">Currency</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="currency_add" @if($roles->access != "" && in_array(8, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="currency_update" @if($roles->access != "" && in_array(9, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="currency_delete" @if($roles->access != "" && in_array(10, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                <td style="border-bottom: 1px solid #ced4da;">Payment Method</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="payment_method_add" @if($roles->access != "" && in_array(11, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="payment_method_update" @if($roles->access != "" && in_array(12, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="payment_method_delete" @if($roles->access != "" && in_array(13, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
             </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                <td style="border-bottom: 1px solid #ced4da;">Banks</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_add" @if($roles->access != "" && in_array(14, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_update" @if($roles->access != "" && in_array(15, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_delete" @if($roles->access != "" && in_array(16, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>
              
              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                <td style="border-bottom: 1px solid #ced4da;">Bank Accounts</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_account_add" @if($roles->access != "" && in_array(17, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_account_update" @if($roles->access != "" && in_array(18, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_account_delete" @if($roles->access != "" && in_array(19, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">9</td>
                <td style="border-bottom: 1px solid #ced4da;">Cheque Books</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_book_add" @if($roles->access != "" && in_array(20, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_book_update" @if($roles->access != "" && in_array(21, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_book_delete" @if($roles->access != "" && in_array(22, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">10</td>
                <td style="border-bottom: 1px solid #ced4da;">Cheque Formats</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_layout_add" @if($roles->access != "" && in_array(23, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_layout_update" @if($roles->access != "" && in_array(24, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_layout_delete" @if($roles->access != "" && in_array(25, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">11</td>
                <td style="border-bottom: 1px solid #ced4da;">Roles</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="roles_add" @if($roles->access != "" && in_array(29, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="roles_update" @if($roles->access != "" && in_array(30, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="roles_delete" @if($roles->access != "" && in_array(31, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>
              
              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">12</td>
                <td style="border-bottom: 1px solid #ced4da;">Users</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="user_add" @if($roles->access != "" && in_array(26, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="user_update" @if($roles->access != "" && in_array(27, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="user_delete" @if($roles->access != "" && in_array(28, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <th colspan="9" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;">Transactions</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                <td style="border-bottom: 1px solid #ced4da;">Create Cheque</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_cheque_add" @if($roles->access != "" && in_array(32, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_cheque_approve" @if($roles->access != "" && in_array(33, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_cheque_reject" @if($roles->access != "" && in_array(34, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_cheque_void" @if($roles->access != "" && in_array(35, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_cheque_print" @if($roles->access != "" && in_array(36, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                <td style="border-bottom: 1px solid #ced4da;">Create MR</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_mr_add" @if($roles->access != "" && in_array(37, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_mr_approve" @if($roles->access != "" && in_array(38, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_mr_reject" @if($roles->access != "" && in_array(39, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_mr_void" @if($roles->access != "" && in_array(40, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_mr_print" @if($roles->access != "" && in_array(41, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>
              {{-- hello--}}

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                <td style="border-bottom: 1px solid #ced4da;">Cash Payment Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_payment_voucher_add" @if($roles->access != "" && in_array(42, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_payment_voucher_approve" @if($roles->access != "" && in_array(43, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_payment_voucher_reject" @if($roles->access != "" && in_array(44, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_payment_voucher_void" @if($roles->access != "" && in_array(45, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_payment_voucher_print" @if($roles->access != "" && in_array(46, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                <td style="border-bottom: 1px solid #ced4da;">Bank Payment Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_payment_voucher_add" @if($roles->access != "" && in_array(47, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_payment_voucher_approve" @if($roles->access != "" && in_array(48, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_payment_voucher_reject" @if($roles->access != "" && in_array(49, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_payment_voucher_void" @if($roles->access != "" && in_array(50, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_payment_voucher_print" @if($roles->access != "" && in_array(51, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                <td style="border-bottom: 1px solid #ced4da;">Cash Receipt Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_receipt_voucher_add" @if($roles->access != "" && in_array(52, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_receipt_voucher_approve" @if($roles->access != "" && in_array(53, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_receipt_voucher_reject" @if($roles->access != "" && in_array(54, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_receipt_voucher_void" @if($roles->access != "" && in_array(55, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_receipt_voucher_print" @if($roles->access != "" && in_array(56, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                <td style="border-bottom: 1px solid #ced4da;">Bank Receipt Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_receipt_voucher_add" @if($roles->access != "" && in_array(57, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_receipt_voucher_approve" @if($roles->access != "" && in_array(58, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_receipt_voucher_reject" @if($roles->access != "" && in_array(59, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_receipt_voucher_void" @if($roles->access != "" && in_array(60, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_receipt_voucher_print" @if($roles->access != "" && in_array(61, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                <td style="border-bottom: 1px solid #ced4da;">Void Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_void_voucher_add" @if($roles->access != "" && in_array(62, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_void_voucher_approve" @if($roles->access != "" && in_array(63, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_void_voucher_reject" @if($roles->access != "" && in_array(64, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_void_voucher_void" @if($roles->access != "" && in_array(65, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_void_voucher_print" @if($roles->access != "" && in_array(66, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                <td style="border-bottom: 1px solid #ced4da;">Contra Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_contra_voucher_add" @if($roles->access != "" && in_array(67, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_contra_voucher_approve" @if($roles->access != "" && in_array(68, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_contra_voucher_reject" @if($roles->access != "" && in_array(69, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_contra_voucher_void" @if($roles->access != "" && in_array(70, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_contra_voucher_print" @if($roles->access != "" && in_array(71, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">9</td>
                <td style="border-bottom: 1px solid #ced4da;">Cash Payment Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_journal_voucher_add" @if($roles->access != "" && in_array(72, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_journal_voucher_approve" @if($roles->access != "" && in_array(73, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_journal_voucher_reject" @if($roles->access != "" && in_array(74, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_journal_voucher_void" @if($roles->access != "" && in_array(75, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_journal_voucher_print" @if($roles->access != "" && in_array(76, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <th colspan="9" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;">Reports</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                <td style="border-bottom: 1px solid #ced4da;">Issued Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="issued_voucher" @if($roles->access != "" && in_array(77, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                <td style="border-bottom: 1px solid #ced4da;">Void Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="void_voucher" @if($roles->access != "" && in_array(78, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                <td style="border-bottom: 1px solid #ced4da;">Issued MR</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="issued_mr" @if($roles->access != "" && in_array(79, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                <td style="border-bottom: 1px solid #ced4da;">Void MR</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="void_mr" @if($roles->access != "" && in_array(80, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                <td style="border-bottom: 1px solid #ced4da;">Issued Cheque</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="issued_cheque" @if($roles->access != "" && in_array(81, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                <td style="border-bottom: 1px solid #ced4da;">Void Cheque</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="void_cheque" @if($roles->access != "" && in_array(82, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                <td style="border-bottom: 1px solid #ced4da;">Audit Trail</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="audit_trail" @if($roles->access != "" && in_array(83, json_decode($roles->access,false)))checked="checked"@endif/></td>
              </tr>

              <tr>
                <th colspan="9" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;">Configuration</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                <td style="border-bottom: 1px solid #ced4da;">Printer</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="printer_add" @if($roles->access != "" && in_array(84, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="printer_update" @if($roles->access != "" && in_array(85, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="printer_delete" @if($roles->access != "" && in_array(86, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                <td style="border-bottom: 1px solid #ced4da;">Email</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="email_add_sent" @if($roles->access != "" && in_array(87, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                <td style="border-bottom: 1px solid #ced4da;">Settings</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="settings_update" @if($roles->access != "" && in_array(88, json_decode($roles->access,false)))checked="checked"@endif/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

            </tbody>
          </table>

          <br>

          <div class="row">
            <div class="col-md-12 text-center">
              <input type="submit" value="Update" class="btn btn-primary wd-100 pointer"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <script>
    function checkAll(){
      $('.checkbox').attr("checked","checked");
    }
  </script>
@endsection