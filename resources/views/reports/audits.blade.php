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
                                if($key == "mr_number") {
                                    if($value == "auto") { $old = $old."MR Number: Automatic, "; }
                                    else { $old = $old."MR Number: Manual, "; }
                                }
                                else if($key == "mr_size") {
                                    if($value == "full_size") { $old = $old."MR Size: Full Page, "; }
                                    else { $old = $old."MR Size: Half Page, "; }
                                }
                                else if($key == "amount_in_word_format") {
                                    if($value == "crore_lakh_thousand") { $old = $old."Amount in Word Fomrat: Crore Lakh Thousand, "; }
                                    else if($value == "crore_lac_thousand") { $old = $old."Amount in Word Fomrat: Crore Lac Thousand, "; }
                                    else if($value == "billion_million_thousand") { $old = $old."Amount in Word Fomrat: Billion Million Thousand, "; }
                                }
                                else if($key == "approval_for_mr") {
                                    if($value == 1) { $old = $old."Approval for MR: Yes, "; }
                                    else { $old = $old."Approval for MR: No, "; }
                                }
                                else if($key == "approval_for_cheque") {
                                    if($value == 1) { $old = $old."Approval for Cheque: Yes, "; }
                                    else { $old = $old."Approval for Cheque: No, "; }
                                }
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
                                if($key == "mr_number") {
                                    if($value == "auto") { $new = $new."MR Number: Automatic, "; }
                                    else { $new = $new."MR Number: Manual, "; }
                                }
                                else if($key == "mr_size") {
                                    if($value == "full_size") { $new = $new."MR Size: Full Page, "; }
                                    else { $new = $new."MR Size: Half Page, "; }
                                }
                                else if($key == "amount_in_word_format") {
                                    if($value == "crore_lakh_thousand") { $new = $new."Amount in Word Fomrat: Crore Lakh Thousand, "; }
                                    else if($value == "crore_lac_thousand") { $new = $new."Amount in Word Fomrat: Crore Lac Thousand, "; }
                                    else if($value == "billion_million_thousand") { $new = $new."Amount in Word Fomrat: Billion Million Thousand, "; }
                                }
                                else if($key == "approval_for_mr") {
                                    if($value == 1) { $new = $new."Approval for MR: Yes, "; }
                                    else { $new = $new."Approval for MR: No, "; }
                                }
                                else if($key == "approval_for_cheque") {
                                    if($value == 1) { $new = $new."Approval for Cheque: Yes, "; }
                                    else { $new = $new."Approval for Cheque: No, "; }
                                }
                            }
                            echo rtrim($new, ', ');
                        }
                    @endphp
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection