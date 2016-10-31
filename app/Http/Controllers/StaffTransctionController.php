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

class StaffTransctionController extends Controller
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
     	$page = 'staff_transction';
      $getTypes = $this->getTypes(); 
      $getCurrencys = $this->getCurrencys();
     	$transctions = DB::table('tbl_staff_transction')
     					->leftjoin('tbl_staff', 'tbl_staff_transction.s_id','=','tbl_staff.s_id')
     					->orderBy('tbl_staff_transction.st_date_diposit','DESC')->get();
     	return view('staff_transction.index', compact('transctions','page','getTypes','getCurrencys'));
    }

    public function create(){
    	$page = 'add_staff_transction';
      $getTypes = $this->getTypes(); 
      $getCurrencys = $this->getCurrencys(); 
    	$staffs = DB::table('tbl_staff')
    			->orderBy('s_name','ASC')
    			->pluck('s_name', 's_id')->all();
    			// dd($staffs);
	    return view('staff_transction.create', compact('page','staffs','getTypes','getCurrencys'));
    }

    public function store(Request $request)
    {
     	$s_id = $request->s_id;
	    $st_price = $request->st_price;
	    $st_currency = $request->st_currency;
	    $st_type = $request->st_type;
	    $st_date_diposit = $request->st_date_diposit;
      $st_remark = $request->st_remark;
	    $st_by = Session::get('iduserlot');
      $balance = 0;
      if(preg_match("/^[0-9,]+$/", $st_price)){
        $balance = str_replace(',', '', $st_price);
      }
	      		$id_s = 1;
	      
	            $draft =  DB::table('tbl_staff_transction')->orderBy('st_id', 'DESC')->take(1)->get();
	            if ($draft){
	                foreach ($draft as $id) {
	                        $id_s = $id->st_id + 1;
	                }
	            }


	            $check = DB::table('tbl_staff_transction')->insert([
	                        'st_id' => $id_s,
	                        'st_price' => $balance,
	                        'st_currency' => $st_currency,
	                        'st_type' => $st_type,
	                        'st_date_diposit' => $st_date_diposit,
                          'st_remark' => $st_remark,
	                        's_id' => $s_id,
	                        'st_by' => $st_by
	                        ]
	                    ); 
	            if($check){
	                flash()->success("ប្រតិបត្តិការត្រូវបានរក្សាទុក");
	                return redirect('/stafftransction');
	            }else{
	             flash()->error("ប្រតិបត្តិការមិនត្រូវបានរក្សាទុក");
	               return redirect('/stafftransction/create')->withInput(); 
	            }
    }
    public function edit($id)
    {
	    $page = 'staff_transction';
      $getTypes = $this->getTypes(); 
      $getCurrencys = $this->getCurrencys(); 
	    $transction = DB::table('tbl_staff_transction')->where('st_id',$id)->first();  
	    $staffs = DB::table('tbl_staff')
    			->orderBy('s_name','ASC')
    			->pluck('s_name', 's_id')->all();
	    return view('staff_transction.edit', compact('page','transction','staffs','getTypes','getCurrencys'));
    }

    public function update(Request $request, $id){   

	  	$s_id = $request->s_id;
	    $st_price = $request->st_price;
	    $st_currency = $request->st_currency;
	    $st_type = $request->st_type;
	    $st_date_diposit = $request->st_date_diposit;
      $st_remark = $request->st_remark;
      $balance = 0;
      if(preg_match("/^[0-9,]+$/", $st_price)){
        $balance = str_replace(',', '', $st_price);
      }

    		$check = DB::table('tbl_staff_transction')->where('st_id', $id)->update(
                    [
                        'st_price' => $balance,
                        'st_currency' => $st_currency,
                        'st_type' => $st_type,
                        'st_date_diposit' => $st_date_diposit,
                        'st_remark' => $st_remark,
                        's_id' => $s_id
                    ]
                );
             
            if($check){
                flash()->success(trans('message.update_success'));
                return redirect('stafftransction/'.$id.'/edit');
            }else{
             flash()->error(trans('message.update_error'));
              return redirect('stafftransction/'.$id.'/edit')->withInput();
            }
    }

    public function deleteItem(Request $request){
      	$id = $request->id;
      	
      		$check = DB::table('tbl_staff_transction')->where('st_id', $id)->delete();
	        if($check){
	          return response(['msg' => $id, 'status' => 'success']);  
	        }else{
	          return response(['msg' => '', 'status' => 'error']); 
	        } 
      	   
    }


    private function getTypes(){
      $result = DB::table('tbl_parameter_type')
              ->where('tbl_parameter_type.pat_key','=','type')
              ->join('tbl_parameter_value','tbl_parameter_type.pat_id','=','tbl_parameter_value.pat_id')
              ->pluck('pav_value','pav_id')->all();
      return $result;
    }

    private function getCurrencys(){
      $result = DB::table('tbl_parameter_type')
              ->where('tbl_parameter_type.pat_key','=','currency')
              ->join('tbl_parameter_value','tbl_parameter_type.pat_id','=','tbl_parameter_value.pat_id')
              ->pluck('pav_value','pav_id')->all();
      return $result;
    }



}
