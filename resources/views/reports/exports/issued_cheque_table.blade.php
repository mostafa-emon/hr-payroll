<table style="width:100%;">
    <thead>
        <tr>
            <td colspan="9" class="no-border" style="text-align: center; font-size:17px; font-weight:bold;">{{ $company->name}}</td>
        </tr>
        <tr>
            <td colspan="9" class="no-border" style="text-align: center;font-size:15px; font-weight:bold;">Issued Cheque</td>
        </tr>
        <tr>
            <td colspan="9" class="no-border" style="text-align: center;font-size:13px; font-weight:bold;">From {{ date('d-M-Y',strtotime($from_date)) }} to {{ date('d-M-Y',strtotime($to_date)) }}</td>
        </tr>
        <tr>
            <th style="text-align: center">Sl</th>
            <th style="text-align: center">Date</th>
            <th>Bank</th>
            <th>Account</th>
            <th>Book No.</th>
            <th>Cheque No.</th>
            <th>Payee</th>
            <th style="text-align: center">Status</th>
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
            <td style="text-align: right">
                @if($cheque->status == 0)
                    @if($setting->approval_for_cheque == 1)
                        <span style="color:#FF9633">Pending</span>
                    @else
                        <span style="color:green">Issued</span>
                    @endif
                @endif
                @if($cheque->status == 1)
                    <span style="color:green">Approved</span>
                @endif
                @if($cheque->status == 2)
                    <span style="color:red">Rejected</span>
                @endif
                @if($cheque->status == 3)
                <span style="color:red">Void</span>
                @endif
            </td>
            <td style="text-align: right">{{ $cheque->amount }}</td>
        </tr>
        @endforeach
        <tr>
            <th colspan="8" style="text-align:right">Total</th>
            <th style="text-align:right" id="grandTotal">{{$total}}</th>
          </tr>
    </tbody>
</table>