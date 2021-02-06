<div id="printArea">
    <table style="width: 100%;border-collapse: collapse;">
        <tr>
            <th style="border: 1px solid black;text-align:center;">SL</th>
            <th style="border: 1px solid black;text-align:left;">Employee ID</th>
            <th style="border: 1px solid black;text-align:left;">Name</th>
            <th style="border: 1px solid black;text-align:left;">Month</th>
            <th style="border: 1px solid black;text-align:right;">Amount</th>
        </tr>
        @foreach($employment_infos as $employee)
        <tr>
            <td style="border: 1px solid black;text-align:center;">{{$loop->iteration}}</td>
            <td style="border: 1px solid black;text-align:left;">{{$employee->original_employee_id}}</td>
            <td style="border: 1px solid black;text-align:left;">{{$employee->name}}</td>
            <td style="border: 1px solid black;text-align:left;">{{$employee->month}} {{$employee->year}}</td>
            <td style="border: 1px solid black;text-align:right;">{{$employee->amount}}</td>
        </tr>
        @endforeach
    </table>
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