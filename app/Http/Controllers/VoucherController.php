<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuickBook;
use Auth;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cash_payment(Request $request){
        if($request->from_date != "" && $request->to_date != "") {
            $token = getToken();
            $index = -1;
            $data = [];
            $CashOnHandID = [];
            $whereInIDs = "";

            // GET CASH_ON_HAND ACCOUNTS
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => config('app.qb_api_url')."/v3/company/4620816365062880570/query?minorversion=14",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"SELECT * FROM Account WHERE AccountType = 'Bank' AND AccountSubType = 'CashOnHand'",
            CURLOPT_HTTPHEADER => array(
                "User-Agent: Token ".$token,
                "Accept: application/json",
                "Content-Type: application/text",
                "Authorization: Bearer ".$token,
                "Cookie: qboeuid=dd7e3fce.5a8116cd35a6f"
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $accounts = json_decode($response, true);
            $resultCount = $accounts['QueryResponse']['maxResults'] - 1;
            if($resultCount > -1){
                for($i = 0; $i <= $resultCount; $i++) {
                    $CashOnHandID[] = $accounts['QueryResponse']['Account'][$i]['Id'];
                    $whereInIDs = $whereInIDs.",'".$accounts['QueryResponse']['Account'][$i]['Id']."'";
                }
            }
            $whereInIDs = ltrim($whereInIDs,',');

            // GET DATA FROM PURCHASE
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => config('app.qb_api_url')."/v3/company/4620816365062880570/query?minorversion=14",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"SELECT AccountRef,TxnDate,EntityRef,PrivateNote,TotalAmt,DocNumber,PaymentType FROM Purchase WHERE TxnDate >= '2020-06-16' AND TxnDate <= '2020-06-16'",
            CURLOPT_HTTPHEADER => array(
                "User-Agent: Token ".$token,
                "Accept: application/json",
                "Content-Type: application/text",
                "Authorization: Bearer ".$token,
                "Cookie: qboeuid=dd7e3fce.5a8116cd35a6f"
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $results = json_decode($response, true);
            $resultCount = $results['QueryResponse']['maxResults'] - 1;
            if($resultCount > -1){
                for($i = 0; $i <= $resultCount; $i++) {
                    if(in_array($results['QueryResponse']['Purchase'][$i]['AccountRef']['value'], $CashOnHandID)){
                        $index = $index + 1;

                        $data[$index]['TxnDate'] = $results['QueryResponse']['Purchase'][$i]['TxnDate'];
                        if($results['QueryResponse']['Purchase'][$i]['PaymentType'] == "Cash"){
                            $data[$index]['TxnType'] = 'Expense';
                        }else{
                            $data[$index]['TxnType'] = $results['QueryResponse']['Purchase'][$i]['PaymentType'];
                        }
                        
                        if(isset($results['QueryResponse']['Purchase'][$i]['DocNumber'])){
                            $data[$index]['DocNumber'] = $results['QueryResponse']['Purchase'][$i]['DocNumber'];
                        }else{
                            $data[$index]['DocNumber'] = "";
                        }
                        $data[$index]['PayeeName'] = $results['QueryResponse']['Purchase'][$i]['EntityRef']['name'];
                        $data[$index]['PaidFrom'] = $results['QueryResponse']['Purchase'][$i]['AccountRef']['name'];
                        if(isset($results['QueryResponse']['Purchase'][$i]['PrivateNote'])){
                            $data[$index]['Memo'] = $results['QueryResponse']['Purchase'][$i]['PrivateNote'];
                        }else{
                            $data[$index]['Memo'] = "";
                        }
                        $data[$index]['TotalAmt'] = $results['QueryResponse']['Purchase'][$i]['TotalAmt'];
                    }
                }
            }

            // GET DATA FROM BILL PAYMENT
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => config('app.qb_api_url')."/v3/company/4620816365062880570/query?minorversion=14",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"SELECT * FROM BillPayment WHERE BankAccountRef IN ($whereInIDs) AND TxnDate >= '2020-06-16' AND TxnDate <= '2020-06-16'",
            CURLOPT_HTTPHEADER => array(
                "User-Agent: Token ".$token,
                "Accept: application/json",
                "Content-Type: application/text",
                "Authorization: Bearer ".$token,
                "Cookie: qboeuid=dd7e3fce.5a8116cd35a6f"
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $results = json_decode($response, true);
            $resultCount = $results['QueryResponse']['maxResults'] - 1;
            if($resultCount > -1){
                for($i = 0; $i <= $resultCount; $i++) {
                    if(isset($results['QueryResponse']['BillPayment'][$i]['CheckPayment']['BankAccountRef']['value'])) {
                        if(in_array($results['QueryResponse']['BillPayment'][$i]['CheckPayment']['BankAccountRef']['value'], $CashOnHandID)){
                            $index = $index + 1;
                            $data[$index]['TxnDate'] = $results['QueryResponse']['BillPayment'][$i]['TxnDate'];
                            $data[$index]['TxnType'] = 'Pay Bills';
                            if(isset($results['QueryResponse']['BillPayment'][$i]['DocNumber'])){
                                $data[$index]['DocNumber'] = $results['QueryResponse']['BillPayment'][$i]['DocNumber'];
                            }else{
                                $data[$index]['DocNumber'] = "";
                            }
                            $data[$index]['PayeeName'] = $results['QueryResponse']['BillPayment'][$i]['VendorRef']['name'];
                            $data[$index]['PaidFrom'] = $results['QueryResponse']['BillPayment'][$i]['CheckPayment']['BankAccountRef']['name'];
                            if(isset($results['QueryResponse']['BillPayment'][$i]['PrivateNote'])){
                                $data[$index]['Memo'] = $results['QueryResponse']['BillPayment'][$i]['PrivateNote'];
                            }else{
                                $data[$index]['Memo'] = "";
                            }
                            $data[$index]['TotalAmt'] = $results['QueryResponse']['BillPayment'][$i]['TotalAmt'];
                        }
                    }
                }
            }

            return view('vouchers.cash_payment',compact('data'));
        }
        
        else{
            $data = [];
            return view('vouchers.cash_payment',compact('data'));
        }
    }
    
    public function bank_payment(){
        return view('vouchers.bank_payment');
    }

    public function cash_receipt(){
        return view('vouchers.cash_receipt');
    }

    public function bank_receipt(){
        return view('vouchers.bank_receipt');
    }

    public function void_voucher(){
        return view('vouchers.void');
    }

    public function contra_voucher(){
        return view('vouchers.contra');
    }

    public function journal_voucher(){
        return view('vouchers.journal');
    }
}
