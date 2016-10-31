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

class PosController extends Controller
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
     	$page = 'pos';
     	$poss = DB::table('tbl_pos')
     					->orderBy('pos_time','ASC')
     					->orderBy('pos_name','ASC')
     					->get();
     	$times = $this->getTime();
     	return view('pos.index', compact('poss','page','times'));
    }

    public function create(){
    	$page = 'add_pos';
    	$times = $this->getTime();
	    return view('pos.create', compact('page','times'));
    }
    public function store(Request $request)
    {
     	$pos_time = $request->pos_time;
	    $pos_name = $request->pos_name;
	    $pos_two_digit = $request->pos_two_digit;
	    $pos_three_digit = $request->pos_three_digit;
	    $pos_info = $request->pos_info;

	    $id_s = 1;
        $draft =  DB::table('tbl_pos')->orderBy('pos_id', 'DESC')->take(1)->get();
        if ($draft){
            foreach ($draft as $id) {
                    $id_s = $id->pos_id + 1;
            }
        }

	    $rule = [
	    	'pos_time' => 'required|unique:tbl_pos,pos_time,null,pos_id,pos_name,'.$pos_name,
	    	'pos_name' => 'required',
	    	'pos_two_digit' => 'required|integer',
	    	'pos_three_digit' => 'required|integer',
	    ];

	    $messages = [
	    	'pos_time.required' => trans('validation.custom.pos.time.required'),
	    	'pos_time.unique' => 'បុស្តិ៍ឈ្មោះ '.$pos_name.' មានរួចហើយ',
	    	'pos_name.required' => trans('validation.custom.pos.name.required'),
	    	'pos_two_digit.required' => trans('validation.custom.pos.number_2_digit.required'),
	    	'pos_two_digit.integer' => trans('validation.custom.pos.number_2_digit.integer'),
	    	'pos_three_digit.required' => trans('validation.custom.pos.number_3_digit.required'),
	    	'pos_three_digit.integer' => trans('validation.custom.pos.number_3_digit.integer')
	    ];

	    $validator = Validator::make($request->all(), $rule, $messages);

	    if ($validator->fails()) {
	        return redirect('pos/create')->withInput($request->all())->withErrors($validator);
	    }else{
	    	

            $check = DB::table('tbl_pos')->insert([
            			'pos_id' => $id_s,
                        'pos_time' => $pos_time,
                        'pos_name' => $pos_name,
                        'pos_two_digit' => $pos_two_digit,
                        'pos_three_digit' => $pos_three_digit,
                        'pos_info' => $pos_info
                       	]); 
            if($check){
                flash()->success(trans('message.add_success_pos'));
                return redirect('/pos');
            }else{
             flash()->error(trans('message.add_error_pos'));
               return redirect('/pos/create')->withInput(); 
            }

	    }
	      		
    }

    public function edit($id)
    {
	    $page = 'pos';  
	    $pos = DB::table('tbl_pos')->where('pos_id',$id)->first();
	    $times = $this->getTime(); 
	    return view('pos.edit', compact('page','pos','times'));
    }

    public function update(Request $request, $id){   
    	$pos_id = $id;
	  	$pos_time = $request->pos_time;
	    $pos_name = $request->pos_name;
	    $pos_two_digit = $request->pos_two_digit;
	    $pos_three_digit = $request->pos_three_digit;
	    $pos_info = $request->pos_info;

	    $rule = [
	    	'pos_time' => 'required|unique:tbl_pos,pos_time,'.$pos_id.',pos_id,pos_name,'.$pos_name,
	    	'pos_name' => 'required',
	    	'pos_two_digit' => 'required|integer',
	    	'pos_three_digit' => 'required|integer',
	    ];

	    $messages = [
	    	'pos_time.required' => trans('validation.custom.pos.time.required'),
	    	'pos_time.unique' => 'បុស្តិ៍ឈ្មោះ '.$pos_name.' មានរួចហើយ',
	    	'pos_name.required' => trans('validation.custom.pos.name.required'),
	    	'pos_two_digit.required' => trans('validation.custom.pos.number_2_digit.required'),
	    	'pos_two_digit.integer' => trans('validation.custom.pos.number_2_digit.integer'),
	    	'pos_three_digit.required' => trans('validation.custom.pos.number_3_digit.required'),
	    	'pos_three_digit.integer' => trans('validation.custom.pos.number_3_digit.integer')
	    ];

	    $validator = Validator::make($request->all(), $rule, $messages);

	    if ($validator->fails()) {
	        return redirect('pos/'.$id.'/edit')->withInput($request->all())->withErrors($validator);
	    }else{
            $check = DB::table('tbl_pos')->where('pos_id', $id)->update([
                        'pos_time' => $pos_time,
                        'pos_name' => $pos_name,
                        'pos_two_digit' => $pos_two_digit,
                        'pos_three_digit' => $pos_three_digit,
                        'pos_info' => $pos_info
                       	]); 
            if($check){
                flash()->success(trans('message.update_success'));
                return redirect('pos/'.$id.'/edit');
            }else{
             flash()->error(trans('message.update_error'));
               return redirect('pos/'.$id.'/edit')->withInput(); 
            }
	    }
    }


    public function deleteItem(Request $request){
      	$id = $request->id;
      	$checkStcItem = DB::table('tbl_pos')
		      		->where('pos_id','=',$id)
		      		->first();

      	if($checkStcItem){

      		$check = DB::table('tbl_pos_group')
      					->where('pos_id','=',$id)->first();
	      	if($check){
	      		return response(['msg' => trans('message.not_permission_delete'), 'status' => 'error']); 
	      	}else{
	      		$check = DB::table('tbl_pos')->where('pos_id', $id)->delete();
		        if($check){
		          return response(['msg' => $id, 'status' => 'success']);  
		        }else{
		          return response(['msg' => trans('message.fail_delete'), 'status' => 'error']); 
		        } 
	      	}

      	}else{
      		return response(['msg' => trans('message.fail_delete'), 'status' => 'error']); 
      	}
    }



    private function getTime(){
    	$result = DB::table('tbl_parameter_type')
    					->where('tbl_parameter_type.pat_key','=','sheet')
    					->join('tbl_parameter_value','tbl_parameter_type.pat_id','=','tbl_parameter_value.pat_id')
    					->pluck('pav_value','pav_id')->all();
    	return $result;
    }

}
