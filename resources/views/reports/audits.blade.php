@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('audits') }}">Auditing</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Auditing</h4>
    </div>
    <div style="float:right"></div>
  </div>

  <div class="br-pagebody pd-t-15">
    <div class="br-section-wrapper">
        <form action="{{ url('audits') }}" method="POST">
            {{ csrf_field() }}
            <div class="row mg-b-30 b">
                <div class="col-md-2">
                    <label class="tx-black tx-13">From Date</label>
                    <input type="text" id="dtpick1" name="from_date" value="{{$from_date}}" class="form-control" autocomplete="off"/>
                </div>

                <div class="col-md-2">
                    <label class="tx-black tx-13">To Date</label>
                    <input type="text" id="dtpick2" name="to_date" value="{{$to_date}}" class="form-control" autocomplete="off"/>
                </div>

                <div class="col-md-2" style="margin-top:28px">
                    <input type="submit" class="btn btn-primary pointer" value="Search"/>
                </div>
            </div>
        </form>
      <div class="table-responsive">
        <table id="dtable" class="table display responsive">
          <thead>
            <tr>
              <th class="text-center wd-5">Sl</th>
              <th class="text-center wd-10">Date Time</th>
              <th class="text-center wd-10">IP Address</th>
              <th class="wd-15">User</th>
              <th class="wd-10">Event</th>
              <th class="wd-25">Old Value</th>
              <th class="wd-25">New Value</th>
            </tr>
          </thead>
          <tbody>
            @foreach($audits as $audit)
              <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td class="text-center">{{date('d M Y h:i A',strtotime($audit->created_at))}}</td>
                <td class="text-center">{{$audit->ip_address}}</td>
                <td>{{$audit->user_name}}</td>
                <td>
                    @if($audit->auditable_type == "App\Company")
                        Company Info Update
                    @elseif($audit->auditable_type == "App\SiteOffice")
                        @if($audit->event == "created") Create Site Office @endif
                        @if($audit->event == "updated") Update Site Office @endif
                        @if($audit->event == "deleted") Delete Site Office @endif
                    @elseif($audit->auditable_type == "App\Printer")
                        @if($audit->event == "created") Create Printer @endif
                        @if($audit->event == "updated") Update Printer @endif
                        @if($audit->event == "deleted") Delete Printer @endif
                    @elseif($audit->auditable_type == "App\Setting")
                        Settings Update
                    @elseif($audit->auditable_type == "App\Customer")
                        @if($audit->event == "created") Create Customer @endif
                        @if($audit->event == "updated") Update Customer @endif
                        @if($audit->event == "deleted") Delete Customer @endif
                    @elseif($audit->auditable_type == "App\Supplier")
                        @if($audit->event == "created") Create Supplier @endif
                        @if($audit->event == "updated") Update Supplier @endif
                        @if($audit->event == "deleted") Delete Supplier @endif
                    @elseif($audit->auditable_type == "App\Bank")
                        @if($audit->event == "created") Create Bank @endif
                        @if($audit->event == "updated") Update Bank @endif
                        @if($audit->event == "deleted") Delete Bank @endif
                    @elseif($audit->auditable_type == "App\Currency")
                        @if($audit->event == "created") Create Currency @endif
                        @if($audit->event == "updated") Update Currency @endif
                        @if($audit->event == "deleted") Delete Currency @endif
                    @elseif($audit->auditable_type == "App\PaymentMethod")
                        @if($audit->event == "created") Create Payment Method @endif
                        @if($audit->event == "updated") Update Payment Method @endif
                        @if($audit->event == "deleted") Delete Payment Method @endif
                    @elseif($audit->auditable_type == "App\ChequeLayout")
                        @if($audit->event == "created") Create Cheque Format @endif
                        @if($audit->event == "updated") Update Cheque Format @endif
                        @if($audit->event == "deleted") Delete Cheque Format @endif
                    @elseif($audit->auditable_type == "App\BankAccount")
                        @if($audit->event == "created") Create Bank Account @endif
                        @if($audit->event == "updated") Update Bank Account @endif
                        @if($audit->event == "deleted") Delete Bank Account @endif
                    @elseif($audit->auditable_type == "App\ChequeBook")
                        @if($audit->event == "created") Create Cheque Book @endif
                        @if($audit->event == "updated") Update Cheque Book @endif
                        @if($audit->event == "deleted") Delete Cheque Book @endif
                    @elseif($audit->auditable_type == "App\Role")
                        @if($audit->event == "created") Create Role @endif
                        @if($audit->event == "updated") Update Role @endif
                        @if($audit->event == "deleted") Delete Role @endif
                    @elseif($audit->auditable_type == "App\Signatory")
                        @if($audit->event == "created") Create Signatory @endif
                        @if($audit->event == "updated") Update Signatory @endif
                        @if($audit->event == "deleted") Delete Signatory @endif
                    @elseif($audit->auditable_type == "App\User")
                        @if($audit->event == "created") Create User @endif
                        @if($audit->event == "updated") Update User @endif
                        @if($audit->event == "deleted") Delete User @endif
                    @elseif($audit->auditable_type == "App\User")
                        @if($audit->event == "created") Create User @endif
                        @if($audit->event == "updated") Update User @endif
                        @if($audit->event == "deleted") Delete User @endif
                        @if($audit->event == "Logged In") Logged In @endif
                    @elseif($audit->auditable_type == "App\VoucherFormat")
                        @if($audit->event == "created") Create Voucher Format @endif
                        @if($audit->event == "updated") Update Voucher Format @endif
                        @if($audit->event == "deleted") Delete Voucher Format @endif
                    @elseif($audit->auditable_type == "App\Email")
                        @if($audit->event == "created") Create Email Setup @endif
                        @if($audit->event == "updated") Update Email Setup @endif
                    @elseif($audit->auditable_type == "App\Transaction")
                        Void Voucher
                    @elseif($audit->auditable_type == "App\ChequeVoid")
                        Void Cheque
                    @elseif($audit->auditable_type == "App\MRVoid")
                        Void Money Receipt
                    @endif
                </td>
                <td>
                    @php
                        if($audit->auditable_type == "App\Company"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "name") {$old = $old."Name: ".$value.', ';}
                                else if($key == "email") {$old = $old."Email: ".$value.', ';}
                                else if($key == "phone") {$old = $old."Phone: ".$value.', ';}
                                else if($key == "address") {$old = $old."Address: ".$value.', ';}
                                else if($key == "tin") {$old = $old."TIN: ".$value.', ';}
                                else if($key == "vat_reg_no") {$old = $old."VAT Reg No: ".$value.', ';}
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\SiteOffice"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "name") {$old = $old."Name: ".$value.', ';}
                                else if($key == "email") {$old = $old."Email: ".$value.', ';}
                                else if($key == "phone") {$old = $old."Phone: ".$value.', ';}
                                else if($key == "address") {$old = $old."Address: ".$value.', ';}
                                else if($key == "mr_suffix") {$old = $old."Suffix: ".$value.', ';}
                                else if($key == "mr_prefix") {$old = $old."Prefix: ".$value.', ';}
                                else if($key == "mr_start_from") {$old = $old."MR Start From: ".$value.', ';}
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\Printer"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "print_name") {$old = $old."Name: ".$value.', ';}
                                else if($key == "top") {$old = $old."Top: ".$value.', ';}
                                else if($key == "left") {$old = $old."Left: ".$value.', ';}
                                else if($key == "rotate") {$old = $old."Rotate: ".$value.', ';}
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\Setting"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "voucher_number") {
                                    if($value == "auto") { $old = $old."Voucher Number: Automatic, "; }
                                    else { $old = $old."Voucher Number: Manual, "; }
                                }

                                else if($key == "cash_payment_voucher_prefix") {
                                    $old = $old."CPV Prefix: ".$value.', ';
                                }
                                else if($key == "cash_payment_voucher_suffix") {
                                    $old = $old."CPV Suffix: ".$value.', ';
                                }
                                else if($key == "cash_payment_voucher_start_from") {
                                    $old = $old."CPV Start From: ".$value.', ';
                                }

                                else if($key == "bank_payment_voucher_prefix") {
                                    $old = $old."BPV Prefix: ".$value.', ';
                                }
                                else if($key == "bank_payment_voucher_suffix") {
                                    $old = $old."BPV Suffix: ".$value.', ';
                                }
                                else if($key == "bank_payment_voucher_start_from") {
                                    $old = $old."BPV Start From: ".$value.', ';
                                }

                                else if($key == "cash_receipt_voucher_prefix") {
                                    $old = $old."CRV Prefix: ".$value.', ';
                                }
                                else if($key == "cash_receipt_voucher_suffix") {
                                    $old = $old."CRV Suffix: ".$value.', ';
                                }
                                else if($key == "cash_receipt_voucher_start_from") {
                                    $old = $old."CRV Start From: ".$value.', ';
                                }

                                else if($key == "bank_receipt_voucher_prefix") {
                                    $old = $old."BRV Prefix: ".$value.', ';
                                }
                                else if($key == "bank_receipt_voucher_suffix") {
                                    $old = $old."BRV Suffix: ".$value.', ';
                                }
                                else if($key == "bank_receipt_voucher_start_from") {
                                    $old = $old."BRV Start From: ".$value.', ';
                                }

                                else if($key == "contra_voucher_prefix") {
                                    $old = $old."CONTRA Voucher Prefix: ".$value.', ';
                                }
                                else if($key == "contra_voucher_suffix") {
                                    $old = $old."CONTRA Voucher Suffix: ".$value.', ';
                                }
                                else if($key == "contra_voucher_start_from") {
                                    $old = $old."CONTRA Voucher Start From: ".$value.', ';
                                }

                                else if($key == "journal_voucher_prefix") {
                                    $old = $old."Journal Voucher Prefix: ".$value.', ';
                                }
                                else if($key == "journal_voucher_suffix") {
                                    $old = $old."Journal Voucher Suffix: ".$value.', ';
                                }
                                else if($key == "journal_voucher_start_from") {
                                    $old = $old."Journal Voucher Start From: ".$value.', ';
                                }

                                else if($key == "cash_receipt_voucher_sales_receipt") {
                                    if($value == "1") { $old = $old."Sales Receipt: Allow, "; }
                                    else { $old = $old."Sales Receipt: Disallow, "; }
                                }
                                else if($key == "voucher_size") {
                                    if($value == "full_page") { $old = $old."Voucher Size: Full Page, "; }
                                    else { $old = $old."Voucher Size: Half Page, "; }
                                }
                                else if($key == "mr_number") {
                                    if($value == "auto") { $old = $old."MR Number: Automatic, "; }
                                    else { $old = $old."MR Number: Manual, "; }
                                }
                                else if($key == "mr_size") {
                                    if($value == "full_page") { $old = $old."MR Size: Full Page, "; }
                                    else { $old = $old."MR Size: Half Page, "; }
                                }
                                else if($key == "mr_prefix") {
                                    $old = $old."MR Prefix: ".$value.', ';
                                }
                                else if($key == "mr_suffix") {
                                    $old = $old."MR Suffix: ".$value.', ';
                                }
                                else if($key == "mr_start_from") {
                                    $old = $old."MR Start From: ".$value.', ';
                                }
                                else if($key == "amount_in_word_format") {
                                    if($value == "crore_lakh_thousand") { $old = $old."Amount in Word Fomrat: Crore Lakh Thousand, "; }
                                    else if($value == "crore_lac_thousand") { $old = $old."Amount in Word Fomrat: Crore Lac Thousand, "; }
                                    else if($value == "billion_million_thousand") { $old = $old."Amount in Word Fomrat: Billion Million Thousand, "; }
                                }
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\Customer"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "name") {$old = $old."Name: ".$value.', ';}
                                else if($key == "address") {$old = $old."Address: ".$value.', ';}
                                else if($key == "phone") {$old = $old."Phone: ".$value.', ';}
                                else if($key == "email") {$old = $old."Email: ".$value.', ';}
                                else if($key == "contact_person") {$old = $old."Contact Person: ".$value.', ';}
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\Supplier"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "name") {$old = $old."Name: ".$value.', ';}
                                else if($key == "cheque_name") {$old = $old."Cheque Name: ".$value.', ';}
                                else if($key == "address") {$old = $old."Address: ".$value.', ';}
                                else if($key == "phone") {$old = $old."Phone: ".$value.', ';}
                                else if($key == "email") {$old = $old."Email: ".$value.', ';}
                                else if($key == "contact_person") {$old = $old."Contact Person: ".$value.', ';}
                            }
                            echo rtrim($old, ', ');
                        }
                        
                        if($audit->auditable_type == "App\Bank"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "name") {$old = $old."Name: ".$value.', ';}
                                else if($key == "address") {$old = $old."Address: ".$value.', ';}
                                else if($key == "phone") {$old = $old."Phone: ".$value.', ';}
                                else if($key == "email") {$old = $old."Email: ".$value.', ';}
                                else if($key == "contact_person") {$old = $old."Contact Person: ".$value.', ';}
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\Currency"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "full_name") {$old = $old."Full Name: ".$value.', ';}
                                else if($key == "fraction_name") {$old = $old."Fraction Name: ".$value.', ';}
                                else if($key == "default") {$old = $old."Default: ".$value.', ';}
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\PaymentMethod"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "method_name") {$old = $old."Method Name: ".$value.', ';}
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\ChequeLayout"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "bank_id") {
                                    $bank_name = DB::table('banks')->where('id',$value)->value('name');
                                    $old = "Cheque format for ".$old.$bank_name.', ';
                                }
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\BankAccount"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "bank_id") {
                                    $bank_name = DB::table('banks')->where('id',$value)->value('name');
                                    $old = $old."Bank: ".$bank_name.', ';
                                }
                                if($key == "ac_number") { $old = $old."Account No: ".$value.', '; }
                                if($key == "ac_type") { $old = $old."Type: ".$value.', '; }
                                if($key == "currency_id") {
                                    $currency = DB::table('currencies')->where('id',$value)->value('full_name');
                                    $old = $old."Currency: ".$currency.', ';
                                }
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\ChequeBook"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "bank_id") {
                                    $bank_name = DB::table('banks')->where('id',$value)->value('name');
                                    $old = $old."Bank: ".$bank_name.', ';
                                }
                                if($key == "account_id") {
                                    $account = DB::table('bank_accounts')->where('id',$value)->value('ac_number');
                                    $old = $old."Account: ".$account.', ';
                                }
                                if($key == "book_no") { $old = $old."Book No: ".$value.', '; }
                                if($key == "no_of_leaves") { $old = $old."No of Leaves: ".$value.', '; }
                                if($key == "starting_number") { $old = $old."Start From: ".$value.', '; }
                                if($key == "ending_number") { $old = $old."End To: ".$value.', '; }
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\Role"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "role_name") { $old = $old."Role: ".$value.', '; }
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\User"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "name") { $old = $old."Name: ".$value.', '; }
                                else if($key == "designation") { $old = $old."Designation: ".$value.', '; }
                                else if($key == "email") { $old = $old."Email: ".$value.', '; }
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\Signatory"){
                            $old = "";
                            if($audit->event == "updated") {
                                $old = "User updated ";
                                $old_value = json_decode($audit->old_values);
                            
                                foreach($old_value as $key => $value){
                                    if($key == "name") { $old = $old.$value.' '; }
                                }
                                $old = $old."signatory";
                                echo rtrim($old, ', ');
                            }else if($audit->event == "deleted") {
                                $old = "User deleted ";
                                $old_value = json_decode($audit->old_values);
                            
                                foreach($old_value as $key => $value){
                                    if($key == "name") { $old = $old.$value.' '; }
                                }
                                $old = $old."signatory";
                                echo rtrim($old, ', ');
                            }
                        }

                        if($audit->auditable_type == "App\VoucherFormat"){
                            $old = "";
                            if($audit->event == "updated") {
                                $old_value = json_decode($audit->old_values);
                            
                                foreach($old_value as $key => $value){
                                    if($key == "title") { $old = $old.$value.' '; }
                                }
                                $old = $old."voucher format";
                                echo rtrim($old, ', ');
                                $old = "User updated ";
                            }else if($audit->event == "deleted") {
                                $old = "User deleted ";
                                $old_value = json_decode($audit->old_values);
                            
                                foreach($old_value as $key => $value){
                                    if($key == "title") { $old = $old.$value.' '; }
                                }
                                $old = $old."voucher format";
                                echo rtrim($old, ', ');
                            }   
                        }

                        if($audit->auditable_type == "App\Email"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "mail_driver") { $old = $old."Driver: ".$value.', '; }
                                else if($key == "host_name") { $old = $old."Host: ".$value.', '; }
                                else if($key == "port_name") { $old = $old."Port: ".$value.', '; }
                                else if($key == "user_name") { $old = $old."User: ".$value.', '; }
                                else if($key == "from_name") { $old = $old."From: ".$value.', '; }
                                else if($key == "subject") { $old = $old."Subject: ".$value.', '; }
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\Transaction"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "message") { $old = $old.$value.', '; }
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\ChequeVoid"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "message") { $old = $old.$value.', '; }
                            }
                            echo rtrim($old, ', ');
                        }

                        if($audit->auditable_type == "App\MRVoid"){
                            $old_value = json_decode($audit->old_values);
                            $old = "";
                            foreach($old_value as $key => $value){
                                if($key == "message") { $old = $old.$value.', '; }
                            }
                            echo rtrim($old, ', ');
                        }
                    @endphp
                </td>
                <td>
                    @php
                        if($audit->auditable_type == "App\Company"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "name") {$new = $new."Name: ".$value.', ';}
                                else if($key == "email") {$new = $new."Email: ".$value.', ';}
                                else if($key == "phone") {$new = $new."Phone: ".$value.', ';}
                                else if($key == "address") {$new = $new."Address: ".$value.', ';}
                                else if($key == "tin") {$new = $new."TIN: ".$value.', ';}
                                else if($key == "vat_reg_no") {$new = $new."VAT Reg No: ".$value.', ';}
                            }
                            echo rtrim($new, ', ');
                        }
                        
                        if($audit->auditable_type == "App\SiteOffice"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "name") {$new = $new."Name: ".$value.', ';}
                                else if($key == "email") {$new = $new."Email: ".$value.', ';}
                                else if($key == "phone") {$new = $new."Phone: ".$value.', ';}
                                else if($key == "address") {$new = $new."Address: ".$value.', ';}
                                else if($key == "mr_suffix") {$new = $new."Suffix: ".$value.', ';}
                                else if($key == "mr_prefix") {$new = $new."Prefix: ".$value.', ';}
                                else if($key == "mr_start_from") {$new = $new."MR Start From: ".$value.', ';}
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\Printer"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "print_name") {$new = $new."Name: ".$value.', ';}
                                else if($key == "top") {$new = $new."Top: ".$value.', ';}
                                else if($key == "left") {$new = $new."Left: ".$value.', ';}
                                else if($key == "rotate") {$new = $new."Rotate: ".$value.', ';}
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\Setting"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "voucher_number") {
                                    if($value == "auto") { $new = $new."Voucher Number: Automatic, "; }
                                    else { $new = $new."Voucher Number: Manual, "; }
                                }

                                else if($key == "cash_payment_voucher_prefix") {
                                    $new = $new."CPV Prefix: ".$value.', ';
                                }
                                else if($key == "cash_payment_voucher_suffix") {
                                    $new = $new."CPV Suffix: ".$value.', ';
                                }
                                else if($key == "cash_payment_voucher_start_from") {
                                    $new = $new."CPV Start From: ".$value.', ';
                                }

                                else if($key == "bank_payment_voucher_prefix") {
                                    $new = $new."BPV Prefix: ".$value.', ';
                                }
                                else if($key == "bank_payment_voucher_suffix") {
                                    $new = $new."BPV Suffix: ".$value.', ';
                                }
                                else if($key == "bank_payment_voucher_start_from") {
                                    $new = $new."BPV Start From: ".$value.', ';
                                }

                                else if($key == "cash_receipt_voucher_prefix") {
                                    $new = $new."CRV Prefix: ".$value.', ';
                                }
                                else if($key == "cash_receipt_voucher_suffix") {
                                    $new = $new."CRV Suffix: ".$value.', ';
                                }
                                else if($key == "cash_receipt_voucher_start_from") {
                                    $new = $new."CRV Start From: ".$value.', ';
                                }

                                else if($key == "bank_receipt_voucher_prefix") {
                                    $new = $new."BRV Prefix: ".$value.', ';
                                }
                                else if($key == "bank_receipt_voucher_suffix") {
                                    $new = $new."BRV Suffix: ".$value.', ';
                                }
                                else if($key == "bank_receipt_voucher_start_from") {
                                    $new = $new."BRV Start From: ".$value.', ';
                                }

                                else if($key == "contra_voucher_prefix") {
                                    $new = $new."CONTRA Voucher Prefix: ".$value.', ';
                                }
                                else if($key == "contra_voucher_suffix") {
                                    $new = $new."CONTRA Voucher Suffix: ".$value.', ';
                                }
                                else if($key == "contra_voucher_start_from") {
                                    $new = $new."CONTRA Voucher Start From: ".$value.', ';
                                }

                                else if($key == "journal_voucher_prefix") {
                                    $new = $new."Journal Voucher Prefix: ".$value.', ';
                                }
                                else if($key == "journal_voucher_suffix") {
                                    $new = $new."Journal Voucher Suffix: ".$value.', ';
                                }
                                else if($key == "journal_voucher_start_from") {
                                    $new = $new."Journal Voucher Start From: ".$value.', ';
                                }

                                else if($key == "cash_receipt_voucher_sales_receipt") {
                                    if($value == "1") { $new = $new."Sales Receipt: Allow, "; }
                                    else { $new = $new."Sales Receipt: Disallow, "; }
                                }
                                else if($key == "voucher_size") {
                                    if($value == "full_page") { $new = $new."Voucher Size: Full Page, "; }
                                    else { $new = $new."Voucher Size: Half Page, "; }
                                }
                                else if($key == "mr_number") {
                                    if($value == "auto") { $new = $new."MR Number: Automatic, "; }
                                    else { $new = $new."MR Number: Manual, "; }
                                }
                                else if($key == "mr_size") {
                                    if($value == "full_page") { $new = $new."MR Size: Full Page, "; }
                                    else { $new = $new."MR Size: Half Page, "; }
                                }
                                else if($key == "mr_prefix") {
                                    $new = $new."MR Prefix: ".$value.', ';
                                }
                                else if($key == "mr_suffix") {
                                    $new = $new."MR Suffix: ".$value.', ';
                                }
                                else if($key == "mr_start_from") {
                                    $new = $new."MR Start From: ".$value.', ';
                                }
                                else if($key == "amount_in_word_format") {
                                    if($value == "crore_lakh_thousand") { $new = $new."Amount in Word Fomrat: Crore Lakh Thousand, "; }
                                    else if($value == "crore_lac_thousand") { $new = $new."Amount in Word Fomrat: Crore Lac Thousand, "; }
                                    else if($value == "billion_million_thousand") { $new = $new."Amount in Word Fomrat: Billion Million Thousand, "; }
                                }
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\Customer"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "name") {$new = $new."Name: ".$value.', ';}
                                else if($key == "address") {$new = $new."Address: ".$value.', ';}
                                else if($key == "phone") {$new = $new."Phone: ".$value.', ';}
                                else if($key == "email") {$new = $new."Email: ".$value.', ';}
                                else if($key == "contact_person") {$new = $new."Contact Person: ".$value.', ';}
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\Supplier"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "name") {$new = $new."Name: ".$value.', ';}
                                else if($key == "cheque_name") {$new = $new."Cheque Name: ".$value.', ';}
                                else if($key == "address") {$new = $new."Address: ".$value.', ';}
                                else if($key == "phone") {$new = $new."Phone: ".$value.', ';}
                                else if($key == "email") {$new = $new."Email: ".$value.', ';}
                                else if($key == "contact_person") {$new = $new."Contact Person: ".$value.', ';}
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\Bank"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "name") {$new = $new."Name: ".$value.', ';}
                                else if($key == "address") {$new = $new."Address: ".$value.', ';}
                                else if($key == "phone") {$new = $new."Phone: ".$value.', ';}
                                else if($key == "email") {$new = $new."Email: ".$value.', ';}
                                else if($key == "contact_person") {$new = $new."Contact Person: ".$value.', ';}
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\Currency"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "full_name") {$new = $new."Full Name: ".$value.', ';}
                                else if($key == "fraction_name") {$new = $new."Fraction Name: ".$value.', ';}
                                else if($key == "default") {$new = $new."Default: ".$value.', ';}
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\PaymentMethod"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "method_name") {$new = $new."Method Name: ".$value.', ';}
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\ChequeLayout"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "bank_id") {
                                    $bank_name = DB::table('banks')->where('id',$value)->value('name');
                                    $new = "Cheque format for ".$new.$bank_name.', ';
                                }
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\BankAccount"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "bank_id") {
                                    $bank_name = DB::table('banks')->where('id',$value)->value('name');
                                    $new = $new."Bank: ".$bank_name.', ';
                                }
                                if($key == "ac_number") { $new = $new."Account No: ".$value.', '; }
                                if($key == "ac_type") { $new = $new."Type: ".$value.', '; }
                                if($key == "currency_id") {
                                    $currency = DB::table('currencies')->where('id',$value)->value('full_name');
                                    $new = $new."Currency: ".$currency.', ';
                                }
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\ChequeBook"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "bank_id") {
                                    $bank_name = DB::table('banks')->where('id',$value)->value('name');
                                    $new = $new."Bank: ".$bank_name.', ';
                                }
                                if($key == "account_id") {
                                    $account = DB::table('bank_accounts')->where('id',$value)->value('ac_number');
                                    $new = $new."Account: ".$account.', ';
                                }
                                if($key == "book_no") { $new = $new."Book No: ".$value.', '; }
                                if($key == "no_of_leaves") { $new = $new."No of Leaves: ".$value.', '; }
                                if($key == "starting_number") { $new = $new."Start From: ".$value.', '; }
                                if($key == "ending_number") { $new = $new."End To: ".$value.', '; }
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\Role"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "role_name") { $new = $new."Role: ".$value.', '; }
                            }
                            echo rtrim($new, ', ');
                        }

                        if($audit->auditable_type == "App\User"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "name") { $new = $new."Name: ".$value.', '; }
                                else if($key == "designation") { $new = $new."Designation: ".$value.', '; }
                                else if($key == "email") { $new = $new."Email: ".$value.', '; }
                            }
                            echo rtrim($new, ', ');
                        }
                        
                        if($audit->auditable_type == "App\Signatory"){
                            $new = "";
                            if($audit->event == "created") {
                                $new = "User created ";
                            
                                $new_value = json_decode($audit->new_values);
                                
                                foreach($new_value as $key => $value){
                                    if($key == "name") { $new = $new.$value.' '; }
                                }
                                $new = $new."signatory";
                                echo rtrim($new, ', ');
                            }
                        }

                        if($audit->auditable_type == "App\VoucherFormat"){
                            $new = "";
                            if($audit->event == "created") {
                                $new = "User created ";
                                $new_value = json_decode($audit->new_values);
                            
                                foreach($new_value as $key => $value){
                                    if($key == "title") { $new = $new.$value.' '; }
                                }
                                $new = $new."voucher format";
                                echo rtrim($new, ', ');
                            }
                        }

                        if($audit->auditable_type == "App\Email"){
                            $new_value = json_decode($audit->new_values);
                            $new = "";
                            foreach($new_value as $key => $value){
                                if($key == "mail_driver") { $new = $new."Driver: ".$value.', '; }
                                else if($key == "host_name") { $new = $new."Host: ".$value.', '; }
                                else if($key == "port_name") { $new = $new."Port: ".$value.', '; }
                                else if($key == "user_name") { $new = $new."User: ".$value.', '; }
                                else if($key == "from_name") { $new = $new."From: ".$value.', '; }
                                else if($key == "subject") { $new = $new."Subject: ".$value.', '; }
                            }
                            echo rtrim($new, ', ');
                        }
                    @endphp
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div><br>
      {{ $audits -> links() }}
    </div>
  </div>

@endsection