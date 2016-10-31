<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use Validator;
use Flash;
use Redirect;
use Hash;
use Session;

class UserController extends Controller
{
    public function __construct()
    {
    	$this->middleware(function ($request, $next) {
	 		  if(!Session::has('iduserlot'))
		       {
		            Redirect::to('/login')->send();
		       }
            return $next($request);
        });
   
    }
	public function index()
    {
     	$page = 'user';
     	$users = DB::table('tbl_user')->orderBy('u_name','ASC')->get();
     	return view('user.index', compact('users','page'));
    }

    public function create(){
    	$page = 'add_user';
	    return view('user.create', compact('page'));
    }

    public function deleteItem(Request $request){
        $id = $request->id;
        $check = DB::table('tbl_paper')->where('u_id',$id)->first();
        if($check){
          return response(['msg' => "This user have process on other page can't delete", 'status' => 'error']); 
        }else{
          $checkUser = DB::table('tbl_user')->where('u_id', $id)->delete();
          if($checkUser){
            return response(['msg' => $id, 'status' => 'success']);  
          }else{
            return response(['msg' => '', 'status' => 'error']); 
          }
        }
        
    }


    public function store(Request $request)
    {
     	$u_name = $request->u_name;
	    $u_phone = $request->u_phone;
	    $u_line = $request->u_line;
	    $role = $request->role;
	    $u_username = $request->u_username;
	    $u_password = $request->u_password;

	     $check = DB::table('tbl_user')->where('u_username', $u_username)->first();
       $checkphone = DB::table('tbl_user')->where('u_phone', $u_phone)->first();
	     if ($check){
	        flash()->error("User ".$u_username." have already exit. please try other username");
	        return redirect('user/create')->withInput();
	     }
       else if ($checkphone){
          flash()->error("The phone number ".$u_phone." have already exit. please try other number");
          return redirect('user/create')->withInput();
       } else{

	      		$id_u = 1;
	      
	            $draft =  DB::table('tbl_user')->orderBy('u_id', 'DESC')->take(1)->get();
	            if ($draft){
	                foreach ($draft as $id) {
	                        $id_u = $id->u_id + 1;
	                }
	            }


	            $check = DB::table('tbl_user')->insert([
	                        'u_id' => $id_u,
	                        'u_name' => $u_name,
	                        'u_phone' => $u_phone,
	                        'u_line' => $u_line,
	                        'role' => $role,
	                        'u_username' => $u_username,
	                        'u_password' => $u_password
	                        ]
	                    ); 
	            if($check){
	                flash()->success(trans('message.add_success'));
	                return redirect('/user');
	            }else{
	               flash()->error(trans('message.add_error'));
	               return redirect('/user/create')->withInput(); 
	            }
	        }
    }

    public function edit($id)
    {
	    $page = 'user';  
	    $user = DB::table('tbl_user')->where('u_id',$id)->first();  
	    return view('user.edit', compact('page','user'));
    }

    public function update(Request $request, $id){     
	  	$u_name = $request->u_name;
        $u_phone = $request->u_phone;
        $u_line = $request->u_line;
        $role = $request->role;
        $u_username = $request->u_username;
        $u_password = $request->new_password;

        $check = DB::table('tbl_user')->where('u_username', $u_username)->where('u_id','<>', $id)->first();
        if ($check){
            flash()->error("Your username ".$u_username." have already exit. please try other user");
           
            return redirect('user/'.$id.'/edit');
        }else{
        	if($u_password == ''){
        		$check = DB::table('tbl_user')->where('u_id', $id)->update(
                        [
                          'u_name' => $u_name,
                          'u_phone' => $u_phone,
                          'u_line' => $u_line,
                          'role' => $role,
                          'u_username' => $u_username
                        ]
                    );
        	}else{
        		$check = DB::table('tbl_user')->where('u_id', $id)->update(
                        [
                          'u_name' => $u_name,
                          'u_phone' => $u_phone,
                          'u_line' => $u_line,
                          'role' => $role,
                          'u_username' => $u_username,
                          'u_password' => $u_password
                        ]
                    );
        	}
             
            if($check){
                flash()->success(trans('message.update_success'));
                return redirect('user/'.$id.'/edit');
            }else{
                flash()->error(trans('message.update_error'));
                return redirect('user/'.$id.'/edit')->withInput();
            }
        }
    }


}
