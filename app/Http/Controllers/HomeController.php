<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Company;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_company      = Company::count();
        $pending_company    = Company::where('status',0)->count();
        $active_company     = Company::join('subscriptions','subscriptions.id','companies.subscription_id')->where('subscriptions.subscription_end_date','>=',date('Y-m-d'))->count();
        $expired_company    = Company::join('subscriptions','subscriptions.id','companies.subscription_id')->where('subscriptions.subscription_end_date','<',date('Y-m-d'))->count();

        return view('welcome', [
            'total_company'     => $total_company,
            'pending_company'   => $pending_company,
            'active_company'    => $active_company,
            'expired_company'   => $expired_company
        ]);
    }
    
    public function pageNotFound(){
        return view('404');
    }

    public function logout(){
        Auth::logout();
        return redirect('login');
    }

    public function leftmenu_color($color) {
        $user = User::where('id',Auth::user()->id)->first();
        if($color == "light") { $user->leftmenu_color = ""; }
        else if($color == "blue") { $user->leftmenu_color = "leftmenu-color"; }
        else if($color == "dark") { $user->leftmenu_color = "leftmenu-dark"; }
        else if($color == "gradient") { $user->leftmenu_color = "leftmenu-gradient"; }
        $user->save();
        
        return back();
    }

    public function download_file($location,$name) {
        $path = 'storage/'.$location.'/'.$name;
        return response()->download($path);
    }
}