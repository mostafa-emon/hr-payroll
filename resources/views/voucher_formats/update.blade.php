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
    #tableDiv{ cursor: move; }
    #signatory{ cursor: move; }
  </style>

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/voucher-formats') }}">Voucher Formats</a>
      <span class="breadcrumb-item active">Update</span>
    </nav>
  </div>

  <form action="{{ url('voucher-formats/update/'.$voucher_formats->id) }}" method="POST">
    {{ csrf_field() }}
    @php
      if($settings->voucher_size == "half_page"){
        $page_height = 149;
      } else{
        $page_height = 297;
      }
      if($voucher_formats->type == "Cash-Payment-Voucher") { 
        $colspan = 5;
        if($voucher_formats->name == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->project == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->location == 1){ $colspan = $colspan + 1; }
      }
      else if($voucher_formats->type == "Bank-Payment-Voucher") { $colspan = 5; 
        if($voucher_formats->name == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->project == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->location == 1){ $colspan = $colspan + 1; }
      }
      else if($voucher_formats->type == "Cash-Receipt-Voucher") { $colspan = 4; 
        if($voucher_formats->customer_job == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->name == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->project == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->location == 1){ $colspan = $colspan + 1; }
      }
      else if($voucher_formats->type == "Bank-Receipt-Voucher") { $colspan = 4; 
        if($voucher_formats->customer_job == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->name == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->project == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->location == 1){ $colspan = $colspan + 1; }
      }
      else if($voucher_formats->type == "Contra-Voucher") { $colspan = 4; 
        if($voucher_formats->customer_job == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->name == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->project == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->location == 1){ $colspan = $colspan + 1; }
      }
      else if($voucher_formats->type == "Journal-Voucher") { $colspan = 4; 
        if($voucher_formats->customer_job == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->name == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->project == 1){ $colspan = $colspan + 1; }
        if($voucher_formats->location == 1){ $colspan = $colspan + 1; }
      }
      $type = $voucher_formats->type
    @endphp
    
      

    <input type="hidden" class="form-control" name="type" value="{{$type}}"/>

  <div style="margin-top:-11px;" class="br-pagebody">

    <div style="margin-bottom:10px;" class="pd-t-10 pd-b-10 text-right">
      <a class="btn btn-info pointer text-white" onclick="PrintElem()">Print Preview</a>
    </div>
        
    <div class="card">
      <div style="margin-top:-10px;" class="row">

        <div style="padding-left: 50px;" class="col-md-3">
          <li id="date_list">
            <label class="ckbox pointer">
              <input type="checkbox" onclick="hideShowElement('payee_name')" id="payee_name_checkbox" name="payee_name" value="1" @if($voucher_formats->payee_name == 1) checked @endif><span>Payee Name</span>
            </label>
            <input type="hidden" id="payee_name_top" name="payee_name_top" value="{{$voucher_formats->payee_name_top}}"/>
            <input type="hidden" id="payee_name_left" name="payee_name_left" value="{{$voucher_formats->payee_name_left}}"/>
          </li>
        </div>
        
        <div class="col-md-3">
          <li id="date_list">
            <label class="ckbox pointer">
              <input type="checkbox" onclick="hideShowElement('cheque_name')" id="cheque_name_checkbox" name="cheque_no" value="1" @if($voucher_formats->cheque_no == 1) checked @endif><span>Cheque No</span>
            </label>
            <input type="hidden" id="cheque_name_top" name="cheque_no_top" value="{{$voucher_formats->cheque_no_top}}"/>
            <input type="hidden" id="cheque_name_left" name="cheque_no_left" value="{{$voucher_formats->cheque_no_left}}"/>
          </li>
        </div>

        <div class="col-md-3">
          <li id="date_list">
            <label class="ckbox pointer">
              <input type="checkbox" onclick="hideShowElement('cheque_date')" id="cheque_date_checkbox" name="cheque_date" value="1" @if($voucher_formats->cheque_date == 1) checked @endif><span>Cheque Date</span>
            </label>
            <input type="hidden" id="cheque_date_top" name="cheque_date_top" value="{{$voucher_formats->cheque_date_top}}"/>
            <input type="hidden" id="cheque_date_left" name="cheque_date_left" value="{{$voucher_formats->cheque_date_left}}"/>
          </li>
        </div>

        <div class="col-md-3">
          <li id="date_list">
            <label class="ckbox pointer">
              <input type="checkbox" onclick="hideShowElement('received_from')" id="received_from_checkbox" name="received_from" value="1" @if($voucher_formats->received_from == 1) checked @endif><span>Received From</span>
            </label>
            <input type="hidden" id="received_from_top" name="received_from_top" value="{{$voucher_formats->received_from_top}}"/>
            <input type="hidden" id="received_from_left" name="received_from_left" value="{{$voucher_formats->received_from_left}}"/>
          </li>
        </div>
      </div>
    </div>

    <div class="tx-black" style="margin-top:10px;">Table Columns:</div>
      <div class="card">
        <div style="margin-top:-10px;" class="row">
          <div style="padding-left:30px;" class="col-md-2">
            <li id="date_list">
              <label class="ckbox pointer">
                <input type="checkbox" onclick="hideShowElement('account_code')" id="account_code_checkbox" name="account_code" value="1" @if($voucher_formats->account_code == 1) checked @endif><span>Account Code</span>
              </label>
            </li>
          </div>

          <div class="col-md-2">
            <li id="date_list">
              <label class="ckbox pointer">
                <input type="checkbox" onclick="hideShowElement('customer_job')" id="customer_job_checkbox" name="customer_job" value="1" @if($voucher_formats->customer_job == 1) checked @endif><span>Customer:Job</span>
              </label>
            </li>
          </div>

          <div class="col-md-2">
            <li id="date_list">
              <label class="ckbox pointer">
                <input type="checkbox" onclick="hideShowElement('class')" id="class_checkbox" name="class" value="1" @if($voucher_formats->class == 1) checked @endif><span>Class</span>
              </label>
            </li>
          </div>

          <div class="col-md-2">
            <li id="date_list">
              <label class="ckbox pointer">
                <input type="checkbox" onclick="hideShowElement('name')" id="name_checkbox" name="name" value="1" @if($voucher_formats->name == 1) checked @endif><span>Name</span>
              </label>
            </li>
          </div>

          <div class="col-md-2">
            <li id="date_list">
              <label class="ckbox pointer">
                <input type="checkbox" onclick="hideShowElement('project')" id="project_checkbox" name="project" value="1" @if($voucher_formats->project == 1) checked @endif><span>Project</span>
              </label>
            </li>
          </div>

          <div class="col-md-2">
            <li id="date_list">
              <label class="ckbox pointer">
                <input type="checkbox" onclick="hideShowElement('location')" id="location_checkbox" name="location" value="1" @if($voucher_formats->location == 1) checked @endif><span>Location</span>
              </label>
            </li>
          </div>
        </div>
      </div>

      <input type="hidden" id="qb_logo_top" name="qb_logo_top" value="{{$voucher_formats->qb_logo_top}}"/>
      <input type="hidden" id="qb_logo_left" name="qb_logo_left" value="{{$voucher_formats->qb_logo_left}}"/>

      <input type="hidden" id="voucher_no_top" name="voucher_no_top" value="{{$voucher_formats->voucher_no_top}}"/>
      <input type="hidden" id="voucher_no_left" name="voucher_no_left" value="{{$voucher_formats->voucher_no_left}}"/>

      <input type="hidden" id="voucher_date_top" name="voucher_date_top" value="{{$voucher_formats->voucher_date_top}}"/>
      <input type="hidden" id="voucher_date_left" name="voucher_date_left" value="{{$voucher_formats->voucher_date_left}}"/>

      <input type="hidden" id="table_top" name="table_top" value="{{$voucher_formats->table_top}}"/>
      <input type="hidden" id="table_left" name="table_left" value="{{$voucher_formats->table_left}}"/>

      <input type="hidden" id="signatory_top" name="signatory_top" value="{{$voucher_formats->signatory_top}}"/>
    </ul>

    <div class="mg-t-8 row">

        <div class="col-md-1 tx-black" style="margin-top:11px; font-size: 18px;">Title:</div>
          <div class="col-md-5 mg-t-6">
            <input type="text" class="form-control" name="title" value="{{$voucher_formats->title}}" required/>
          </div>

        <div class="col-md-6">
          <input type="submit" value="Save Format" class="pd-15 btn btn-success btn-block pointer"/>
        </div>

    </div>

      <div class="row">

        <div class="col-md-12 mg-t-10 d-flex align-items-center justify-content-center bg-white">
          
          <div class="card pd-0 bd-0 pd-30 table-responsive">
            <div id="display" class="tx-black pd-b-5 collapse">Top: <input type="text" id="top" class="wd-40"/> &nbsp;Left: <input type="text" id="left" class="wd-40"/></div>
            <div id="printArea">
              <div id="containment-wrapper" style="height: {{$page_height}}mm; width: 210mm; position: relative">
                <div style="margin-top:3mm;text-align:center;color:black;font-size:13px;font-weight:bold">
                  <div style="font-size: 16px;">{{$company->name}}</div>
                  <div style="width:70mm;margin-left:70mm;">{{$company->address}}</div>
                  <div style="margin-top:8px">{{ str_replace("-", " ", $voucher_formats->type) }}</div>
                </div>
                <div id="qblogo" onclick="qbLogoDrag();" class="draggable ui-widget-content" style="position: absolute;top:{{$voucher_formats->qb_logo_top}}mm;left:{{$voucher_formats->qb_logo_left}}mm"><img src="{{ asset('img/qblogo.png') }}" height="35"/></div>
                <div id="voucher_no" onclick="voucherNoDrag()" class="draggable ui-widget-content" style="position: absolute; top: {{$voucher_formats->voucher_no_top}}mm; left: {{$voucher_formats->voucher_no_left}}mm; font-family: arial; font-size: 13px; font-weight:bold; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 10px; border-right: 7px solid red;">Voucher No :</div>
                <div id="voucher_date" onclick="voucherDateDrag()" class="draggable ui-widget-content" style="position: absolute; top: {{$voucher_formats->voucher_date_top}}mm; left: {{$voucher_formats->voucher_date_left}}mm; font-family: arial; font-size: 13px; font-weight:bold; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 10px; border-right: 7px solid red;">Voucher Date : </div>
                <div id="payee_name" onclick="payeeNameDrag()" class="draggable ui-widget-content" style="@if($voucher_formats->payee_name != 1) display:none; @endif position: absolute; top: {{$voucher_formats->payee_name_top}}mm; left: {{$voucher_formats->payee_name_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Payee Name</div>
                <div id="cheque_name" onclick="chequeNameDrag()" class="draggable ui-widget-content"style="@if($voucher_formats->cheque_no != 1) display:none; @endif position: absolute; top: {{$voucher_formats->cheque_no_top}}mm; left: {{$voucher_formats->cheque_no_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Cheque No</div>
                <div id="cheque_date" onclick="chequeDateDrag()" class="draggable ui-widget-content" style="@if($voucher_formats->cheque_date != 1) display:none; @endif position: absolute; top: {{$voucher_formats->cheque_date_top}}mm; left: {{$voucher_formats->cheque_date_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Cheque Date</div>
                <div id="received_from" onclick="receivedFromDrag()" class="draggable ui-widget-content" style="@if($voucher_formats->received_from != 1) display:none; @endif position: absolute; top: {{$voucher_formats->received_from_top}}mm; left: {{$voucher_formats->received_from_left}}mm; font-family: Arial; font-size: 13px; font-weight:bold; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Received From</div>

                <div id="tableDiv" onclick="tableDrag();" style="position: absolute; top: {{$voucher_formats->table_top}}mm; left:{{$voucher_formats->table_left}}mm; width: 95% !important;color:black;font-size:13px;font-family:arial">
                  <table cellpadding="0" cellspacing="0" style="width:100% !important;">
                    <thead>
                      <th class="account_code" @if($voucher_formats->account_code != 1) style="display:none;" @endif style="border-top:1px solid black; border-left:1px solid black; text-align:center;">Account Code</th>
                      <th style="border-top:1px solid black; border-left:1px solid black; text-align:center;">Account Name</th>
                      <th style="border-top:1px solid black; border-left:1px solid black; text-align:center;">Memo</th>
                      <th class="customer_job" style="@if($voucher_formats->customer_job != 1) display:none; @endif border-top:1px solid black; border-left:1px solid black;text-align:center;">Customer:Job</th>
                      <th class="class" style="@if($voucher_formats->class != 1) display:none; @endif border-top:1px solid black; border-left:1px solid black;text-align:center;">Class</th>
                      <th class="name" style="@if($voucher_formats->name != 1) display:none; @endif border-top:1px solid black; border-left:1px solid black;text-align:center;">Name</th>
                      <th class="project" style="@if($voucher_formats->project != 1) display:none; @endif border-top:1px solid black; border-left:1px solid black;text-align:center;">Project</th>
                      <th class="location" style="@if($voucher_formats->location != 1) display:none; @endif border-top:1px solid black; border-left:1px solid black;text-align:center;">Location</th>
                      <th style="border-top:1px solid black; border-left:1px solid black;text-align:center;">Debit</th>
                      <th style="border-top:1px solid black; border-left:1px solid black;border-right:1px solid black;text-align:center;">Credit</th>
                    </thead>

                    <tfoot>
                      <th id="table_total" colspan="{{$colspan}}" style="border-top:1px solid black; border-left:1px solid black;border-bottom: 1px solid black;text-align:center;">Total</th>
                      <th style="border-top:1px solid black; border-left:1px solid black;border-bottom: 1px solid black;text-align:center;"></th>
                      <th style="border-top:1px solid black; border-left:1px solid black; border-right:1px solid black;border-bottom: 1px solid black;text-align:center;"></th>
                    </tfoot>
                  </table>

                  <div style="font-weight: bold;margin-top:5px">Amount in Word :</div>
                </div>

                <div id="signatory" onclick="signatoryDrag();" style="position: absolute; top: {{$voucher_formats->signatory_top}}mm; width: 100% !important; color:black;font-size:13px;font-family:arial">
                  <div>

                    <table style="width:100%">
                      @php
                      use App\Signatory;
                      $query = strtolower(str_replace("-", "_", $type));
                      $signatories = Signatory::where($query,1)->get();
                      @endphp
                      <tr>
                      @foreach($signatories as $signatory)
                        <td style="text-align:center;">__________________<br>{{$signatory->name}}</td>
                      @endforeach
                      </tr>
                    </table>
                    
                  </div>
                </div>

              </div>
            </div>

            <div class="tx-teal pd-t-20 tx-16">** Click on elements to activate, then drag to set the position.</div>
          </div>
        </div>
      
      </div>
  </div>
  </form>

  <script>
    var colspan = "{{$colspan}}";

    function hideShowElement(value) {
      if(value == "payee_name") {
        if ($('#payee_name_checkbox').is(':checked')) {
          $('#payee_name').show();
        }else{
          $('#payee_name').hide();
        }
      }

      else if(value == "cheque_name") {
        if ($('#cheque_name_checkbox').is(':checked')) {
          $('#cheque_name').show();
        }else{
          $('#cheque_name').hide();
        }
      }

      else if(value == "cheque_date") {
        if ($('#cheque_date_checkbox').is(':checked')) {
          $('#cheque_date').show();
        }else{
          $('#cheque_date').hide();
        }
      }

      else if(value == "received_from") {
        if ($('#received_from_checkbox').is(':checked')) {
          $('#received_from').show();
        }else{
          $('#received_from').hide();
        }
      }

      else if(value == "account_code") {
        if ($('#account_code_checkbox').is(':checked')) {
          colspan = parseInt(colspan) + 1;
          $('.account_code').show();
        }else{
          colspan = parseInt(colspan) - 1;
          $('.account_code').hide();
        }
        document.getElementById('table_total').colSpan = colspan;
      }

      else if(value == "customer_job") {
        if ($('#customer_job_checkbox').is(':checked')) {
          colspan = parseInt(colspan) + 1;
          $('.customer_job').show();
        }else{
          colspan = parseInt(colspan) - 1;
          $('.customer_job').hide();
        }
        document.getElementById('table_total').colSpan = colspan;
      }

      else if(value == "class") {
        if ($('#class_checkbox').is(':checked')) {
          colspan = parseInt(colspan) + 1;
          $('.class').show();
        }else{
          colspan = parseInt(colspan) - 1;
          $('.class').hide();
        }
        document.getElementById('table_total').colSpan = colspan;
      }

      else if(value == "name") {
        if ($('#name_checkbox').is(':checked')) {
          colspan = parseInt(colspan) + 1;
          $('.name').show();
        }else{
          colspan = parseInt(colspan) - 1;
          $('.name').hide();
        }
        document.getElementById('table_total').colSpan = colspan;
      }

      else if(value == "project") {
        if ($('#project_checkbox').is(':checked')) {
          colspan = parseInt(colspan) + 1;
          $('.project').show();
        }else{
          colspan = parseInt(colspan) - 1;
          $('.project').hide();
        }
        document.getElementById('table_total').colSpan = colspan;
      }

      else if(value == "location") {
        if ($('#location_checkbox').is(':checked')) {
          colspan = parseInt(colspan) + 1;
          $('.location').show();
        }else{
          colspan = parseInt(colspan) - 1;
          $('.location').hide();
        }
        document.getElementById('table_total').colSpan = colspan;
      }
    }

    function PrintElem(){
        var mywindow = window.open('', 'PRINT');
        mywindow.document.write(document.getElementById('printArea').innerHTML);

        setTimeout(function () {
            mywindow.focus();
            mywindow.print();
            mywindow.close();
        }, 500);

        return true;
    }

    function qbLogoDrag(){
      var sQBLogoPosition = "{}",
      qbLogoPositions = JSON.parse(sQBLogoPosition);
      $.each(qbLogoPositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#qblogo").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          qbLogoPositions[this.id] = ui.position
          document.getElementById('qb_logo_top').value = Math.round(qbLogoPositions.qblogo.top * 0.2645833333);
          document.getElementById('qb_logo_left').value = Math.round(qbLogoPositions.qblogo.left * 0.2645833333);

          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(qbLogoPositions.qblogo.top * 0.2645833333);
          document.getElementById('left').value = Math.round(qbLogoPositions.qblogo.left * 0.2645833333);
        }
      });
    }

    function voucherNoDrag(){
      var sVoucherNo = "{}",
      voucherNo = JSON.parse(sVoucherNo);
      $.each(voucherNo, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#voucher_no").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          voucherNo[this.id] = ui.position
          document.getElementById('voucher_no_top').value = Math.round(voucherNo.voucher_no.top * 0.2645833333);
          document.getElementById('voucher_no_left').value = Math.round(voucherNo.voucher_no.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(voucherNo.voucher_no.top * 0.2645833333);
          document.getElementById('left').value = Math.round(voucherNo.voucher_no.left * 0.2645833333);
        }
      });
    }

    function voucherDateDrag(){
      var sVoucherDate = "{}",
      voucherDate = JSON.parse(sVoucherDate);
      $.each(voucherDate, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#voucher_date").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          voucherDate[this.id] = ui.position
          document.getElementById('voucher_date_top').value = Math.round(voucherDate.voucher_date.top * 0.2645833333);
          document.getElementById('voucher_date_left').value = Math.round(voucherDate.voucher_date.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(voucherDate.voucher_date.top * 0.2645833333);
          document.getElementById('left').value = Math.round(voucherDate.voucher_date.left * 0.2645833333);
        }
      });
    }

    function payeeNameDrag(){
      var sPayeeNamePosition = "{}",
      payeeNamePositions = JSON.parse(sPayeeNamePosition);
      $.each(payeeNamePositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#payee_name").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          payeeNamePositions[this.id] = ui.position
          document.getElementById('payee_name_top').value = Math.round(payeeNamePositions.payee_name.top * 0.2645833333);
          document.getElementById('payee_name_left').value = Math.round(payeeNamePositions.payee_name.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(payeeNamePositions.payee_name.top * 0.2645833333);
          document.getElementById('left').value = Math.round(payeeNamePositions.payee_name.left * 0.2645833333); 
        }
      });
    }

    function chequeNameDrag(){
      var sChequeNamePosition = "{}",
      chequeNamePositions = JSON.parse(sChequeNamePosition);
      $.each(chequeNamePositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#cheque_name").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          chequeNamePositions[this.id] = ui.position
          document.getElementById('cheque_name_top').value = Math.round(chequeNamePositions.cheque_name.top * 0.2645833333);
          document.getElementById('cheque_name_left').value = Math.round(chequeNamePositions.cheque_name.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(chequeNamePositions.cheque_name.top * 0.2645833333);
          document.getElementById('left').value = Math.round(chequeNamePositions.cheque_name.left * 0.2645833333); 
        }
      });
    }

    function chequeDateDrag(){
      var sChequeDatePosition = "{}",
      chequeDatePositions = JSON.parse(sChequeDatePosition);
      $.each(chequeDatePositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#cheque_date").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          chequeDatePositions[this.id] = ui.position
          document.getElementById('cheque_date_top').value = Math.round(chequeDatePositions.cheque_date.top * 0.2645833333);
          document.getElementById('cheque_date_left').value = Math.round(chequeDatePositions.cheque_date.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(chequeDatePositions.cheque_date.top * 0.2645833333);
          document.getElementById('left').value = Math.round(chequeDatePositions.cheque_date.left * 0.2645833333); 
        }
      });
    }

    function receivedFromDrag(){
      var sReceivedFromPosition = "{}",
      receivedFromPositions = JSON.parse(sReceivedFromPosition);
      $.each(receivedFromPositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#received_from").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          receivedFromPositions[this.id] = ui.position
          document.getElementById('received_from_top').value = Math.round(receivedFromPositions.received_from.top * 0.2645833333);
          document.getElementById('received_from_left').value = Math.round(receivedFromPositions.received_from.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(receivedFromPositions.received_from.top * 0.2645833333);
          document.getElementById('left').value = Math.round(receivedFromPositions.received_from.left * 0.2645833333); 
        }
      });
    }

    function tableDrag(){
      var sTablePosition = "{}",
      tablePositions = JSON.parse(sTablePosition);
      $.each(tablePositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#tableDiv").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          tablePositions[this.id] = ui.position
          document.getElementById('table_top').value = Math.round(tablePositions.tableDiv.top * 0.2645833333);
          document.getElementById('table_left').value = Math.round(tablePositions.tableDiv.left * 0.2645833333);
        
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(tablePositions.tableDiv.top * 0.2645833333);
          document.getElementById('left').value = Math.round(tablePositions.tableDiv.left * 0.2645833333);
        }
      });
    }

    function signatoryDrag(){
      var sSigPosition = "{}",
      sigPositions = JSON.parse(sSigPosition);
      $.each(sigPositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#signatory").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          sigPositions[this.id] = ui.position
          document.getElementById('signatory_top').value = Math.round(sigPositions.signatory.top * 0.2645833333);
          document.getElementById('signatory_left').value = Math.round(sigPositions.signatory.left * 0.2645833333);
        
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(sigPositions.signatory.top * 0.2645833333);
          document.getElementById('left').value = Math.round(sigPositions.signatory.left * 0.2645833333);
        }
      });
    }
  </script>
@endsection