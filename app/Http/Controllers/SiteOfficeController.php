<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiteOffice;
use DB;
use Auth;
use App\Helpers\ViewHelper;

class SiteOfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $site_office = SiteOffice::orderBy('name', 'asc')->paginate(10);
        return view('site_offices.index', ['site_offices'=>$site_office]);
    }
    
    public function add(Request $request){
        if(roles() != "" && !in_array(2, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->name !=""){
            $site_office = new SiteOffice();
            $site_office->name               = $request->name;
            $site_office->address            = $request->address;
            $site_office->phone              = $request->phone;
            $site_office->email              = $request->email;
            $site_office->mr_suffix          = $request->mr_suffix;
            $site_office->mr_prefix          = $request->mr_prefix;
            $site_office->mr_start_from      = $request->mr_start_from;
            $site_office->save();
            return redirect('site-office')->with('message', 'Site Office added successfully!');
        }
        return view('site_offices.add');
    }

    public function delete($site_office_id){
        if(roles() != "" && !in_array(4, json_decode(roles(),false))){
            return redirect('404');
        }
        $site_office = SiteOffice::find($site_office_id);
        $site_office->delete();
        return redirect('site-office')->with('message', 'Site Office deleted successfully!');
    }

    public function update($site_office_id, Request $request){
        if(roles() != "" && !in_array(3, json_decode(roles(),false))){
            return redirect('404');
        }

        if($request->name !=""){
            $site_office = SiteOffice::where('id',$site_office_id)->first();
            $site_office->name               = $request->name;
            $site_office->address            = $request->address;
            $site_office->phone              = $request->phone;
            $site_office->email              = $request->email;
            $site_office->mr_suffix          = $request->mr_suffix;
            $site_office->mr_prefix          = $request->mr_prefix;
            $site_office->mr_start_from      = $request->mr_start_from;
            $site_office->save();
            return redirect('site-office')->with('message', 'Site Office updated successfully!');
        }
        $site_offices = SiteOffice::where('id',$site_office_id)->first();
        return view('site_offices.update', ['site_offices' => $site_offices]);
    }
}
