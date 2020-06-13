@extends('layouts.master')

@section('content')
  <style>
    #containment-wrapper {
      border: 1px solid #909497;
      background-size: 2mm 2mm;
      background-image:
      linear-gradient(to right, #D7DBDD 1px, transparent 1px),
      linear-gradient(to bottom, #D7DBDD 1px, transparent 1px);
    }
    #qblogo{ cursor: move; }
    #voucher_no{ cursor: move; }
    #voucher_date{ cursor: move; }
    #payee_name{ cursor: move; }
    #cheque_name{ cursor: move; }
    #cheque_date{ cursor: move; }
    #received_from{ cursor: move; }
    #amount{ cursor: move; }
    #amount_in_word_line_1{ cursor: move; }
    #amount_in_word_line_2{ cursor: move; }
  </style>

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/voucher-formats') }}">Voucher Formats</a>
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>

  <div class="br-pagebody">
      <div class="row">
        <div class="col-md-3 mg-t-10">
            <div class="card bd-0 shadow-base pd-30">
                <div>
                    <select class="form-control" id="type" onchange="onchangeType(this.value)">
                        <option value="">-- select type --</option>
                        <option value="Cash-Payment-Voucher">Cash Payment Voucher</option>
                        <option value="Bank-Payment-Voucher">Bank Payment Voucher</option>
                        <option value="Cash-Receipt-Voucher">Cash Receipt Voucher</option>
                        <option value="Bank-Receipt-Voucher">Bank Receipt Voucher</option>
                        <option value="Contra-Voucher">Contra Voucher</option>
                        <option value="Journal-Voucher">Journal Voucher</option>
                      </select>
                </div>
            </div>
        </div>
      </div>
  </div>

  <script>
      function onchangeType(value) {
          if(value != "") {
            window.location = '/voucher-formats/add/'+value;
          }
      }
  </script>
@endsection