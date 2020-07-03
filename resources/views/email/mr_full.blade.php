<style>
    @page { margin: 0px;}
    body { margin: 0px; size: A4; font-family: Arial;}
</style>

<div id="printArea">
    <div id="containment-wrapper" style="font-family: Arial; padding:30px">
        <div style="float: left;width:45%;">
            <h1 style="font-size: 20px; font-weight: bold;">{{$company->name}}</h1>
            <div style="margin-top:-10px">{{$company->address}}</div>
            <div>Phone: {{$company->phone}}</div>
            <div>Email: {{$company->email}}</div>
        </div>
    
        <div style="float: right; height:58px;margin-top: 15px;">
            <img src="https://i.imgur.com/krDtxi6.png" height="100"/>
        </div>
    
        <div style="text-align: center; font-size: 27px; font-weight: bold; margin-top: 160px;margin-bottom:50px;padding-bottom:5px;">Money Receipt</div>
    
        <div style="float:left; width: 45%;">
            <div style="font-weight: bold; font-size: 19px;margin-top:-20px;">Received From</div>
    
            <div style="border: 1px solid; padding-bottom: 10px; padding-top: 10px; padding-left: 10px; padding-right: 5px;height:70px" >
            <div>{{$transaction->customer_name}}</div>
            <div>{{$transaction->customer_address}}</div>
            </div>
        </div>
    
        <div style="float: right;">
            <div>
            	<div style="font-weight: bold; padding-right: 160px;">Money Receipt No</div>
            	<div style="border: 1px solid; height: 22px; width: 150px; margin-top: -29px; text-align: center; padding-top: 4px;margin-left: 150px">hi</div>
            	</div><br>
            <div>
            	<div style="font-weight: bold; padding-right: 160px;">Money Receipt Date</div>
            	<div style="border: 1px solid; height: 22px; width: 150px; margin-top: -29px; text-align: center; padding-top: 4px;margin-left: 150px">hello
            	</div>
            </div><br>
            	<div>
            	<div style="font-weight: bold; padding-right: 160px;">Payment Method</div>
            	<div style="border: 1px solid; height: 22px; width: 150px; margin-top: -29px; text-align: center; padding-top: 4px;margin-left: 150px">Bkash
            	</div>
            </div>
        </div>
        
        <div style="margin-top:150px;">
            <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                <th style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:13px;">Sl</th>
                <th style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:13px;">Currency</th>
                <th style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:13px;">Cheque No</th>
                <th style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:13px;">Cheque Date</th>
                <th style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:13px;">Bank Name</th>
                <th style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:13px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">1</td>
                <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">{{$transaction->currency}}</td>
                <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">{{$transaction->cheque_no}}</td>
                <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">@if($transaction->cheque_date != "1970-01-01"){{date('d-m-Y',strtotime($transaction->cheque_date))}}@endif</td>
                <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">{{$transaction->bank_name}}</td>
                <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;text-align:right;padding-right:5px;">{{$transaction->amount}}</td>
                </tr>

                <tr>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">&nbsp;</td>
                </tr>

                <tr>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">&nbsp;</td>
                </tr>

                <tr>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">&nbsp;</td>
                </tr>

                <tr>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">&nbsp;</td>
                </tr>

                <tr>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">&nbsp;</td>
                </tr>

                <tr>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">&nbsp;</td>
                </tr>

                <tr>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">&nbsp;</td>
                </tr>

                <tr>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;"></td>
                    <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-size:14px;">&nbsp;</td>
                </tr>

                <tr style="border: 1px solid black;padding-top:5px;padding-bottom:5px;">
                <td colspan="5" style="text-align: right;padding-top:5px;padding-bottom:5px;padding-right:10px;font-weight:bold;">Total</td>
                <td style="text-align: center; border: 1px solid black;padding-top:5px;padding-bottom:5px;font-weight:bold;text-align:right;padding-right: 5px">{{$transaction->amount}}</td>
                </tr>
            </tbody>
            </table>
        </div>
    
        <div style="margin-top: 25px;">
            <div style="float: left;">Amount in Word</div>
            <div style="float: right; width:81%;">{{$transaction->amount_in_word}}</div>
            <br>
            <div style="float: left; padding-left: 129px; margin-top: -13px;">___________________________________________________________________
            </div>
        </div>
        <br>
    
        <div style="margin-top: 10px;">
            <div style="float: left;">Purpose
            </div>
            <div style="float: left; padding-left: 76px;">{{$transaction->purpose}}
            </div>
            <br>
            <div style="float: left; padding-left: 128px; margin-top: -13px;">___________________________________________________________________
            </div>
        </div>
        <br>
    
        <div style="margin-top: 35px; float: left;">
            <div style="text-align: center;">
            </div>
            <div style="margin-top: -32px;">__________________
            </div><br>
            <div style="margin-left: 37px; margin-top: -16px;">Received By
            </div>
        </div>
    
        <div style="margin-top: 35px; float: right;">
            <div style="text-align: center;">
            </div>
            <div style="margin-top: -32px;">______________________
            </div><br>
            <div style="margin-left: 50px; margin-top: -16px;">Authorized By
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>

        <div style="font-size:12px;float:left;width:100%;text-align:center;margin-top: 35px;">
            This is a System Generated Money Receipt. No Signatory is Required.
        </div>
    </div>
</div>