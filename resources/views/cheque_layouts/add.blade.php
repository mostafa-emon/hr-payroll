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
    #amount_in_word{ cursor: move; }
  </style>

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/cheque-layouts') }}">Cheque Layout</a>
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Add Layout</h4>
  </div>


  <div class="br-pagebody">
      <div class="row">

        <div class="col-md-9 mg-t-10 d-flex align-items-center justify-content-center bg-white">
          
          <div class="card pd-0 bd-0 pd-30 table-responsive">
            <div id="display" class="tx-black pd-b-5 collapse">Top: <input type="text" id="top" class="wd-40"/> &nbsp;Left: <input type="text" id="left" class="wd-40"/></div>

            <div id="printArea">
              <div id="containment-wrapper" style="height: 89mm; width: 191mm; position: relative">
                <div id="acpay" onclick="acpayDrag();" class="draggable ui-widget-content" style="position: absolute;top:0mm;left:0mm"><img src="{{ asset('img/acpay.png') }}"/></div>
                <div id="date" onclick="dateDrag()" class="draggable ui-widget-content" style="position: absolute; top: 7mm; left: 139mm; line-height: 16px; letter-spacing: 10px; font-family: Courier; font-size: 16px; color: black; background-color:rgba(60, 141, 188, 0.5);">DDMMYYYY</div>
                <div id="payee" onclick="payeeDrag()" class="draggable ui-widget-content" style="position: absolute;top:30mm;left:130mm">Payee</div>
                <div id="amount" onclick="amountDrag()" class="draggable ui-widget-content" style="position: absolute;top:10mm;left:30mm">Amount</div>
                <div id="amount_in_word" onclick="amountWordDrag()" class="draggable ui-widget-content" style="position: absolute;top:20mm;left:30mm">Amount in Word</div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 mg-t-10">
          <div class="card bd-0 shadow-base pd-30">
            <ul class="list-group">
              <li class="list-group-item">
                <select class="form-control">
                  <option>Select Bank</option>
                </select>
              </li>
              <li class="list-group-item">
                <label class="ckbox">
                  <input type="checkbox" name="date" value="1" checked><span>Date</span>
                  <input type="hidden" id="date_top" name="date_top" placeholder="top" class="form-control"/>
                  <input type="hidden" id="date_left" name="date_left" placeholder="left" class="form-control"/>
                </label>
              </li>
              <li class="list-group-item">
                <label class="ckbox">
                  <input type="checkbox" name="payee" value="1" checked><span>Payee</span>
                  <input type="hidden" id="payee_top" name="payee_top" placeholder="top" class="form-control"/>
                  <input type="hidden" id="payee_left" name="payee_left" placeholder="left" class="form-control"/>
                </label>
              </li>
              <li class="list-group-item">
                <label class="ckbox">
                  <input type="checkbox" name="amount" value="1" checked><span>Amount</span>
                </label>
              </li>
              <li class="list-group-item">
                <label class="ckbox">
                  <input type="checkbox" name="amount_in_word" value="1" checked><span>Amount in Word</span>
                </label>
              </li>
              <li class="list-group-item">
                <label class="ckbox">
                  <input type="checkbox" name="ac_payee_only" value="1" checked><span>AC Payee</span>
                </label>
              </li>
            </ul>

            <div class="row pd-t-20">
              <div class="col-md-3">
                
              </div>
              <div class="col-md-3">
                
              </div>
            </div>

            <div class="row pd-t-20">
              <div class="col-md-3">
                <input type="text" id="amount_top" name="amount_top" placeholder="top" class="form-control"/>
              </div>
              <div class="col-md-3">
                <input type="text" id="amount_left" name="amount_left" placeholder="left" class="form-control"/>
              </div>
            </div>

            <div class="row pd-t-20">
              <div class="col-md-3">
                <input type="text" id="amount_in_word_top" name="amount_in_word_top" placeholder="top" class="form-control"/>
              </div>
              <div class="col-md-3">
                <input type="text" id="amount_in_word_left" name="amount_in_word_left" placeholder="left" class="form-control"/>
              </div>
            </div>

            <div class="row pd-t-20">
              <div class="col-md-3">
                <input type="text" id="ac_payee_only_top" name="ac_payee_only_top" placeholder="top" class="form-control"/>
              </div>
              <div class="col-md-3">
                <input type="text" id="ac_payee_only_left" name="ac_payee_only_left" placeholder="left" class="form-control"/>
              </div>
            </div>

          </div>
        </div>
      </div>
  </div>

  <script>
    function divHeight(height){
      document.getElementById("containment-wrapper").style.height = height+"mm";
    }

    function divWidth(width){
      document.getElementById("containment-wrapper").style.width = width+"mm";
    }

    function PrintElem(){
        var mywindow = window.open('', 'PRINT');
        mywindow.document.write('<style>#containment-wrapper{margin-left:20px;margin-top:-10px;background-color:black;}</style>');
        mywindow.document.write(document.getElementById('printArea').innerHTML);

        mywindow.document.close();
        mywindow.focus();

        mywindow.print();
        mywindow.close();

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
      document.getElementById('display').style.display = 'block';

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
          
          document.getElementById('top').value = Math.round(datePositions.date.top * 0.2645833333);
          document.getElementById('left').value = Math.round(datePositions.date.left * 0.2645833333);
        }
      });
    }

    function payeeDrag(){
      document.getElementById('display').style.display = 'block';

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
          
          document.getElementById('top').value = Math.round(payeePositions.payee.top * 0.2645833333);
          document.getElementById('left').value = Math.round(payeePositions.payee.left * 0.2645833333); 
        }
      });
    }

    function amountDrag(){
      document.getElementById('display').style.display = 'block';

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
        
          document.getElementById('top').value = Math.round(amountPositions.amount.top * 0.2645833333);
          document.getElementById('left').value = Math.round(amountPositions.amount.left * 0.2645833333);
        }
      });
    }

    function amountWordDrag(){
      document.getElementById('display').style.display = 'block';

      var sAmountWordPosition = "{}",
      amountWordPositions = JSON.parse(sAmountWordPosition);
      $.each(amountWordPositions, function (id, pos) {
        $("#" + id).css(pos)
      })
      $("#amount_in_word").draggable({
        containment: "#containment-wrapper",
        scroll: false,
        stop: function (event, ui) {
          amountWordPositions[this.id] = ui.position
          document.getElementById('amount_in_word_top').value = Math.round(amountWordPositions.amount_in_word.top * 0.2645833333);
          document.getElementById('amount_in_word_left').value = Math.round(amountWordPositions.amount_in_word.left * 0.2645833333);
          
          document.getElementById('top').value = Math.round(amountWordPositions.amount_in_word.top * 0.2645833333);
          document.getElementById('left').value = Math.round(amountWordPositions.amount_in_word.left * 0.2645833333);
        }
      });
    }
    
  </script>
@endsection