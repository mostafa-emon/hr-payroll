<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use DB;
use Auth;
use App\Helpers\ViewHelper;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $customer = Customer::orderBy('name', 'asc')->get();
        return view('customers.index', ['customers'=>$customer]);
    }
    
    public function add(Request $request){
        if(roles() != "" && !in_array(5, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->name !=""){
            $customer = new Customer();
            $customer->name             = $request->name;
            $customer->address          = $request->address;
            $customer->phone            = $request->phone;
            $customer->email            = $request->email;
            $customer->contact_person   = $request->contact_person;
            $customer->save();
            return redirect('customer')->with('message', 'Customer added successfully!');
        }
        return view('customers.add');
    }

    public function delete($customer_id){
        if(roles() != "" && !in_array(7, json_decode(roles(),false))){
            return redirect('404');
        }
        $customer = Customer::find($customer_id);
        $customer->delete();
        return redirect('customer')->with('message', 'Customer deleted successfully!');
    }

    public function update($customer_id, Request $request){
        if(roles() != "" && !in_array(6, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->name !=""){
            $customer = Customer::where('id',$customer_id)->first();
            $customer->name             = $request->name;
            $customer->address          = $request->address;
            $customer->phone            = $request->phone;
            $customer->email            = $request->email;
            $customer->contact_person   = $request->contact_person;
            $customer->save();
            return redirect('customer')->with('message', 'Customer updated successfully!');
        }
        $customers = Customer::where('id',$customer_id)->first();
        return view('customers.update', ['customers' => $customers]);
    }
}
