<div id="printArea">
    <div style="font-family: Arial;padding:5px;font-side:13px;">
        <table style="width: 100%;border-collapse: collapse;">
            <tr>
                <th style="border: 1px solid black;text-align:center;padding:5px;">SL</th>
                <th style="border: 1px solid black;text-align:left;padding:5px;">Employee ID</th>
                <th style="border: 1px solid black;text-align:left;padding:5px;">Name</th>
                <th style="border: 1px solid black;text-align:left;padding:5px;">Month</th>
                <th style="border: 1px solid black;text-align:left;padding:5px;">Amount</th>
            </tr>
            @foreach($employment_infos as $employee)
            <tr>
                <td style="border: 1px solid black;text-align:center;padding:5px;">{{$loop->iteration}}</td>
                <td style="border: 1px solid black;text-align:left;padding:5px;">{{$employee->original_employee_id}}</td>
                <td style="border: 1px solid black;text-align:left;padding:5px;">{{$employee->name}}</td>
                <td style="border: 1px solid black;text-align:left;padding:5px;">{{$employee->month}} {{$employee->year}}</td>
                <td style="border: 1px solid black;text-align:right;padding:5px;">{{sprintf("%.2f", $employee->amount)}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

<script>
    var mywindow = window.open('', 'PRINT');
    mywindow.document.write(document.getElementById('printArea').innerHTML);

    setTimeout(function () {
        mywindow.focus();
        mywindow.print();
        mywindow.close();
        window.location = "/deposit-salary-tax"
    }, 1000);
</script>