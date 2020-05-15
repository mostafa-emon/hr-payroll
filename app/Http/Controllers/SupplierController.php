<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use DB;
use Auth;
use App\Helpers\ViewHelper;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $supplier = Supplier::orderBy('name', 'asc')->paginate(10);
        return view('suppliers.index', ['suppliers'=>$supplier]);
    }

    public function add(Request $request){
        if(roles() != "" && !in_array(8, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->name !=""){
            $supplier = new Supplier();
            $supplier->name             = $request->name;
            $supplier->cheque_name      = $request->cheque_name;
            $supplier->address          = $request->address;
            $supplier->phone            = $request->phone;
            $supplier->email            = $request->email;
            $supplier->contact_person   = $request->contact_person;
            $supplier->save();
            return redirect('supplier')->with('message', 'Supplier added successfully!');
        }
        return view('suppliers.add');
    }

    public function delete($supplier_id){
        if(roles() != "" && !in_array(10, json_decode(roles(),false))){
            return redirect('404');
        }
        $supplier = Supplier::find($supplier_id);
        $supplier->delete();
        return redirect('supplier')->with('message', 'Supplier deleted successfully!');
    }

    public function update($supplier_id, Request $request){
        if(roles() != "" && !in_array(9, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->name !=""){
            $supplier = Supplier::where('id',$supplier_id)->first();
            $supplier->name             = $request->name;
            $supplier->cheque_name      = $request->cheque_name;
            $supplier->address          = $request->address;
            $supplier->phone            = $request->phone;
            $supplier->email            = $request->email;
            $supplier->contact_person   = $request->contact_person;
            $supplier->save();
            return redirect('supplier')->with('message', 'Supplier updated successfully!');
        }
        $suppliers = Supplier::where('id',$supplier_id)->first();
        return view('suppliers.update', ['suppliers' => $suppliers]);
    }
}
