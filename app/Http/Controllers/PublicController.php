<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use App\GovtHolidayDetail;

class PublicController extends Controller
{
    public function index($company_id) {
        $count = Attendance::where('company_id',$company_id)->where('date',date('Y-m-d'))->count();
        if($count == 0) {
            $is_govt_holiday = GovtHolidayDetail::where('company_id','');
        }
    } 
}
