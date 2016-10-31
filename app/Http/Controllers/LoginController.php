<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use URL;
use Session;
use Flash;
use Input;
use Redirect;
use Blade;
use DB;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
              if(Session::has('iduserlot'))
               {
                    Redirect::to('/dasboard')->send();
               }
            return $next($request);
        });
   
    }
    public function index(){
	  	$page = "login";
	    return view("login.index", compact('page'));
    }	
	
	public function store(Request $request){
	    $username = $request->get('userName');
        $password = $request->get('password');
        $minutes = 100800;
        $dateCurrent = date('Y-m-d H:i:s');
        $check = DB::table('tbl_user')->where('u_username', $username)->where('u_password', $password)->first();
        // dd($check);
        if ($check){ // check user have in table

          	 $id_user = $check->u_id;
             $username = $check->u_username;
             $name = $check->u_name;
             $phone = $check->u_phone;

             Session::put('iduserlot', $id_user);
             Session::put('usernameLot', $username);
             Session::put('nameLot', $name);
             Session::put('phoneLot', $phone);

             return redirect('/dasboard');

        }else{
        
          flash()->error("Wrong Username or Password. Please try again.");
             return redirect('/login')->withInput();
            
        }
	}
}
