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
    #acpay{ cursor: move; }
    #date{ cursor: move; }
    #payee{ cursor: move; }
    #amount{ cursor: move; }
    #amount_in_word_line_1{ cursor: move; }
    #amount_in_word_line_2{ cursor: move; }
  </style>

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/cheque-layouts') }}">Cheque Layout</a>
      <span class="breadcrumb-item active">Update</span>
    </nav>
  </div>

  <form action="{{ url('cheque-layouts/update/'.$layout->id) }}" method="POST">
    {{ csrf_field() }}
  <div class="br-pagebody">
      <div class="row">

        <div class="col-md-9 mg-t-10 d-flex align-items-center justify-content-center bg-white">
          
          <div class="card pd-0 bd-0 pd-30 table-responsive">
            <div id="display" class="tx-black pd-b-5 collapse">Top: <input type="text" id="top" class="wd-40"/> &nbsp;Left: <input type="text" id="left" class="wd-40"/></div>

            <div id="printArea">
                <div id="containment-wrapper" style="height: {{$layout->height}}mm; width: {{$layout->width}}mm; position: relative">
                <div id="acpay" onclick="acpayDrag();" class="draggable ui-widget-content" style="position: absolute;top:{{$layout->ac_payee_only_top}}mm;left:{{$layout->ac_payee_only_left}}mm;@if($layout->ac_payee_only == 0) display:none; @endif"><img src="{{ asset('img/acpay.png') }}"/></div>
                <div id="date" onclick="dateDrag()" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->date_top}}mm; left: {{$layout->date_left}}mm; line-height: 16px; letter-spacing: 12px; font-family: Courier; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 10px; border-right: 7px solid red;@if($layout->date == 0) display:none; @endif">DDMMYYYY</div>
                <div id="payee" onclick="payeeDrag()" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->payee_top}}mm; left: {{$layout->payee_left}}mm; line-height: 16px; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;@if($layout->payee == 0) display:none; @endif">Payee</div>
                <div id="amount" onclick="amountDrag()" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->amount_top}}mm; left: {{$layout->amount_left}}mm; line-height: 16px; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 50px; border-right: 7px solid red;@if($layout->amount == 0) display:none; @endif">Amount</div>
                <div id="amount_in_word_line_1" onclick="amountWord1Drag()" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->amount_in_word_line_1_top}}mm; left: {{$layout->amount_in_word_line_1_left}}mm; line-height: 16px; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;@if($layout->amount_in_word_line_1 == 0) display:none; @endif">Amount in words line #1</div>
                <div id="amount_in_word_line_2" onclick="amountWord2Drag()" class="draggable ui-widget-content" style="position: absolute; top: {{$layout->amount_in_word_line_2_top}}mm; left: {{$layout->amount_in_word_line_2_left}}mm; line-height: 16px; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;@if($layout->amount_in_word_line_2 == 0) display:none; @endif">Amount in words line #2</div>
              </div>
            </div>

            <div class="tx-teal pd-t-20 tx-16">** Click on elements to activate, then drag to set the position.</div>
          </div>
        </div>
        
        <div class="col-md-3 mg-t-10">
          <div class="card bd-0 shadow-base pd-30">
            
            <div>
              <select class="form-control" id="printer">
                @foreach($printers as $printer)
                  <option value="{{$printer->top}}_{{$printer->left}}_{{$printer->rotate}}">{{$printer->print_name}}</option>
                @endforeach
              </select>
            </div>

            <div class="pd-t-10 pd-b-10 text-right">
              <a class="btn btn-info pointer text-white" onclick="PrintElem()">Print Preview</a>
            </div>

            <div>
              <div class="tx-black pd-b-5">Height (mm): <input type="text" class="form-control" name="height" oninput="divHeight(this.value)" value="{{$layout->height}}"/></div>
            </div>

            <div class="pd-t-5 pd-b-20">
              <div class="tx-black pd-b-5">Width(mm): <input type="text" class="form-control" name="width" oninput="divWidth(this.value)" value="{{$layout->width}}"/></div>
            </div>

            <ul class="list-group">
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('date')" id="date_checkbox" name="date" value="1" @if($layout->date == 1) checked @endif><span>Date</span>
                </label>
                <input type="hidden" id="date_top" name="date_top" value="{{$layout->date_top}}" class="form-control"/>
                <input type="hidden" id="date_left" name="date_left" value="{{$layout->date_left}}" class="form-control"/>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('payee')" id="payee_checkbox" name="payee" value="1" @if($layout->payee == 1) checked @endif><span>Payee</span>
                </label>
                <input type="hidden" id="payee_top" name="payee_top" value="{{$layout->payee_top}}" class="form-control"/>
                <input type="hidden" id="payee_left" name="payee_left" value="{{$layout->payee_left}}" class="form-control"/>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('amount')" id="amount_checkbox" name="amount" value="1" @if($layout->amount == 1) checked @endif><span>Amount</span>
                </label>
                <input type="hidden" id="amount_top" name="amount_top" value="{{$layout->amount_top}}" class="form-control"/>
                <input type="hidden" id="amount_left" name="amount_left" value="{{$layout->amount_left}}" class="form-control"/>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('amount_word_1')" id="amount_word_1_checkbox" name="amount_in_word_line_1" value="1" @if($layout->amount_in_word_line_1 == 1) checked @endif><span>Amount in words line #1</span>
                </label>
                <input type="hidden" id="amount_in_word_line_1_top" value="{{$layout->amount_in_word_line_1_top}}" name="amount_in_word_line_1_top" class="form-control"/>
                <input type="hidden" id="amount_in_word_line_1_left" value="{{$layout->amount_in_word_line_1_left}}" name="amount_in_word_line_1_left" class="form-control"/>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('amount_word_2')" id="amount_word_2_checkbox" name="amount_in_word_line_2" value="1" @if($layout->amount_in_word_line_2 == 1) checked @endif><span>Amount in words line #2</span>
                </label>
                <input type="hidden" id="amount_in_word_line_2_top" value="{{$layout->amount_in_word_line_2_top}}" name="amount_in_word_line_2_top" placeholder="top" class="form-control"/>
                <input type="hidden" id="amount_in_word_line_2_left" value="{{$layout->amount_in_word_line_2_left}}" name="amount_in_word_line_2_left" placeholder="left" class="form-control"/>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('ac_pay')" id="ac_pay_checkbox" name="ac_payee_only" value="1" @if($layout->ac_payee_only == 1) checked @endif><span>AC Payee</span>
                </label>
                <input type="hidden" id="ac_payee_only_top" value="{{$layout->ac_payee_only_top}}" name="ac_payee_only_top" class="form-control"/>
                <input type="hidden" id="ac_payee_only_left" value="{{$layout->ac_payee_only_left}}" name="ac_payee_only_left" class="form-control"/>
              </li>
            </ul>

            <div class="pd-t-25">
              <select class="form-control" name="bank_id" required>
                <option disabled selected value="">Select Bank</option>
                @foreach($banks as $bank)
                  <option value="{{$bank->id}}" @if($layout->bank_id == $bank->id) selected @endif>{{$bank->name}}</option>
                @endforeach
              </select>
            </div>

            <div class="pd-t-15">
              <input type="submit" value="Update Layout" class="pd-15 btn btn-success btn-block pointer"/>
            </div>

          </div>
        </div>
        
      </div>
  </div>
  </form>

  <script>
    function divHeight(height){
      document.getElementById("containment-wrapper").style.height = height+"mm";
    }

    function divWidth(width){
      document.getElementById("containment-wrapper").style.width = width+"mm";
    }

    function hideShowElement(value) {
      if(value == "date") {
        if ($('#date_checkbox').is(':checked')) {
          $('#date').show();
        }else{
          $('#date').hide();
        }
      }

      else if(value == "payee") {
        if ($('#payee_checkbox').is(':checked')) {
          $('#payee').show();
        }else{
          $('#payee').hide();
        }
      }

      else if(value == "amount") {
        if ($('#amount_checkbox').is(':checked')) {
          $('#amount').show();
        }else{
          $('#amount').hide();
        }
      }

      else if(value == "ac_pay") {
        if ($('#ac_pay_checkbox').is(':checked')) {
          $('#acpay').show();
        }else{
          $('#acpay').hide();
        }
      }

      else if(value == "amount_word_1") {
        if ($('#amount_word_1_checkbox').is(':checked')) {
          $('#amount_in_word_line_1').show();
        }else{
          $('#amount_in_word_line_1').hide();
        }
      }

      else if(value == "amount_word_2") {
        if ($('#amount_word_2_checkbox').is(':checked')) {
          $('#amount_in_word_line_2').show();
        }else{
          $('#amount_in_word_line_2').hide();
        }
      }
    }

    function PrintElem(){
        var printer     = $('#printer').val();
        var printConf   = printer.split("_");

        var mywindow = window.open('', 'PRINT');
        mywindow.document.write('<style>#containment-wrapper{margin-left:'+printConf[1]+';margin-top:'+printConf[0]+'; transform: rotate('+printConf[2]+'deg)}</style>');
        mywindow.document.write(document.getElementById('printArea').innerHTML);

        setTimeout(function () {
            mywindow.focus();
            mywindow.print();
            mywindow.close();
        }, 500);

        return true;
    }

    function acpayDrag(){
      var sAcpayPosition = "{}",
      acpayPositions = JSON.parse(sAcpayPosition);
      $.each(acpayPositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#acpay").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          acpayPositions[this.id] = ui.position
          document.getElementById('ac_payee_only_top').value = Math.round(acpayPositions.acpay.top * 0.2645833333);
          document.getElementById('ac_payee_only_left').value = Math.round(acpayPositions.acpay.left * 0.2645833333);

          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(acpayPositions.acpay.top * 0.2645833333);
          document.getElementById('left').value = Math.round(acpayPositions.acpay.left * 0.2645833333);
        }
      });
    }

    function dateDrag(){
      var sDatePosition = "{}",
      datePositions = JSON.parse(sDatePosition);
      $.each(datePositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#date").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          datePositions[this.id] = ui.position
          document.getElementById('date_top').value = Math.round(datePositions.date.top * 0.2645833333);
          document.getElementById('date_left').value = Math.round(datePositions.date.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(datePositions.date.top * 0.2645833333);
          document.getElementById('left').value = Math.round(datePositions.date.left * 0.2645833333);
        }
      });
    }

    function payeeDrag(){
      var sPayeePosition = "{}",
      payeePositions = JSON.parse(sPayeePosition);
      $.each(payeePositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#payee").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          payeePositions[this.id] = ui.position
          document.getElementById('payee_top').value = Math.round(payeePositions.payee.top * 0.2645833333);
          document.getElementById('payee_left').value = Math.round(payeePositions.payee.left * 0.2645833333);
          
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(payeePositions.payee.top * 0.2645833333);
          document.getElementById('left').value = Math.round(payeePositions.payee.left * 0.2645833333); 
        }
      });
    }

    function amountDrag(){
      var sAmountPosition = "{}",
      amountPositions = JSON.parse(sAmountPosition);
      $.each(amountPositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#amount").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          amountPositions[this.id] = ui.position
          document.getElementById('amount_top').value = Math.round(amountPositions.amount.top * 0.2645833333);
          document.getElementById('amount_left').value = Math.round(amountPositions.amount.left * 0.2645833333);
        
          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(amountPositions.amount.top * 0.2645833333);
          document.getElementById('left').value = Math.round(amountPositions.amount.left * 0.2645833333);
        }
      });
    }

    function amountWord1Drag(){
      var sAmountWord1Position = "{}",
      amountWord1Positions = JSON.parse(sAmountWord1Position);
      $.each(amountWord1Positions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#amount_in_word_line_1").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          amountWord1Positions[this.id] = ui.position
          document.getElementById('amount_in_word_line_1_top').value = Math.round(amountWord1Positions.amount_in_word_line_1.top * 0.2645833333);
          document.getElementById('amount_in_word_line_1_left').value = Math.round(amountWord1Positions.amount_in_word_line_1.left * 0.2645833333);

          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(amountWord1Positions.amount_in_word_line_1.top * 0.2645833333);
          document.getElementById('left').value = Math.round(amountWord1Positions.amount_in_word_line_1.left * 0.2645833333);
        }
      });
    }

    function amountWord2Drag(){
      var sAmountWord2Position = "{}",
      amountWord2Positions = JSON.parse(sAmountWord2Position);
      $.each(amountWord2Positions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#amount_in_word_line_2").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          amountWord2Positions[this.id] = ui.position
          document.getElementById('amount_in_word_line_2_top').value = Math.round(amountWord2Positions.amount_in_word_line_2.top * 0.2645833333);
          document.getElementById('amount_in_word_line_2_left').value = Math.round(amountWord2Positions.amount_in_word_line_2.left * 0.2645833333);

          document.getElementById('display').style.display = 'block';
          document.getElementById('top').value = Math.round(amountWord2Positions.amount_in_word_line_2.top * 0.2645833333);
          document.getElementById('left').value = Math.round(amountWord2Positions.amount_in_word_line_2.left * 0.2645833333);
        }
      });
    }
    
  </script>
@endsection