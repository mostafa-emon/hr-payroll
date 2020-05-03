<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiteOffice;
use Auth;

class SiteOfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $siteoffice = SiteOffice::orderBy('name', 'asc')->paginate(10);
        return view('siteoffices.index', ['siteoffices'=>$siteoffice]);
    }
    
    public function add(Request $request){
        if($request->name !=""){
            $siteoffice = new SiteOffice();
            $siteoffice->name             = $request->name;
            $siteoffice->address          = $request->address;
            $siteoffice->phone            = $request->phone;
            $siteoffice->email            = $request->email;
            $siteoffice->mr_suffix   = $request->mr_suffix;
            $siteoffice->mr_prefix   = $request->mr_prefix;
            $siteoffice->mr_start_from   = $request->mr_start_from;
            $siteoffice->save();
            return redirect('site-office')->with('message', 'Site Office added successfully!');
        }
        return view('siteoffices.add');
    }

    public function delete($siteoffice_id){
        $siteoffice = SiteOffice::find($siteoffice_id);
        $siteoffice->delete();
        return redirect('site-office')->with('message', 'Site Office deleted successfully!');
    }

    public function update($siteoffice_id, Request $request){
        if($request->name !=""){
            $siteoffice = SiteOffice::where('id',$siteoffice_id)->first();
            $siteoffice->name             = $request->name;
            $siteoffice->address          = $request->address;
            $siteoffice->phone            = $request->phone;
            $siteoffice->email            = $request->email;
            $siteoffice->mr_suffix   = $request->mr_suffix;
            $siteoffice->mr_prefix   = $request->mr_prefix;
            $siteoffice->mr_start_from   = $request->mr_start_from;
            $siteoffice->save();
            return redirect('site-office')->with('message', 'Site Office updated successfully!');
        }
        $siteoffices = SiteOffice::where('id',$siteoffice_id)->first();
        return view('siteoffices.update', ['siteoffices' => $siteoffices]);
    }
}
