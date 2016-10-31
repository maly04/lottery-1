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

class SaleController extends Controller
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
     	$page = 'sale';
     	$sales = DB::table('tbl_paper')
     					->join('tbl_staff', 'tbl_paper.s_id','=','tbl_staff.s_id')
     					->leftjoin('tbl_user', 'tbl_paper.u_id','=','tbl_user.u_id')
     					->leftjoin('tbl_parameter_value', 'tbl_paper.p_time','=','tbl_parameter_value.pav_id')
     					->orderBy('tbl_paper.p_date','DESC')
     					->orderBy('tbl_paper.p_time','ASC')
     					->orderBy('tbl_paper.p_number','ASC')
     					->get();
     	return view('sale.index', compact('sales','page'));
    }

    public function create(){
    	$page = 'add_sale';

    	$staffs = DB::table('tbl_staff')
    			->where('s_start','<=',date("Y-m-d"))
    			->orderBy('s_name','ASC')
    			->pluck('s_name', 's_id')->all();

    	$times = DB::table('tbl_parameter_value')
    			->join('tbl_parameter_type', 'tbl_parameter_value.pat_id','=','tbl_parameter_type.pat_id')
    			->where('pat_key','sheet')
    			->orderBy('pav_value','ASC')
    			->pluck('pav_value', 'pav_id')->all();
    			// dd($times);
	    return view('sale.create', compact('page','staffs','times'));
    }

    public function store(Request $request)
    {
     	$s_id = $request->s_id;
	    $p_code = $request->p_code;
	    $p_number = $request->p_number;
	    $p_time = $request->p_time;
	    $p_date = $request->p_date;
	    $u_id = Session::get('iduserlot');

	    $check = DB::table('tbl_paper')->where('s_id',$s_id)->where('p_date',$p_date)->where('p_time',$p_time)->where('p_number',$p_number)->first();
	    if($check){
	    	flash()->error("Can't add. Your paper have already please check again");
            return redirect('/sale/create')->withInput(); 
	    }else{
	    	// insert to database for paper
	    	$id_s = 1;
            $draft =  DB::table('tbl_paper')->orderBy('p_id', 'DESC')->take(1)->get();
            if ($draft){
                foreach ($draft as $id) {
                        $id_s = $id->p_id + 1;
                }
            }
            $check = DB::table('tbl_paper')->insert([
            			'p_id'	=>	$id_s,
                        'p_code' => $p_code,
                        'p_number' => $p_number,
                        'p_time' => $p_time,
                        'p_date' => $p_date,
                        's_id' => $s_id,
                        'u_id' => $u_id
                        ]
                    ); 
            if($check){
                flash()->success("Paper success");
                return redirect('/sale/'.$id_s.'/edit');
            }else{
             	flash()->error("Can't add please try again.");
               	return redirect('/stafftransction/create')->withInput(); 
            }
	    }
	      		
    }

    public function update(Request $request, $id)
    {
        $s_id = $request->s_id;
        $p_code = $request->p_code;
        $p_number = $request->p_number;
        $p_time = $request->p_time;
        $p_date = $request->p_date;

        $check = DB::table('tbl_paper')->where('s_id',$s_id)->where('p_date',$p_date)->where('p_time',$p_time)->where('p_number',$p_number)->where('p_id','<>',$id)->first();
        if($check){
            flash()->error("Can't add. Your paper have already please check again");
            return redirect('/sale/'.$id.'/edit')->withInput(); 
        }else{
            // insert to database for paper
           
            $check = DB::table('tbl_paper')->where('p_id',$id)->update([
                        'p_code' => $p_code,
                        'p_number' => $p_number,
                        'p_time' => $p_time,
                        'p_date' => $p_date,
                        's_id' => $s_id
                        ]
                    ); 
            if($check){
                flash()->success("Paper success");
                return redirect('/sale/'.$id.'/edit');
            }else{
                flash()->error("Can't add please try again.");
                return redirect('/stafftransction/'.$id.'/edit')->withInput(); 
            }
        }
                
    }

    public function edit($id)
    {
	    $page = 'sale';  

	    $sale = DB::table('tbl_paper')->where('p_id',$id)->first();
        $rowList = DB::table('tbl_row')->where('p_id',$sale->p_id)->get(); 

        $countRowInPage = DB::table('tbl_row')->where('p_id',$sale->p_id)->where('p_id',$sale->p_id)->count(); 
        // dd($countRowInPage);
	    $staffs = DB::table('tbl_staff')
    			->where('s_start','<=',date("Y-m-d"))
    			->orderBy('s_name','ASC')
    			->pluck('s_name', 's_id')->all();

    	$times = DB::table('tbl_parameter_value')
    			->join('tbl_parameter_type', 'tbl_parameter_value.pat_id','=','tbl_parameter_type.pat_id')
    			->where('pat_key','sheet')
    			->orderBy('pav_value','ASC')
    			->pluck('pav_value', 'pav_id')->all();

        $symbols = DB::table('tbl_parameter_value')
                ->select('pav_id','pav_value')
                ->join('tbl_parameter_type', 'tbl_parameter_value.pat_id','=','tbl_parameter_type.pat_id')
                ->where('pat_key','sym')
                ->get();

        $currencys = DB::table('tbl_parameter_value')
                ->select('pav_id','pav_value')
                ->join('tbl_parameter_type', 'tbl_parameter_value.pat_id','=','tbl_parameter_type.pat_id')
                ->where('pat_key','currency')
                ->get();

        $groups = DB::table('tbl_pos_group')
                ->select('tbl_group.g_id','tbl_group.g_name')
               ->leftjoin('tbl_pos', 'tbl_pos_group.pos_id','=','tbl_pos.pos_id')
               ->leftjoin('tbl_group', 'tbl_pos_group.g_id','=','tbl_group.g_id')
               ->where('tbl_pos.pos_time',$sale->p_time)
               ->groupBy('tbl_pos_group.g_id')
               ->orderBy('tbl_group.g_name','ASC')
               ->get();

        // $numberLotterys = DB::table('tbl_number')
        //        ->join('tbl_row', 'tbl_number.r_id','=','tbl_row.r_id')
        //        ->leftjoin('tbl_parameter_value', 'tbl_number.num_sym','=','tbl_parameter_value.pav_id')
        //        ->leftjoin('tbl_group', 'tbl_number.g_id','=','tbl_group.g_id')
        //        ->where('tbl_row.p_id',$sale->p_id)
        //        ->groupBy('tbl_pos_group.g_id')
        //        ->orderBy('tbl_group.g_name','ASC')
        //        ->get();

	    return view('sale.edit', compact('page','sale','staffs','times','symbols','currencys','groups','rowList','countRowInPage'));
    }

    public function removecolume(Request $request){
        $r_id = $request->colume;
        $p_id = $request->page;
        $checkData = DB::table('tbl_number')->where('r_id',$r_id)->first();
        if($checkData){
            return response(['msg' => 'Your row is have number put', 'status' => 'error']);
        }else{

            $check = DB::table('tbl_row')->where('r_id', $r_id)->delete();
            $totalcolume = DB::table('tbl_row')->where('p_id',$p_id)->count();
            if($check){
                 return response(['msg' => $r_id, 'count_page'=>$totalcolume, 'status' => 'success']);  
            }else{
                return response(['msg' => 'Error', 'status' => 'error']); 
            } 
        }
        
    }

    public function addnewcolume(Request $request){
        $p_id = $request->page_id;
        $p_time = $request->page_time;

        $id_r = 1;
        $draft =  DB::table('tbl_row')->orderBy('r_id', 'DESC')->take(1)->get();
        if ($draft){
            foreach ($draft as $id) {
                    $id_r = $id->r_id + 1;
            }
        }
        $check = DB::table('tbl_row')->insert([
                    'r_id'  =>  $id_r,
                    'p_id' => $p_id
                    ]
                ); 
        if($check){

            $groups = DB::table('tbl_pos_group')
                ->select('tbl_group.g_id','tbl_group.g_name')
               ->leftjoin('tbl_pos', 'tbl_pos_group.pos_id','=','tbl_pos.pos_id')
               ->leftjoin('tbl_group', 'tbl_pos_group.g_id','=','tbl_group.g_id')
               ->where('tbl_pos.pos_time',$p_time)
               ->groupBy('tbl_pos_group.g_id')
               ->orderBy('tbl_group.g_name','ASC')
               ->get();

            $symbols = DB::table('tbl_parameter_value')
                ->select('pav_id','pav_value')
                ->join('tbl_parameter_type', 'tbl_parameter_value.pat_id','=','tbl_parameter_type.pat_id')
                ->where('pat_key','sym')
                ->get();

            $currencys = DB::table('tbl_parameter_value')
                ->select('pav_id','pav_value')
                ->join('tbl_parameter_type', 'tbl_parameter_value.pat_id','=','tbl_parameter_type.pat_id')
                ->where('pat_key','currency')
                ->get();

            $totalcolume = DB::table('tbl_row')->where('p_id',$p_id)->count();

            $colume = '
                    <div class="colume_style" id="Remove_'.$id_r.'">
                        <div class="remove_row_style eventRemoveColume" colume="'.$id_r.'" page="'.$p_id.'">
                            <i class="fa fa-minus-square txt-color-red" aria-hidden="true"></i>
                        </div>
                        <div class="row_main custom_padding smart-form" id="event_add_in_row_'.$id_r.'">
                            <div class="lottery_num pos_style formAddGroup">
                                <select id="pos_id_add" name="pos_id_add" class="formlottery_select eventPostInRow">
                                    <option value="">'.trans('label.pos').'</option>';
                                    foreach ($groups as $group) {
                                        $colume .= '<option value="'.$group->g_id.'">'.$group->g_name.'</option>';
                                    }
            $colume .= '                       
                                </select>
                                <div class="lottery_num main_checkbo">
                                    <span>'.trans('label.new').'</span>
                                    <input type="checkbox" id="need_new_group" name="need_new_group"​ class="check_style">
                                </div>
                                <input type="hidden" id="pos_id_hidden" name="pos_id_hidden" class="required">
                                <input type="hidden" id="pos_id_hidden_old" name="pos_id_hidden_old" class="">
                                <input type="hidden" id="r_id_hidden" name="r_id_hidden" value="'.$id_r.'">
                                <input type="hidden" id="p_id_hidden" name="p_id_hidden" value="'.$p_id.'">
                            </div>
                            <div class="clear"></div>
                            <div class="lottery_num">
                                <input id="num_number_add" class="form-control formlottery threedigitNew num required eventControlnumber" placeholder="'.trans('label.number').'" name="num_number_add" type="text">
                            </div>
                            <div class="lottery_num_select">
                                <select id="sym_id_add" name="sym_id_add" class="formlottery_select eventControlSym">';
                                    foreach ($symbols as $symbol) {
                                        $colume .= '<option value="'.$symbol->pav_id.'">'.$symbol->pav_value.'</option>';
                                    }
             $colume .= '                        
                                </select>
                            </div>
                            <div class="lottery_num">
                                <input id="num_number_end_add" disabled class="form-control formlottery threedigitNew num" placeholder="'.trans('label.number').'" name="num_number_end_add" type="text">
                            </div>
                            <div class="lottery_num main_checkbo">
                                <span>'.trans('label.multiply').'</span>
                                <input type="checkbox" id="num_reverse_add" name="num_reverse_add"​ class="check_style">
                            </div>
                            <div class="lottery_num main_price">
                                <input id="num_amount_add" class="form-control formlottery num required" placeholder="'.trans('label.money').'" name="num_amount_add" type="text">
                            </div>
                            <div class="lottery_num_select customStyleCurrency">
                                <select id="currentcy_add" name="currentcy_add" class="formlottery_select customCurrency">';
                                    foreach ($currencys as $currency) {
                                        $colume .= '<option value="'.$currency->pav_id.'">'.$currency->pav_value.'</option>';
                                    }
             $colume .= '                      
                                </select>
                            </div>
                            <div class="clear"></div>
                            <div class="btnSave">
                                <button type="button" colume="'.$id_r.'" page="'.$p_id.'" id="saveLotteryAdd" name="saveLottery" class="btn btn-xs btn-primary saveLotteryAdd">'.trans('label.save').'</button>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
            ';

          return response(['msg' => $colume, 'count_page'=>$totalcolume, 'status' => 'success']);  
        }else{
          return response(['msg' => '', 'status' => 'error']); 
        } 
    }

    public function addnewnumberlottery(Request $request){
        $g_id = $request->pos_id;
        $checkNewGroup = $request->checkNewGroup;
        $num_number = $request->num_start;
        $num_end_number = $request->num_end;
        $num_sym = $request->sym_id;
        $num_reverse = $request->num_reverse;
        $num_price = $request->num_amount;
        $num_currency = $request->num_currency;
        $r_id = $request->colume_id;
        $page_id = $request->page_id;

        // get field sort
        if($checkNewGroup == 1){
            $num_sort = 1;
            $draft =  DB::table('tbl_number')->select('num_sort')->where('r_id',$r_id)->orderBy('num_sort', 'DESC')->take(1)->get();
            if ($draft){
                foreach ($draft as $id) {
                        $num_sort = $id->num_sort + 1;
                }
            }
        }else{
            $num_sort = 1;
            $draft =  DB::table('tbl_number')->select('num_sort')->where('r_id',$r_id)->orderBy('num_sort', 'DESC')->take(1)->get();
            if ($draft){
                foreach ($draft as $id) {
                        $num_sort = $id->num_sort;
                }
            }
        }
        


        // get id number auto
        $num_id = 1;
        $draft =  DB::table('tbl_number')->select('num_id')->orderBy('num_id', 'DESC')->take(1)->get();
        if ($draft){
            foreach ($draft as $id) {
                    $num_id = $id->num_id + 1;
            }
        }

        // insert to table tbl_number 
        $check = DB::table('tbl_number')->insert([
                    'num_id'  =>  $num_id,
                    'num_number' => $num_number,
                    'num_sym' => $num_sym,
                    'num_reverse' => $num_reverse,
                    'num_end_number' => $num_end_number,
                    'num_price' => $num_price,
                    'num_currency' => $num_currency,
                    'g_id' => $g_id,
                    'r_id' => $r_id,
                    'num_sort' => $num_sort
                ]);
        if($check){  //if insert success

            $numberDisplay = '';  //display number to fromte
            $displayCurrency = '';
            if($num_currency == 2){
                $currencyDisplay = DB::table('tbl_parameter_value')->where('pav_id',2)->first();
                $displayCurrency = $currencyDisplay->pav_value;
            }

            if($checkNewGroup == 1){
                $groupNameDisplay = DB::table('tbl_group')->where('g_id',$g_id)->first();
                $numberDisplay = '<div class="pos_style" id="pos_style_'.$num_sort.'">'.$groupNameDisplay->g_name.'</div>';
            }else{
                $checkGroupDisplay =  DB::table('tbl_number')->select('num_sort')->where('r_id',$r_id)->count();
                if($checkGroupDisplay <= 1 ){
                    $groupNameDisplay = DB::table('tbl_group')->where('g_id',$g_id)->first();
                    $numberDisplay = '<div class="pos_style" id="pos_style_'.$num_sort.'">'.$groupNameDisplay->g_name.'</div>';
                }
            }

            if($num_sym == 7){ //check sym is -
                $numberDisplay .='
                <div class="row_main" id="row_main_'.$num_id.'">
                    <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                        <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                        <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                    </div>
                    <div class="number_lot lot_int">'.$num_number.'</div>';
                    if($num_reverse == 1){
                        $numberDisplay .= '<div class="symbol_lot lot_int">x</div>';
                    }else{
                        $numberDisplay .= '<div class="symbol_lot lot_int">-</div>';
                    }
                    
                $numberDisplay .= '
                    <div class="amount_lot lot_int">'.number_format($num_price).$displayCurrency.'</div>
                    <div class="clear"></div>
                </div>
                '; 
            }else if($num_sym == 8){

                if($num_reverse == 1){
                    $end_number_new = '';
                    if($num_end_number == ''){
                        $end_number_new = substr($num_number, 0, -1).'9';
                    }else{
                        $end_number_new = $num_end_number;
                    }
                    $numberDisplay .='
                    <div class="row_main" id="row_main_'.$num_id.'">
                        <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                            <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                            <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                        </div>
                        <div class="number_lot lot_int">'.$num_number.'</div>
                        <div class="symbol_lot lot_int">x</div>
                        <div class="clear"></div>
                        <div class="display_total_number">'.$this->calculate_number($num_number,$end_number_new,1).'</div>
                        <div class="number_lot lot_int clear_margin">
                            |
                            <div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                            <div class=" lot_int sym_absolube_amount">'.number_format($num_price).$displayCurrency.'</div>
                        </div>
                        <div class="clear"></div>
                        <div class="number_lot lot_int">'.$end_number_new.'</div>
                        <div class="symbol_lot lot_int">x</div>
                        <div class="clear"></div>
                    </div>
                    '; 
                }else{
                    $check = substr($num_number, -1);
                    if($check == '0' && $num_end_number == ''){
                        $numberDisplay .='
                            <div class="row_main" id="row_main_'.$num_id.'">
                                <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                                    <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                                    <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                                </div>
                                <div class="number_lot lot_int">'.$num_number.'</div>
                                <div class="symbol_lot lot_int"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                <div class="amount_lot lot_int">'.number_format($num_price).$displayCurrency.'</div>
                                <div class="clear"></div>
                            </div>
                            ';
                    }else{
                        $end_number_new = '';
                        if($num_end_number == ''){
                            $end_number_new = substr($num_number, 0, -1).'9';
                        }else{
                            $end_number_new = $num_end_number;
                        }
                        $numberDisplay .='
                        <div class="row_main" id="row_main_'.$num_id.'">
                            <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                                <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                                <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                            </div>
                            <div class="number_lot lot_int">'.$num_number.'</div>
                            <div class="clear"></div>
                            <div class="display_total_number">'.$this->calculate_number($num_number,$end_number_new,0).'</div>
                            <div class="number_lot lot_int clear_margin">
                                |
                                <div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                <div class=" lot_int sym_absolube_amount">'.number_format($num_price).$displayCurrency.'</div>
                            </div>
                            <div class="clear"></div>
                            <div class="number_lot lot_int">'.$end_number_new.'</div>
                            <div class="clear"></div>
                        </div>
                        '; 
                    }
                     
                }
                
            }else{
                if($num_reverse == 1){
                    $numberDisplay .='
                        <div class="row_main" id="row_main_'.$num_id.'">
                            <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                                <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                                <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                            </div>
                            <div class="number_lot lot_int">'.$num_number.'</div>
                            <div class="symbol_lot lot_int">x</div>
                            <div class="clear"></div>
                            <div class="number_lot lot_int clear_margin">
                                |
                                <div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                <div class=" lot_int sym_absolube_amount">'.number_format($num_price).$displayCurrency.'</div>
                            </div>
                            <div class="clear"></div>
                            <div class="number_lot lot_int">'.$num_end_number.'</div>
                            <div class="symbol_lot lot_int">x</div>
                            <div class="clear"></div>
                        </div>
                        '; 
                }else{
                    $numberDisplay .='
                        <div class="row_main" id="row_main_'.$num_id.'">
                            <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                                <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                                <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                            </div>
                            <div class="number_lot lot_int">'.$num_number.'</div>
                            <div class="clear"></div>
                            <div class="number_lot lot_int clear_margin">
                                |
                                <div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                <div class=" lot_int sym_absolube_amount">'.number_format($num_price).$displayCurrency.'</div>
                            </div>
                            <div class="clear"></div>
                            <div class="number_lot lot_int">'.$num_end_number.'</div>
                            <div class="clear"></div>
                        </div>
                        '; 
                }
            }

            

            return response(['msg' => $numberDisplay, 'status' => 'success']);  
        }else{
          return response(['msg' => '', 'status' => 'error']); 
        }
    } 

    public function deletenumberlottery(Request $request){
        $p_id = $request->page_id;
        $r_id = $request->colume_id;
        $num_id = $request->number_id;
        
        // get numsort
        $num_sort_list = DB::table('tbl_number')->select('num_sort')->where('num_id',$num_id)->first();
        
        // delete number
        $check = DB::table('tbl_number')->where('num_id',$num_id)->delete();
        if($check){
          // check num sort empty or not
          $checkGroup = DB::table('tbl_number')->where('r_id',$r_id)->where('num_sort',$num_sort_list->num_sort)->first();
          if($checkGroup){
            return response(['msg' => $checkGroup->num_sort, 'status' => 'success']);  
          }else{
            return response(['msg' => '','num_sort' => $num_sort_list->num_sort , 'status' => 'success']);  
          }
          
        }else{
          return response(['msg' => '', 'status' => 'error']); 
        } 
    }

    public function getnumberonly(Request $request){
        $num_id = $request->number_id;
        $check = DB::table('tbl_number')->where('num_id',$num_id)->first();
        if($check){
            return response(['msg' => $check, 'status' => 'success']);  
        }else{
          return response(['msg' => '', 'status' => 'error']); 
        }
    }

    public function updatenumberlottery(Request $request){

        $g_id = $request->pos_id;
        $checkNewGroup = $request->checkNewGroup;
        $num_number = $request->num_start;
        $num_end_number = $request->num_end;
        $num_sym = $request->sym_id;
        $num_reverse = $request->num_reverse;
        $num_price = $request->num_amount;
        $num_currency = $request->num_currency;
        $r_id = $request->colume_id;
        $page_id = $request->page_id;

        $num_id = $request->number_id;



        // insert to table tbl_number 
        $check = DB::table('tbl_number')->where('num_id',$num_id)->update([
                    'num_number' => $num_number,
                    'num_sym' => $num_sym,
                    'num_reverse' => $num_reverse,
                    'num_end_number' => $num_end_number,
                    'num_price' => $num_price,
                    'num_currency' => $num_currency
                ]);
        if($check){  //if insert success

            $numberDisplay = '';  //display number to fromte
            $displayCurrency = '';
            if($num_currency == 2){
                $currencyDisplay = DB::table('tbl_parameter_value')->where('pav_id',2)->first();
                $displayCurrency = $currencyDisplay->pav_value;
            }
           
            if($num_sym == 7){ //check sym is -
                $numberDisplay .='
                    <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                        <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                        <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                    </div>
                    <div class="number_lot lot_int">'.$num_number.'</div>';
                    if($num_reverse == 1){
                        $numberDisplay .= '<div class="symbol_lot lot_int">x</div>';
                    }else{
                        $numberDisplay .= '<div class="symbol_lot lot_int">-</div>';
                    }
                    
                $numberDisplay .= '
                    <div class="amount_lot lot_int">'.number_format($num_price).$displayCurrency.'</div>
                    <div class="clear"></div>
                '; 
            }else if($num_sym == 8){

                if($num_reverse == 1){
                    $end_number_new = '';
                    if($num_end_number == ''){
                        $end_number_new = substr($num_number, 0, -1).'9';
                    }else{
                        $end_number_new = $num_end_number;
                    }
                    $numberDisplay .='
                        <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                            <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                            <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                        </div>
                        <div class="number_lot lot_int">'.$num_number.'</div>
                        <div class="symbol_lot lot_int">x</div>
                        <div class="clear"></div>
                        <div class="number_lot lot_int clear_margin">
                            |
                            <div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                            <div class=" lot_int sym_absolube_amount">'.number_format($num_price).$displayCurrency.'</div>
                        </div>
                        <div class="clear"></div>
                        <div class="number_lot lot_int">'.$end_number_new.'</div>
                        <div class="symbol_lot lot_int">x</div>
                        <div class="clear"></div>
                    '; 
                }else{
                    $check = substr($num_number, -1);
                    if($check == '0'){
                        $numberDisplay .='
                                <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                                    <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                                    <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                                </div>
                                <div class="number_lot lot_int">'.$num_number.'</div>
                                <div class="symbol_lot lot_int"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                <div class="amount_lot lot_int">'.number_format($num_price).$displayCurrency.'</div>
                                <div class="clear"></div>
                            ';
                    }else{
                        $end_number_new = '';
                        if($num_end_number == ''){
                            $end_number_new = substr($num_number, 0, -1).'9';
                        }else{
                            $end_number_new = $num_end_number;
                        }
                        $numberDisplay .='
                            <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                                <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                                <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                            </div>
                            <div class="number_lot lot_int">'.$num_number.'</div>
                            <div class="clear"></div>
                            <div class="number_lot lot_int clear_margin">
                                |
                                <div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                <div class=" lot_int sym_absolube_amount">'.number_format($num_price).$displayCurrency.'</div>
                            </div>
                            <div class="clear"></div>
                            <div class="number_lot lot_int">'.$end_number_new.'</div>
                            <div class="clear"></div>
                        '; 
                    }
                     
                }
                
            }else{
                if($num_reverse == 1){
                    $numberDisplay .='
                            <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                                <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                                <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                            </div>
                            <div class="number_lot lot_int">'.$num_number.'</div>
                            <div class="symbol_lot lot_int">x</div>
                            <div class="clear"></div>
                            <div class="number_lot lot_int clear_margin">
                                |
                                <div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                <div class=" lot_int sym_absolube_amount">'.number_format($num_price).$displayCurrency.'</div>
                            </div>
                            <div class="clear"></div>
                            <div class="number_lot lot_int">'.$num_end_number.'</div>
                            <div class="symbol_lot lot_int">x</div>
                            <div class="clear"></div>
                        '; 
                }else{
                    $numberDisplay .='
                            <div class="optionNumber" colume="'.$r_id.'" page="'.$page_id.'" number="'.$num_id.'">
                                <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
                                <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
                            </div>
                            <div class="number_lot lot_int">'.$num_number.'</div>
                            <div class="clear"></div>
                            <div class="number_lot lot_int clear_margin">
                                |
                                <div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                <div class=" lot_int sym_absolube_amount">'.number_format($num_price).$displayCurrency.'</div>
                            </div>
                            <div class="clear"></div>
                            <div class="number_lot lot_int">'.$num_end_number.'</div>
                            <div class="clear"></div>
                        '; 
                }
            }

            

            return response(['msg' => $numberDisplay, 'status' => 'success']);  
        }else{
          return response(['msg' => 'មិនមានការកែប្រែ', 'status' => 'error']); 
        }
    }

    public function deleteItem(Request $request){
        $id = $request->id;
        $checkStcItem = DB::table('tbl_row')
                    ->where('p_id','=',$id)
                    ->first();
        if($checkStcItem){
            return response(['msg' => trans('message.not_permission_delete'), 'status' => 'error']); 
            

        }else{
           $check = DB::table('tbl_paper')
                        ->where('p_id','=',$id)->delete();
            if($check){
                return response(['msg' => $id, 'status' => 'success']); 
            }else{
               
                  return response(['msg' => trans('message.fail_delete'), 'status' => 'error']); 
            } 
        }
    }

    public static function calculate_number($num_start,$num_end,$num_reverse) {
        $str = strlen($num_start);
        $total_number = 0;
        if($str == 2){ // if number 2 digit
            if($num_reverse == 1){
                $start = str_split($num_start);
                $end = str_split($num_end);

                if($start[0]==$end[0] && $start[1]!=$end[1]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i++){
                        $result = array_unique( str_split( $i ) );
                        if(count($result)=='1'){
                            $subTotal = $subTotal +  1;
                        }elseif(count($result)=='2'){
                            $subTotal = $subTotal + 2;
                        }
                    }
                    $total_number = $total_number + $subTotal;
                // reverse number 10 -> 90 *
                }elseif($start[0]!=$end[0] && $start[1]==$end[1]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i=$i+10){
                        $result = array_unique( str_split( $i ) );
                        if(count($result)=='1'){
                            $subTotal = $subTotal +  1;
                        }elseif(count($result)=='2'){
                            $subTotal = $subTotal + 2;
                        }
                    }
                    $total_number = $total_number + $subTotal;

                }elseif($start[0]==$start[1] && $end[0]==$end[1]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i = $i + 11){
                        
                        $result = array_unique( str_split( $i ) );
                        if(count($result)=='1'){
                            $subTotal = $subTotal +  1;
                        }elseif(count($result)=='2'){
                            $subTotal = $subTotal + 2;
                        }
                    }
                    $total_number = $total_number + $subTotal;

                }else{

                     for($i=$num_start; $i<=$num_end; $i++){
                        $result = array_unique( str_split( $i ) );
                        if(count($result)=='1'){
                            $subTotal = $subTotal +  1;
                        }elseif(count($result)=='2'){
                            $subTotal = $subTotal + 2;
                        }
                    }
                    $total_number = $total_number + $subTotal;
                }
            }else{

                $start = str_split($num_start);
                $end = str_split($num_end);

                if($start[0]==$end[0] && $start[1]!=$end[1]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i++){
                            $subTotal = $subTotal + 1;
                    }
                    $total_number = $total_number + $subTotal;
                // reverse number 10 -> 90 *
                }elseif($start[0]!=$end[0] && $start[1]==$end[1]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i = $i + 10){
                        
                            $subTotal = $subTotal + 1;
                    }
                    $total_number = $total_number + $subTotal;
                }elseif($start[0]==$start[1] && $end[0]==$end[1]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i = $i + 11){
                        
                            $subTotal = $subTotal + 1;
                    }
                    $total_number = $total_number + $subTotal;
                }else{
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i++){
                            $subTotal = $subTotal + 1;
                    }
                    $total_number = $total_number + $subTotal;
                }
            }
        }else{ // if number 3 digit
            if($num_reverse== 1){
                $start = str_split($num_start);
                $end = str_split($num_end);

                if($start[0]==$end[0] && $start[1]==$end[1] && $start[2]!=$end[2]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i++){
                        $result = array_unique( str_split( $i ) );
                        if(count($result)=='1'){
                            $subTotal = $subTotal +  1;
                        }elseif(count($result)=='2'){
                            $subTotal = $subTotal +  3;
                        }elseif(count($result)=='3'){
                            $subTotal = $subTotal +  6;
                        }
                    }
                    $total_number = $total_number + $subTotal;
                // reverse number 10 -> 90 *
                }elseif($start[0]==$end[0] && $start[1]!=$end[1] && $start[2]==$end[2]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i=$i+10){
                        $result = array_unique( str_split( $i ) );
                        if(count($result)=='1'){
                            $subTotal = $subTotal +  1;
                        }elseif(count($result)=='2'){
                            $subTotal = $subTotal +  3;
                        }elseif(count($result)=='3'){
                            $subTotal = $subTotal +  6;
                        }
                    }
                    $total_number = $total_number + $subTotal;
                }elseif($start[0]!=$end[0] && $start[1]==$end[1] && $start[2]==$end[2]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i=$i+100){
                        $result = array_unique( str_split( $i ) );
                        if(count($result)=='1'){
                            $subTotal = $subTotal +  1;
                        }elseif(count($result)=='2'){
                            $subTotal = $subTotal +  3;
                        }elseif(count($result)=='3'){
                            $subTotal = $subTotal +  6;
                        }
                    }
                    $total_number = $total_number + $subTotal;
                }elseif($start[0]==$start[1] && $start[1]==$start[2] && $end[0]==$end[1] && $end[1]==$end[2]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i = $i + 111){
                        $result = array_unique( str_split( $i ) );
                        if(count($result)=='1'){
                            $subTotal = $subTotal +  1;
                        }elseif(count($result)=='2'){
                            $subTotal = $subTotal +  3;
                        }elseif(count($result)=='3'){
                            $subTotal = $subTotal +  6;
                        }
                    }
                    $total_number = $total_number + $subTotal;

                }else{
                    $subTotal = 0;
                     for($i=$num_start; $i<=$num_end; $i++){
                        $result = array_unique( str_split( $i ) );
                        if(count($result)=='1'){
                            $subTotal = $subTotal +  1;
                        }elseif(count($result)=='2'){
                            $subTotal = $subTotal + 3;
                        }elseif(count($result)=='3'){
                            $subTotal = $subTotal + 6;
                        }
                    }
                    $total_number = $total_number + $subTotal;
                }
            }else{
                $start = str_split($num_start);
                $end = str_split($num_end);

                if($start[0]==$end[0] && $start[1]==$end[1] && $start[2]!=$end[2]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i++){
                        $subTotal = $subTotal +  1;
                    }
                    $total_number = $total_number + $subTotal;
                // reverse number 10 -> 90 *
                }elseif($start[0]==$end[0] && $start[1]!=$end[1] && $start[2]==$end[2]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i=$i+10){
                        $subTotal = $subTotal +  1;
                    }
                    $total_number = $total_number + $subTotal;
                }elseif($start[0]!=$end[0] && $start[1]==$end[1] && $start[2]==$end[2]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i=$i+100){
                        $subTotal = $subTotal +  1;
                    }
                    $total_number = $total_number + $subTotal;
                }elseif($start[0]==$start[1] && $start[1]==$start[2] && $end[0]==$end[1] && $end[1]==$end[2]){
                    $subTotal = 0;
                    for($i=$num_start; $i<=$num_end; $i=$i+111){
                        $subTotal = $subTotal +  1;
                    }
                    $total_number = $total_number + $subTotal;

                }else{
                    $subTotal = 0;
                     for($i=$num_start; $i<=$num_end; $i++){
                        $subTotal = $subTotal +  1;
                    }
                    $total_number = $total_number + $subTotal;
                } 
            }
        }
        return $total_number;
    }

}
