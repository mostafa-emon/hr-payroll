<table style="width:100%;">
    <thead>
        <tr>
            <td colspan="8" class="no-border" style="text-align: center; font-size:17px; font-weight:bold;">{{ $company->name}}</td>
        </tr>
        <tr>
            <td colspan="8" class="no-border" style="text-align: center;font-size:15px; font-weight:bold;">Void Cheque</td>
        </tr>
        <tr>
            <td colspan="8" class="no-border" style="text-align: center;font-size:13px; font-weight:bold;">From {{ date('d-M-Y',strtotime($from_date)) }} to {{ date('d-M-Y',strtotime($to_date)) }}</td>
        </tr>
        <tr>
            <th style="text-align: center">Sl</th>
            <th style="text-align: center">Date</th>
            <th style="text-align: center">Bank</th>
            <th style="text-align: center">Account</th>
            <th style="text-align: center">Book No.</th>
            <th style="text-align: center">Cheque No.</th>
            <th style="text-align: center">Payee</th>
            <th style="text-align: center">Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cheques as $cheque)
        <tr>
            <td style="text-align: center">{{ $loop->iteration }}</td>
            <td style="text-align: center">{{ date('d-m-Y',strtotime($cheque->date)) }}</td>
            <td>{{ $cheque->bank_name }}</td>
            <td>{{ $cheque->ac_number }}</td>
            <td>{{ $cheque->book_no }}</td>
            <td>{{ $cheque->cheque_no }}</td>
            <td>{{ $cheque->cheque_name }}</td>
            <td style="text-align: right">{{ $cheque->amount }}</td>
        </tr>
        @endforeach
        <tr>
            <th colspan="7" style="text-align:right">Total</th>
            <th style="text-align:right" id="grandTotal">{{$total}}</th>
          </tr>
    </tbody>
</table>