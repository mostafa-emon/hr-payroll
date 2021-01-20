<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\SalarySheet;
use App\SalarySheetDetails;

class SalarySheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    }
}
