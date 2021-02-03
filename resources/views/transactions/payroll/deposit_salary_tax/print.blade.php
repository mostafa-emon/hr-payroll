<div id="printArea">
    <div style="padding-right:300px;">
        <div style="text-align:center;">
            চালান ফরম
        </div>
    
        <div style="text-align:center;">
            টি, আর ফরম নং ৬ (এস, আর ৩৭ দ্রষ্টব্য)
        </div>
    </div>

    <div style="float:right;padding-right:150px;margin-top:-30px;">
        <table style="border: 1px solid black;">
            <tr>
                <td style="border-right: 1px solid black;">
                    ১ম (মুল কপি)
                </td>
                <td style="border-right: 1px solid black;">
                    ২য় কপি
                </td>
                <td>
                    ৩য় কপি
                </td>
            </tr>
        </table>
    </div>

    <br>

    <div style="float:left;padding-left:40px;">
        <div style="margin-bottom:15px;">
            <span>
                চালান নং...........................................................
            </span>
            <span>
                তারিখঃ...................................................
            </span>
            <div style="padding-left:68px;margin-top:-22px;">
                <span>
                    {{$tax->challan_no}}
                </span>
                <span style="padding-left:236px;">
                    {{date('d/m/y')}}
                </span>
            </div>
        </div>

        <div>
            <span>
                বাংলাদেশ ব্যাংক লিমিটেড এর/ সোনালী ব্যাংক লিমিটেড এর........................................
            </span>
            <span>
                জেলার.................................
            </span>
            <span>
                শাখায় টাকা জমা দেওয়ার চালান
            </span>
            
        </div>

        <br>

        <div>
            <div>
                কোড নং
            </div>
            <div style="padding-left:150px;margin-top:-23px;">
                <span>
                    <table>
                        <tr>
                            @php
                                $length = strlen($code_no);
                                $a = substr($code_no, 0 , -($length - 1));
                                $b = substr($code_no, 1 , -($length - 2));
                                $c = substr($code_no, 2 , -($length - 3));
                                $d = substr($code_no, 3 , -($length - 4));
                                $e = substr($code_no, 4 , -($length - 5));
                                $f = substr($code_no, 5 , -($length - 6));
                                $g = substr($code_no, 6 , -($length - 7));
                                $h = substr($code_no, 7 , -($length - 8));
                                $i = substr($code_no, 8 , -($length - 9));
                                $j = substr($code_no, 9 , -($length - 10));
                                $k = substr($code_no, 10 , -($length - 11));
                                $l = substr($code_no, 11 , -($length - 12));
                                $m = substr($code_no,($length - 1));
                            @endphp
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$a}}</td>
                            <td style="width:25px;height:22px;text-align:center;">&nbsp</td>
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$b}}</td>
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$c}}</td>
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$d}}</td>
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$e}}</td>
                            <td style="width:25px;height:22px;text-align:center;">&nbsp</td>
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$f}}</td>
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$g}}</td>
                            <td style="width:25px;height:22px;border: 1px solid black;;text-align:center;">{{$h}}</td>
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$i}}</td>
                            <td style="width:25px;height:22px;text-align:center;">&nbsp</td>
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$j}}</td>
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$k}}</td>
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$l}}</td>
                            <td style="width:25px;height:22px;border: 1px solid black;text-align:center;">{{$m}}</td>
                        </tr>
                        
                    </table>
                </span>
            </div>
            
        </div>
        <br>

    </div>


    <table style="width: 100%;border: 1px solid black;border-collapse: collapse;">
        <tr>
            <td colspan="4" style="width:70%;text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">জমা প্রদানকারী কর্তৃক পূরণ করিতে হইবে</td>
            <td colspan="2" style="width:20%;text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">টাকার অংক</td>
            <td rowspan="2" style="width:10%;text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">বিভাগের নাম এবং চালানের পৃষ্ঠাংকনকারী কর্মকর্তার নাম, পদবী ও দপ্তর।*</td>
        </tr>
        <tr>
            <td style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">যাহার মারফত প্রদান হইল তাহার নাম ও ঠিকানা।</td>
            <td style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">যে ব্যক্তির/প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম, পদবী ও ঠিকানা।</td>
            <td style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">কি বাবদ জমা দেওয়া হইল তাহার বিবরণ।</td>
            <td style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">মুদ্রা ও নোটের বিবরণ/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ।</td>
            <td style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">টাকা</td>
            <td style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">পয়সা</td>
        </tr>
        <tr>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">{!!$tax->text_1!!}</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">{!!$tax->text_2!!}</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">{!!$tax->text_3!!}</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">{!!$tax->text_4!!}</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
        </tr>
        <tr>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
        </tr>
        <tr>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
        </tr>
        <tr>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
        </tr>
        <tr>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
        </tr>
        <tr>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
        </tr>
        <tr>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
        </tr>
        <tr>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:center;border-right: 1px solid black;padding:5px;">&nbsp</td>
            <td style="text-align:right;border-top: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">মোট টাকা</td>
            <td style="text-align:center;border-top: 1px solid black;border-right: 1px solid black;padding:5px;border-bottom: 1px solid black;">&nbsp</td>
            <td style="text-align:center;border-top: 1px solid black;border-right: 1px solid black;padding:5px;border-bottom: 1px solid black;">&nbsp</td>
            <td style="text-align:center;border-top: 1px solid black;border-right: 1px solid black;padding:5px;border-bottom: 1px solid black;">&nbsp</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:left;border-top: 1px solid black;">টাকা কথায়ঃ</td>
            <td rowspan="3" colspan="3" style="text-align:center;border-left: 1px solid black;border-right: 1px solid black;padding:5px;">
                <div>
                    ম্যানেজার
                </div>
                <div>
                    বাংলাদেশ ব্যাংক/সোনালী ব্যাংক লিমিটেড
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:left;border-top: 1px solid black;">টাকা পাওয়া গেল</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:left;border-top: 1px solid black;">তারিখঃ..............................</td>
        </tr>

    </table>
    
    <br>

    <div style="float:left;">
        <div>
            <span>
                নোটঃ
            </span>
                
            <div style="padding-left:50px;margin-top:-22px;">
                ০১। সংশ্লিষ্ট দপ্তরের সহিত যোগাযোগ করিয়া সঠিক কোড নম্বর জানিয়া লইবেন ।
                <br>
                ০২। সংশ্লিষ্ট দপ্তরের সহিত যোগাযোগ করিয়া সঠিক কোড নম্বর জানিয়া লইবেন ।
            </div>
            
        </div>
    </div>

</div>

<script>
    var mywindow = window.open('', 'PRINT');
    mywindow.document.write('<style>body {zoom:80%;}</style>');
    mywindow.document.write(document.getElementById('printArea').innerHTML);

    setTimeout(function () {
        mywindow.focus();
        mywindow.print();
        mywindow.close();
        window.location = "/deposit-salary-tax"
    }, 1000);
</script>
