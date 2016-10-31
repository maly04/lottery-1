<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Staff;
use App\Model\StaffCharge;

use DB;
use Validator;
use Flash;
use Redirect;
use Hash;
use Session;

class StaffController extends Controller
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
     	$page = 'staff';
     	$staffs = DB::table('tbl_staff')->orderBy('s_name','ASC')->get();
     	return view('staff.index', compact('staffs','page'));
    }
    public function create(){
    	$page = 'add_staff';
	    return view('staff.create', compact('page'));
    }

    public function store(Request $request)
    {
     	$s_name = $request->s_name;
	    $s_phone = $request->s_phone;
	    $s_line = $request->s_line;
	    $s_fb = $request->s_fb;
	    $s_address = $request->s_address;
	    $s_info = $request->s_info;

	    $s_start = $request->s_start;
	    $s_end = $request->s_end;
	    $s_two_digit_charge = $request->s_two_digit_charge;
	    $s_three_digit_charge = $request->s_three_digit_charge;

	     // $check = DB::table('tbl_staff')->where('s_name', $s_name)->first();

	    $rule = [
	    	's_name' => 'required|unique:tbl_staff',
            's_phone' => 'required|min:9',
            's_start' => 'required'
	    ];

	    $messages = [
	    	's_name.required' => 'សូមបញ្ចូលឈ្មោះ',
	    	's_name.unique' => 'ឈ្មោះគណនី​ '.$s_name.' មានរួចហើយ។​ សូមបញ្ចូលឈ្មោះថ្មី',
	    	's_phone.required' => 'សូមបញ្ចូលលេខទូរស័ព្ទ',
	    	's_phone.min' => 'សូមបញ្ចូលលេខទូរស័ព្ទ ៩ ឬ ១០ ខ្ទង់',
	    	's_start.required' => 'សូមបញ្ចូលកាលបរិច្ឆេទចាប់ផ្តើម',
	    ];

	    $validator = Validator::make($request->all(), $rule, $messages);

	    if ($validator->fails()) {
	        return redirect('staff/create')->withInput($request->all())->withErrors($validator);
	    }else{
	    	if($s_end){
	        	
	        	$start_date = new \DateTime($s_start);
	        	$end_date = new \DateTime($s_end);
	        	if($start_date > $end_date){
	        		$validator->errors()->add('s_end', 'ថ្ងៃបញ្ចប់បញ្ចប់មិនត្រឹមត្រូវ');
	        		return redirect('staff/create')->withInput($request->all())->withErrors($validator);
	        	}
	        }

      		$id_s = 1;
      
            $draft =  DB::table('tbl_staff')->orderBy('s_id', 'DESC')->take(1)->get();
            if ($draft){
                foreach ($draft as $id) {
                        $id_s = $id->s_id + 1;
                }
            }


            $check = DB::table('tbl_staff')->insert([
                        's_id' => $id_s,
                        's_name' => $s_name,
                        's_phone' => $s_phone,
                        's_line' => $s_line,
                        's_fb' => $s_fb,
                        's_address' => $s_address,
                        's_info' => $s_info,
                        's_start' => $s_start,
                        's_end' => $s_end
                        ]
                    );


            if($check){
                flash()->success(trans('message.add_success'));
                return redirect('/staff');
            }else{
             flash()->error(trans('message.add_error'));
               return redirect('/staff/create')->withInput(); 
            }
	    }
    }

    public function edit($id)
    {
	    $page = 'staff';
	    $getCurrencys = $this->getCurrencys();  
	    $staff = DB::table('tbl_staff')->where('s_id',$id)->first(); 
	    $staff_charges = DB::table('tbl_staff_charge')->where('s_id',$id)->orderBy('stc_date','DESC')->get();
	    return view('staff.edit', compact('page','staff','staff_charges','getCurrencys'));
    }

    public function update(Request $request, $id){     
	  	$s_name = $request->s_name;
	    $s_phone = $request->s_phone;
	    $s_line = $request->s_line;
	    $s_fb = $request->s_fb;
	    $s_address = $request->s_address;
	    $s_info = $request->s_info;

	    $s_start = $request->s_start;
	    $s_end = $request->s_end;

	    $rule = [
	    	's_name' => 'required|unique:tbl_staff,s_name,'.$id.',s_id',
            's_phone' => 'required|min:9',
            's_start' => 'required'
	    ];

	    $messages = [
	    	's_name.required' => 'សូមបញ្ចូលឈ្មោះ',
	    	's_name.unique' => 'ឈ្មោះគណនី​ '.$s_name.' មានរួចហើយ។​ សូមបញ្ចូលឈ្មោះថ្មី',
	    	's_phone.required' => 'សូមបញ្ចូលលេខទូរស័ព្ទ',
	    	's_phone.min' => 'សូមបញ្ចូលលេខទូរស័ព្ទ ៩ ឬ ១០ ខ្ទង់',
	    	's_start.required' => 'សូមបញ្ចូលកាលបរិច្ឆេទចាប់ផ្តើម',
	    ];

	    $validator = Validator::make($request->all(), $rule, $messages);

	    if ($validator->fails()) {
	        return redirect('staff/'.$id.'/edit')->withInput($request->all())->withErrors($validator);
	    }else{

   	
	        if($s_end){
	        	
	        	$start_date = new \DateTime($s_start);
	        	$end_date = new \DateTime($s_end);
	        	if($start_date > $end_date){
	        		$validator->errors()->add('s_end', 'ថ្ងៃបញ្ចប់បញ្ចប់មិនត្រឹមត្រូវ');
	        		return redirect('staff/'.$id.'/edit')->withInput($request->all())->withErrors($validator);
	        	}
	        }

    		$check = DB::table('tbl_staff')->where('s_id', $id)->update(
                    [
                        's_name' => $s_name,
	                    's_phone' => $s_phone,
	                    's_line' => $s_line,
	                    's_fb' => $s_fb,
	                    's_address' => $s_address,
	                    's_info' => $s_info,
	                    's_start' => $s_start,
	                    's_end' => $s_end
                    ]
                );
             
            if($check){
                flash()->success("ទិន្នន័យត្រូវបានកែប្រែ");
                return redirect('staff/'.$id.'/edit');
            }else{
             flash()->error("ទិន្នន័យមិនត្រូវបានកែប្រែ");
                return redirect('staff/'.$id.'/edit')->withInput();
            }
        }
    }

    public function deleteItem(Request $request){
      	$id = $request->id;
      	$check = DB::table('tbl_paper')->where('s_id',$id)->first();
      	if($check){
      		return response(['msg' => 'បុគ្គលិកម្នាក់នេះមិនអាចលុបបានទេព្រោះកំពុងដំណើរការ', 'status' => 'error']); 
      	}else{
      		$check = DB::table('tbl_staff')->where('s_id', $id)->delete();
	        if($check){
	          return response(['msg' => $id, 'status' => 'success']);  
	        }else{
	          return response(['msg' => '', 'status' => 'error']); 
	        }
      	}
      	   
    }

    public function storeCharge(Request $request){
    	$stc_date = $request->stc_date_add;
    	$stc_two_digit_charge = $request->stc_two_digit_charge_add;
    	$stc_three_digit_charge = $request->stc_three_digit_charge_add;
    	$s_id = $request->staff_id;
    	$checkType = $request->checkType;
    	$iddata = $request->iddata;
    	$idDataTable = $request->idDataTable;
    	$currencyText = '';
    	$getCurrencys = $this->getCurrencys();

if($checkType == 'add'){

		$checkDate = StaffCharge::where('stc_date','=',$stc_date)
								->where('s_id','=',$s_id)
								->exists();
		if($checkDate){
			return response(['msg' => "កាលបរិច្ឆេទមិនត្រឹមត្រូវ", 'status' => 'error']); 
		}
		// check id max
    	$id_stc = 1;
	      
        $draft =  DB::table('tbl_staff_charge')->select('stc_id')->orderBy('stc_id', 'DESC')->take(1)->get();
        if ($draft){
            foreach ($draft as $id) {
                    $id_stc = $id->stc_id + 1;
            }
        }

    	 $check = DB::table('tbl_staff_charge')->insert([
    	 					'stc_id' => $id_stc,
	                        'stc_date' => $stc_date,
	                        'stc_two_digit_charge' => $stc_two_digit_charge,
	                        'stc_three_digit_charge' => $stc_three_digit_charge,
	                        's_id' => $s_id
	                        ]
	                    ); 
        if($check){
          $staffCharge = DB::table('tbl_staff_charge')->where('stc_id',$id_stc)->first();

          $msg = '<tr class="staff_charge-'.$staffCharge->stc_id.'">
		             <td>'.$idDataTable.'</td>
		             <td>'.$staffCharge->stc_date.'</td>
		             <td>'.$staffCharge->stc_two_digit_charge.'</td>
		             <td>'.$staffCharge->stc_three_digit_charge.'</td>
		             <td>
		             	<button id="'.$staffCharge->stc_id.'" class="padding-button EditStaffCharge btn btn-xs btn-primary">'.trans('label.edit').'</button>
		             	<button id="'.$staffCharge->stc_id.'" class="padding-button deleteStaffCharge btn btn-xs btn-danger">'.trans('label.delete').'</button>
		             </td>
				</tr> ';
          return response(['msg' => $msg, 'status' => 'success']);  
        }else{
          return response(['msg' => "ការរក្សាទុកកំនែប្រែមិនដំណើរការ", 'status' => 'error']); 
        }
}else{

	$checkDate = StaffCharge::where('stc_date','=',$stc_date)
								->where('s_id','=',$s_id)
								->where('stc_id','<>',$iddata)
								->exists();
	if($checkDate){
		return response(['msg' => "កាលបរិច្ឆេទមិនត្រឹមត្រូវ", 'status' => 'error']); 
	}

	$check = DB::table('tbl_staff_charge')->where('stc_id',$iddata)->update([
	                        'stc_date' => $stc_date,
	                        'stc_two_digit_charge' => $stc_two_digit_charge,
	                        'stc_three_digit_charge' => $stc_three_digit_charge,
	                        ]
	                    ); 
    if($check){
    	$staffCharge = DB::table('tbl_staff_charge')->where('stc_id',$iddata)->first();
      	$msg = '<td>'.$idDataTable.'</td>
	             <td>'.$staffCharge->stc_date.'</td>
	             <td>'.$staffCharge->stc_two_digit_charge.'</td>
	             <td>'.$staffCharge->stc_three_digit_charge.'</td>
	             <td>
	             	<button id="'.$staffCharge->stc_id.'" class="padding-button EditStaffCharge btn btn-xs btn-primary">'.trans('label.edit').'</button>
	             	<button id="'.$staffCharge->stc_id.'" class="padding-button deleteStaffCharge btn btn-xs btn-danger">'.trans('label.delete').'</button>
	             </td>';
      return response(['msg' => $msg, 'status' => 'updatesuccess']);  
    }else{
      return response(['msg' => "ទិន្នន័យមិនបានកែប្រែ", 'status' => 'error']); 
    }
}

    }
    public function getCharge(Request $request){
    	$id = $request->id;
    	$staffCharge = DB::table('tbl_staff_charge')->where('stc_id',$id)->first();
    	return response(['msg' => $staffCharge, 'status' => 'success']);
    }

    public function deleteStaffCharge(Request $request){
      	$id = $request->id;
      	$checkStcItem = StaffCharge::where('stc_id','=',$id)->first();
      	if($checkStcItem){

      		$check = DB::table('tbl_paper')
		      		->where('s_id','=',$checkStcItem->s_id)
		      		->whereDate('p_date','>',$checkStcItem->stc_date)
		      		->first();

	      	if($check){
	      		return response(['msg' => 'លេខរៀងមួយនេះមិនអាចលុបបានទេ ព្រោះវាកំពុងដំណើរការ', 'status' => 'error']); 
	      	}else{
	      		$check = DB::table('tbl_staff_charge')->where('stc_id', $id)->delete();
		        if($check){
		          return response(['msg' => $id, 'status' => 'success']);  
		        }else{
		          return response(['msg' => '', 'status' => 'error']); 
		        } 
	      	}

      	}else{
      		return response(['msg' => 'លេខរៀងមួយនេះមិនអាចលុបបានទេ', 'status' => 'error']); 
      	} 
    }

    private function getCurrencys(){
      $result = DB::table('tbl_parameter_type')
              ->where('tbl_parameter_type.pat_key','=','currency')
              ->join('tbl_parameter_value','tbl_parameter_type.pat_id','=','tbl_parameter_value.pat_id')
              ->pluck('pav_value','pav_id')->all();
      return $result;
  	}


}
