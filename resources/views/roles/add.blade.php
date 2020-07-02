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
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Add Role</h4>
  </div>

  <form action="{{ url('roles/add') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="row">
          <div class="col-md-3">
            <label>Role Name:</label> 
            <input type="text" name="role_name" class="form-control" required/>
          </div>
          <div class="col-md-8">
          </div>
          <div class="col-md-1" style="margin-top:32px">
            <a class="btn btn-info btn-sm text-white" onclick="checkAll()">Check All</a>
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
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="company_info_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                <td style="border-bottom: 1px solid #ced4da;">Signatory</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="signatory_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="signatory_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="signatory_delete"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                <td style="border-bottom: 1px solid #ced4da;">Voucher Formats</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="voucher_format_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="voucher_format_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="voucher_format_delete"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                <td style="border-bottom: 1px solid #ced4da;">Currency</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="currency_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="currency_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="currency_delete"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                <td style="border-bottom: 1px solid #ced4da;">Payment Method</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="payment_method_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="payment_method_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="payment_method_delete"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
             </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                <td style="border-bottom: 1px solid #ced4da;">Banks</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_delete"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>
              
              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                <td style="border-bottom: 1px solid #ced4da;">Bank Accounts</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_account_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_account_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="bank_account_delete"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">9</td>
                <td style="border-bottom: 1px solid #ced4da;">Cheque Books</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_book_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_book_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_book_delete"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">10</td>
                <td style="border-bottom: 1px solid #ced4da;">Cheque Formats</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_layout_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_layout_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="cheque_layout_delete"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">11</td>
                <td style="border-bottom: 1px solid #ced4da;">Roles</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="roles_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="roles_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="roles_delete"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>
              
              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">12</td>
                <td style="border-bottom: 1px solid #ced4da;">Users</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="user_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="user_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="user_delete"/></td>
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

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_cheque_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_cheque_approve"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_cheque_reject"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_cheque_void"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_cheque_print"/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                <td style="border-bottom: 1px solid #ced4da;">Create MR</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_mr_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_mr_approve"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_mr_reject"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_mr_void"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="create_mr_print"/></td>
              </tr>
              {{-- hello--}}

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                <td style="border-bottom: 1px solid #ced4da;">Cash Payment Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_payment_voucher_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_payment_voucher_approve"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_payment_voucher_reject"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_payment_voucher_void"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_payment_voucher_print"/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                <td style="border-bottom: 1px solid #ced4da;">Bank Payment Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_payment_voucher_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_payment_voucher_approve"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_payment_voucher_reject"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_payment_voucher_void"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_payment_voucher_print"/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                <td style="border-bottom: 1px solid #ced4da;">Cash Receipt Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_receipt_voucher_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_receipt_voucher_approve"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_receipt_voucher_reject"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_receipt_voucher_void"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_cash_receipt_voucher_print"/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                <td style="border-bottom: 1px solid #ced4da;">Bank Receipt Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_receipt_voucher_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_receipt_voucher_approve"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_receipt_voucher_reject"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_receipt_voucher_void"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_bank_receipt_voucher_print"/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                <td style="border-bottom: 1px solid #ced4da;">Void Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_void_voucher_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_void_voucher_approve"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_void_voucher_reject"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_void_voucher_void"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_void_voucher_print"/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                <td style="border-bottom: 1px solid #ced4da;">Contra Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_contra_voucher_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_contra_voucher_approve"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_contra_voucher_reject"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_contra_voucher_void"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_contra_voucher_print"/></td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">9</td>
                <td style="border-bottom: 1px solid #ced4da;">Cash Payment Voucher</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_journal_voucher_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_journal_voucher_approve"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_journal_voucher_reject"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_journal_voucher_void"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="tr_journal_voucher_print"/></td>
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
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="issued_voucher"/></td>
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
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="void_voucher"/></td>
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
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="issued_mr"/></td>
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
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="void_mr"/></td>
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
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="issued_cheque"/></td>
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
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="void_cheque"/></td>
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
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="audit_trail"/></td>
              </tr>

              <tr>
                <th colspan="9" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;">Configuration</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                <td style="border-bottom: 1px solid #ced4da;">Printer</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="printer_add"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="printer_update"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="printer_delete"/></td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
              </tr>

              <tr>
                <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                <td style="border-bottom: 1px solid #ced4da;">Email</td>

                <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="email_add_sent"/></td>
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
                <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" class="checkbox" value="1" name="settings_update"/></td>
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
              <input type="submit" value="Submit" class="btn btn-primary wd-100 pointer"/>
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