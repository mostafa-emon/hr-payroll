<div id="printArea">
    <div class="visibility: hidden">
        @php if($ot_format !=""){ echo $ot_format->top_text;} @endphp

        <br>
    </div>

    <div class="table-responsive">
        <table style="width:100%;" class="table table-striped table-bordered mg-b-0 text-md-nowrap">
            <thead>
                <tr>
                    <th style="width:3%;vertical-align: middle;text-align:center;">SL</th>
                    <th style="width:12%;vertical-align: middle;text-align:center;">Employee ID</th>
                    <th style="width:25%;vertical-align: middle;text-align:left;">Employee Name</th>
                    <th style="width:15%;vertical-align: middle;text-align:left;">Department</th>
                    <th style="width:15%;vertical-align: middle;text-align:left;">Designation</th>
                    <th style="width:15%;vertical-align: middle;text-align:left;">Bank Account No</th>
                    <th style="width:15%;vertical-align: middle;text-align:right;">Payable Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td style="vertical-align: middle;text-align:center;">{{$loop->iteration}}</td>
                        <td style="vertical-align: middle;text-align:center;">{{get_employee_id($employee->employee_id)}}</td>
                        <td style="vertical-align: middle;text-align:left;">{{employee_name_by_increment_id($employee->employee_id)}}</td>
                        <td style="vertical-align: middle;text-align:left;">{{employee_department($employee->employee_id)}}</td>
                        <td style="vertical-align: middle;text-align:left;">{{employee_designation($employee->employee_id)}}</td>
                        <td style="vertical-align: middle;text-align:left;">{{bank_account_no($employee->employee_id)}}</td>
                        <td style="vertical-align: middle;text-align:right;">{{$employee->ot_amount}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="visibility: hidden">
        <br>

        @php if($ot_format !=""){ echo $ot_format->bottom_text;} @endphp
    </div>

</div>

<script>
    var mywindow = window.open('', 'PRINT');
    mywindow.document.write('<style>table {border-collapse: collapse;} th, td {border: 1px solid black;font-family:arial;font-size:13px;padding:7px;} .div-padding-30{padding:30px;}</style>');
    mywindow.document.write(document.getElementById('printArea').innerHTML);

    setTimeout(function () {
        mywindow.focus();
        mywindow.print();
        mywindow.close();
        window.location = "/ot-transfer-letter"
    }, 1000);

</script>