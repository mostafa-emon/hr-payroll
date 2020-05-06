<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChequeLayout;
use App\Bank;

class ChequeLayoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $cheque_layout = ChequeLayout::select('cheque_layouts.*','banks.name as bank_name')
        ->join('banks','banks.id','cheque_layouts.bank_id')->orderBy('banks.name', 'asc')
        ->paginate(10);
        return view('cheque_layouts.index', ['cheque_layouts'=>$cheque_layout]);
    }
    public function add(Request $request){
        if($request->date !=""){
            $cheque_layout = new ChequeLayout();
            $cheque_layout->save();
            return redirect('cheque-layouts')->with('message', 'Cheque Layout added successfully!');
        }
        $banks = Bank::orderby('name','asc')->get();
        return view('cheque_layouts.add', ['banks' => $banks]);
    }

    public function delete($cheque_layout_id){
        $cheque_layout = ChequeLayout::find($cheque_layout_id);
        $cheque_layout->delete();
        return redirect('cheque-layouts')->with('message', 'Cheque Layout deleted successfully!');
    }

    public function update($cheque_layout_id, Request $request){
        if($request->date !=""){
            $cheque_layout = ChequeLayout::where('id',$cheque_layout_id)->first();
            $cheque_layout->save();
            return redirect('cheque-layouts')->with('message', 'Cheque Layout updated successfully!');
        }
        $cheque_layouts = ChequeLayout::where('id',$cheque_layout_id)->first();
        return view('cheque_layouts.update', ['cheque_layouts' => $cheque_layouts]);
    }
}
