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
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>

  <form action="{{ url('cheque-layouts/add') }}" method="POST">
    {{ csrf_field() }}
  <div class="br-pagebody">
      <div class="row">

        <div class="col-md-9 mg-t-10 d-flex align-items-center justify-content-center bg-white">
          
          <div class="card pd-0 bd-0 pd-30 table-responsive">
            <div id="display" class="tx-black pd-b-5 collapse">Top: <input type="text" id="top" class="wd-40"/> &nbsp;Left: <input type="text" id="left" class="wd-40"/></div>

            <div id="printArea">
              <div id="containment-wrapper" style="height: 89mm; width: 191mm; position: relative">
                <div id="acpay" onclick="acpayDrag();" class="draggable ui-widget-content" style="position: absolute;top:0mm;left:0mm"><img src="{{ asset('img/acpay.png') }}"/></div>
                <div id="date" onclick="dateDrag()" class="draggable ui-widget-content" style="position: absolute; top: 7mm; left: 139mm; line-height: 16px; letter-spacing: 12px; font-family: Courier; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 10px; border-right: 7px solid red;">DDMMYYYY</div>
                <div id="payee" onclick="payeeDrag()" class="draggable ui-widget-content" style="position: absolute; top: 22mm; left: 15mm; line-height: 16px; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Payee</div>
                <div id="amount" onclick="amountDrag()" class="draggable ui-widget-content" style="position: absolute; top: 38mm; left: 154mm; line-height: 16px; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 50px; border-right: 7px solid red;">Amount</div>
                <div id="amount_in_word_line_1" onclick="amountWord1Drag()" class="draggable ui-widget-content" style="position: absolute; top: 31mm; left: 30mm; line-height: 16px; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Amount in words line #1</div>
                <div id="amount_in_word_line_2" onclick="amountWord2Drag()" class="draggable ui-widget-content" style="position: absolute; top: 40mm; left: 8mm; line-height: 16px; font-family: Arial; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5); padding-right: 200px; border-right: 7px solid red;">Amount in words line #2</div>
              </div>
            </div>

            <div class="tx-teal pd-t-20 tx-16">** Click on elements to activate, then drag to set the position.</div>
          </div>
        </div>
        
        <div class="col-md-3 mg-t-10">
          <div class="card bd-0 shadow-base pd-30">
            <div class="pd-b-10">
              <a class="btn btn-info btn-block pointer text-white" onclick="PrintElem()">Print Preview</a>
            </div>
            
            <div class="row pd-b-10">
              <div class="col-md-6">
                <div class="tx-black pd-b-5">Height: <input type="text" name="height" oninput="divHeight(this.value)" value="89" class="wd-100p pd-l-5 tx-gray-600"/></div>
              </div>
              <div class="col-md-6">
                <div class="tx-black pd-b-5">Width: <input type="text" name="width" oninput="divWidth(this.value)" value="191" class="wd-100p pd-l-5 tx-gray-600"/></div>
              </div>
            </div>
            

            <ul class="list-group">
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('date')" id="date_checkbox" name="date" value="1" checked><span>Date</span>
                </label>
                <input type="hidden" id="date_top" name="date_top" value="7" placeholder="top" class="form-control"/>
                <input type="hidden" id="date_left" name="date_left" value="139" placeholder="left" class="form-control"/>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('payee')" id="payee_checkbox" name="payee" value="1" checked><span>Payee</span>
                </label>
                <input type="hidden" id="payee_top" name="payee_top" value="22" placeholder="top" class="form-control"/>
                <input type="hidden" id="payee_left" name="payee_left" value="15" placeholder="left" class="form-control"/>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('amount')" id="amount_checkbox" name="amount" value="1" checked><span>Amount</span>
                </label>
                <input type="hidden" id="amount_top" name="amount_top" value="38" placeholder="top" class="form-control"/>
                <input type="hidden" id="amount_left" name="amount_left" value="154" placeholder="left" class="form-control"/>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('amount_word_1')" id="amount_word_1_checkbox" name="amount_in_word_line_1" value="1" checked><span>Amount in words line #1</span>
                  <input type="hidden" id="amount_in_word_line_1_top" value="31" name="amount_in_word_line_1_top" placeholder="top" class="form-control"/>
                  <input type="hidden" id="amount_in_word_line_1_left" value="30" name="amount_in_word_line_1_left" placeholder="left" class="form-control"/>
                </label>
                <input type="hidden" id="amount_in_word_line_1_top" value="31" name="amount_in_word_line_1_top" placeholder="top" class="form-control"/>
                <input type="hidden" id="amount_in_word_line_1_left" value="30" name="amount_in_word_line_1_left" placeholder="left" class="form-control"/>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('amount_word_2')" id="amount_word_2_checkbox" name="amount_in_word_line_2" value="1" checked><span>Amount in words line #2</span>
                </label>
                <input type="hidden" id="amount_in_word_line_2_top" value="40" name="amount_in_word_line_2_top" placeholder="top" class="form-control"/>
                <input type="hidden" id="amount_in_word_line_2_left" value="8" name="amount_in_word_line_2_left" placeholder="left" class="form-control"/>
              </li>
              <li class="list-group-item">
                <label class="ckbox pointer">
                  <input type="checkbox" onclick="hideShowElement('ac_pay')" id="ac_pay_checkbox" name="ac_payee_only" value="1" checked><span>AC Payee</span>
                </label>
                <input type="hidden" id="ac_payee_only_top" value="0" name="ac_payee_only_top" placeholder="top" class="form-control"/>
                <input type="hidden" id="ac_payee_only_left" value="0" name="ac_payee_only_left" placeholder="left" class="form-control"/>
              </li>
            </ul>

            <div class="pd-t-30">
              <select class="form-control" name="bank_id" required>
                <option disabled selected value="">Select Bank</option>
                @foreach($banks as $bank)
                  <option value="{{$bank->id}}">{{$bank->name}}</option>
                @endforeach
              </select>
            </div>

            <div class="pd-t-15">
              <input type="submit" value="Save Layout" class="pd-15 btn btn-success btn-block pointer"/>
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
        var mywindow = window.open('', 'PRINT');
        mywindow.document.write('<style>#containment-wrapper{margin-left:20px;margin-top:-10px;}</style>');
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