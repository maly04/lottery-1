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

use App\Model\Staff;
use App\Model\StaffTransaction;
use App\Model\SummaryLottery;

class DashboardController extends Controller
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
    public function index(){
    	$page = 'dashboard';
    	// $page = 'profit-loss';
    	$staffid = DB::table("tbl_staff_transction")->get();
    	$arr_staffid = array();
    	foreach ($staffid as $s) {
    		array_push($arr_staffid, $s->s_id);
    	}
    	
    	$staffs = DB::table('tbl_staff')->whereIn('s_id', array_unique($arr_staffid))->orderBy('s_name','ASC')->get();
    	$typeloops = DB::table('tbl_parameter_type')
    			->join('tbl_parameter_value','tbl_parameter_type.pat_id','=','tbl_parameter_value.pat_id')
    			->where('tbl_parameter_type.pat_key','type')
    			->orderBy('tbl_parameter_value.pav_value','DESC')
    			->get();

    	
    				   // ->get();
    				   // dd($gettransction);
    		// new style
    		$main = array();    			   
    		foreach ($staffs as $staff) {
    			$dataname = array();
    			$dataname["sname"] = $staff->s_name;
    			$amount = array();
    			foreach ($typeloops as $type) {
    					$gettransction = DB::table("tbl_staff_transction")
	    				   ->select('tbl_staff.s_name as StaffName', DB::raw('SUM(tbl_staff_transction.st_price) as money'),'tbl_staff_transction.st_type as type','tbl_parameter_value.pav_value','tbl_parameter_value.pav_id')
	    				   ->join('tbl_staff','tbl_staff_transction.s_id','=','tbl_staff.s_id')
	    				   ->leftjoin('tbl_parameter_value','tbl_staff_transction.st_currency','=','tbl_parameter_value.pav_id')
	    				   // ->leftjoin('tbl_parameter_value','tbl_staff_transction.st_type','=','tbl_parameter_value.pav_id')
	    				   ->where('tbl_staff.s_id',$staff->s_id)
	    				   ->where('tbl_staff_transction.st_type',$type->pav_id)
	    				   ->groupBy('tbl_staff_transction.st_type')
	    				   ->groupBy('tbl_staff.s_name')
	    				   ->groupBy('tbl_staff_transction.st_currency')
	    				   // ->groupBy('tbl_staff_transction.st_date_diposit')
	    				   ->orderBy('tbl_staff.s_name','ASC')
	    				   ->orderBy('type','ASC')
	    				   ->orderBy('tbl_parameter_value.pav_value','ASC')->get();
	    				// var_dump($gettransction);
    				   $result = array();
    				   foreach ($gettransction as $value) {    				   		
    				   		if ($value->pav_id == 1) {
    				   			array_push($result, $value->money.' R');
    				   		}
    				   		if ($value->pav_id == 2) {
    				   			array_push($result, $value->money.' $');
    				   		}
    				   		
    				   }

    				   $amount[$type->pav_id] = $result;
    				   
    				   
    			}

    			$dataname['amount'] = $amount;
    			array_push($main, $dataname);
	    		


    		}
    		// dd($main);
			$htmlDisplay = '';
			$total_balanceD = 0;
			$total_balanceR = 0;
			if (sizeof($main)>0) {				
	    		foreach ($main as $key => $value) {
	    			$income = "";
	    			$costs = "";
	    			$htmlDisplay .='<tr>';
	    			$htmlDisplay .='<td class="col_text">'.$value["sname"].'</td>';
	    			$balanceR = 0;
	    			$balanceD = 0;
	    			//3 for income, 4 for expense
	    			if(sizeof($value['amount'][3]) == 2 && sizeof($value['amount'][4]) == 2){    				
	    				$balance = "";						
						$balanceD = $this->getBalance($value['amount'][3][0],$value['amount'][4][0]);
						$balanceR = $this->getBalance($value['amount'][3][1],$value['amount'][4][1]);

						$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
						$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][1]).'</td>';
						$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][0]).'</td>';
						$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][1]).'</td>';
						$htmlDisplay .='<td class="col_text_right">'.number_format($balanceD).' $</td>';
						$htmlDisplay .='<td class="col_text_right">'.number_format($balanceR).' R</td>';


	    			}
	    			else if(sizeof($value['amount'][3]) == 2 && sizeof($value['amount'][4]) == 1){
	    				$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
						$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][1]).'</td>';
	    				if (strpos($value['amount'][4][0], 'R') !== false) {	
	    					
	    					$balanceR  = $this->getBalance($value['amount'][3][1],$value['amount'][4][0]);
	    					$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][0]).'</td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.number_format($balanceR).' R</td>';
	    				}
	    				else{	    					
	    					$balanceD  = $this->getBalance($value['amount'][3][0],$value['amount'][4][0]);
	    					$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][0]).'</td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.number_format($balanceD).'$</td>';
							$htmlDisplay .='<td></td>';
	    				}   				
	    				
	    				
						
						
	    			}
	    			else if(sizeof($value['amount'][3]) == 1 && sizeof($value['amount'][4]) == 2){
	    				if (strpos($value['amount'][3][0], 'R') !== false) {	
	    					
		    				$balanceR  = $this->getBalance($value['amount'][3][0],$value['amount'][4][1]);
		    				$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][0]).'</td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][1]).'</td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.number_format($balanceR).' R</td>';
	    				}
	    				else{
	    					
		    				$balanceD  = $this->getBalance($value['amount'][3][0],$value['amount'][4][0]);
		    				$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][0]).'</td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][1]).'</td>';
							$htmlDisplay .='<td class="col_text_right">'.number_format($balanceD).' $</td>';
							$htmlDisplay .='<td</td>';
	    				}
	    				
	    			}
	    			else if(sizeof($value['amount'][3]) == 1 && sizeof($value['amount'][4]) == 0){
	    				if (strpos($value['amount'][3][0], 'R') !== false) {					   
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
						}
						else{
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
							$htmlDisplay .='<td></td>';	
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
							$htmlDisplay .='<td></td>';					
						}
		    				
							
	    			}
	    			else if(sizeof($value['amount'][3]) == 0 && sizeof($value['amount'][4]) == 1){
	    					$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td></td>';
		    				if (strpos($value['amount'][4][0], 'R') !== false) {
		    					$balanceR = $this->getBalance(0,$value['amount'][4][0]); 
		    					$htmlDisplay .='<td></td>';
								$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][0]).'</td>';
		    					$htmlDisplay .='<td></td>';
								$htmlDisplay .='<td class="col_text_right">'.$balanceR.' R</td>';
		    				}
		    				else{ 
		    					$balanceD =  $this->getBalance(0,$value['amount'][4][0]);    					
								$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][0]).'</td>';
								$htmlDisplay .='<td></td>';
								$htmlDisplay .='<td class="col_text_right">'.$balanceD.' $</td>';
								$htmlDisplay .='<td></td>';
		    				}    					
							
							
	    			}
	    			else if(sizeof($value['amount'][3]) == 1 && sizeof($value['amount'][4]) == 1){
	    				if (strpos($value['amount'][3][0], 'R') !== false && strpos($value['amount'][4][0], 'R') !== false ) {
	    					
		    				$balanceR = $this->getBalance($value['amount'][3][0],$value['amount'][4][0]); 
	    					$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][0]).'</td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.number_format($balanceR).' R</td>';
	    				}
	    				else if (strpos($value['amount'][3][0], '$') !== false && strpos($value['amount'][4][0], '$') !== false ) {
	    					
		    				$balanceD = $this->getBalance($value['amount'][3][0],$value['amount'][4][0]);  
	    					$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][0]).'</td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.number_format($balanceD).' $</td>';
							$htmlDisplay .='<td></td>';
	    				}
	    				else if (strpos($value['amount'][3][0], 'R') !== false && strpos($value['amount'][4][0], '$') !== false){
	    					
		    				$balanceD = $this->getBalance(0,$value['amount'][4][0]);  
	    					$htmlDisplay .='<td class="col_text_right"></td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][4][0]).'</td>';
							$htmlDisplay .='<td></td>';
							$htmlDisplay .='<td class="col_text_right">'.number_format($balanceD).' $</td>';
							$htmlDisplay .='<td class="col_text_right">'.$this->currencyFormat($value['amount'][3][0]).'</td>';
	    				}
	    			}
	    			
	    			$htmlDisplay .='</tr>';
	   
	    			$total_balanceD += $balanceD;
	    			$total_balanceR += $balanceR;
	    		}
	    		$htmlDisplay .= '<tbody><tr><td colspan="5" class="col_text_right">សរុប:</td><td class="col_text_right">'.number_format($total_balanceD).' $</td><td class="col_text_right">'.number_format($total_balanceR).' R</td></tr></tbody>';
			}
			else{
				$htmlDisplay = "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
			}


			// *******************Report Total (Real & Actual Transaction)*******************//
			$sumary_lottery = DB::table('tbl_summary_lottery')
			 				->select('tbl_staff.s_name as sname',DB::raw('SUM(income_dollar) as incomeDollar'),DB::raw('SUM(income_riel) as incomeRiel'),DB::raw('SUM(expense_dollar) as expenseDollar'),DB::raw('SUM( expense_riel ) as expenseRiel'))
			 				->join('tbl_staff','tbl_staff.s_id','=','tbl_summary_lottery.s_id')
			 				->groupBy("tbl_summary_lottery.s_id")
			 				->get();

     	// echo "<pre>";
     	// var_dump($sumary_lottery);
     	// echo "</pre>";

		//START SUMMARY  REAL LOTTERY TRANSACTION
        $summaryLotterys = Staff::select('tbl_staff.s_id','s_name',DB::raw('SUM(income_dollar) as income_dollar, SUM(income_riel) as income_riel, SUM(expense_dollar) as expense_dollar, SUM(expense_riel) as expense_riel'))
        				->leftJoin('tbl_summary_lottery', 'tbl_staff.s_id', '=', 'tbl_summary_lottery.s_id')
						->groupBy('tbl_summary_lottery.s_id')
						->orderBy('tbl_staff.s_id')
        				->get();

        $summaryTransactions = Staff::select('tbl_staff.s_id','s_name','tbl_staff_transction.st_currency as st_currency','tbl_staff_transction.st_type as st_type',DB::raw('SUM(st_price) as st_price'))
	        				->leftJoin('tbl_staff_transction', 'tbl_staff.s_id', '=', 'tbl_staff_transction.s_id')
							->groupBy('tbl_staff.s_id','tbl_staff_transction.st_currency','tbl_staff_transction.st_type')
	        				->get();

	    $tmpSummaryTrans = array();
	    $summaryTrans = array();
	    $summaryDatas = array();
	    $totalSummaryGainsAndLosses_dollar = 0;
	    $totalSummaryGainsAndLosses_riel = 0;

	    if($summaryTransactions->count() > 0){
	    	foreach ($summaryTransactions as $key_summary => $summaryTransaction) {
	    		$tmpSummaryTrans[$summaryTransaction->s_id][$summaryTransaction->s_name][$summaryTransaction->st_type][$summaryTransaction->st_currency] = $summaryTransaction->st_price;
	    	}
	    	if($tmpSummaryTrans){
	    		foreach ($tmpSummaryTrans as $keyTmpSummaryTran => $tmpSummaryTran) {
	    			$income_dollar = 0;
					$income_riel = 0;
					$expense_dollar = 0;
					$expense_riel = 0;
					$summaryTranBalance_dollar = 0;
					$summaryTranBalance_riel = 0;
	    			foreach ($tmpSummaryTran as $keyStaff => $staffs) {
	    				foreach ($staffs as $keyStatement => $statements) {
	    					// 3->Income , 4->Costs
	    					
	    					foreach ($statements as $keyTypeCurrency => $typeCurrency) {
	    						// 1->Real ; 2->Dolla
	    						// echo $keyTypeCurrency.'<br/>';
	    						
	    						if($keyStatement == 3 && $keyTypeCurrency == 1){
	    							$income_riel = $typeCurrency;
	    						}elseif ($keyStatement == 3 && $keyTypeCurrency == 2) {
	    							$income_dollar = $typeCurrency;
	    						}elseif ($keyStatement == 4 && $keyTypeCurrency == 1) {
	    							$expense_riel = $typeCurrency;
	    						}elseif ($keyStatement == 4 && $keyTypeCurrency == 2) {
	    							$expense_dollar = $typeCurrency;
	    						}
	    					}
	    				}
	    			}
	    			// array_push($summaryTrans, ['id'=>$keyTmpSummaryTran,'name'=>$keyStaff,'income_dollar'=>$income_dollar,'income_riel'=>$income_riel,'expense_dollar'=>$expense_dollar,'expense_riel'=>$expense_riel]);
	    			$summaryTranBalance_dollar = $income_dollar - $expense_dollar;
	    			$summaryTranBalance_riel = $income_riel - $expense_riel;
	    			// dd($summaryTranBalance_dollar);
	    			$summaryTrans[$keyTmpSummaryTran] = ['name'=>$keyStaff,'balance_dollar'=>$summaryTranBalance_dollar,'balance_riel'=>$summaryTranBalance_riel];
	    		}
	    		
	    	}
	    }

	    
	    // dd($summaryLotterys);
	    if($summaryLotterys->count() > 0){
	    	foreach ($summaryLotterys as $summaryLottery) {
	    		$balance_dollar = 0;
	    		$balance_riel = 0;
	    		$lotteryBalance_dollar = 0;
	    		$lotteryBalance_riel = 0;
	    		$tranBalance_dollar = 0;
	    		$tranBalance_riel = 0;
	    		if(isset($summaryTrans[$summaryLottery->s_id])){
	    			$tranBalance_dollar = (isset($summaryTrans[$summaryLottery->s_id]['balance_dollar']) ? $summaryTrans[$summaryLottery->s_id]['balance_dollar'] : 0);
	    			$tranBalance_riel = (isset($summaryTrans[$summaryLottery->s_id]['balance_riel']) ? $summaryTrans[$summaryLottery->s_id]['balance_riel'] : 0);
	    			$lotteryBalance_dollar = (($summaryLottery->income_dollar != null) ? $summaryLottery->income_dollar : 0) - (($summaryLottery->expense_dollar != null) ? $summaryLottery->expense_dollar : 0);
	    			$lotteryBalance_riel = ((($summaryLottery->income_riel != null) ? $summaryLottery->income_riel : 0)) - ((($summaryLottery->expense_riel != null) ? $summaryLottery->expense_riel : 0));
	    			$balance_dollar = $lotteryBalance_dollar - $tranBalance_dollar;
	    			$balance_riel = $lotteryBalance_riel - $tranBalance_riel;
	    			$totalSummaryGainsAndLosses_dollar += $balance_dollar;
	    			$totalSummaryGainsAndLosses_riel += $balance_riel;
	    			array_push($summaryDatas, ['user_id'=>$summaryLottery->s_id, 'user_name' => $summaryLottery->s_name, 'lottery_balance_dollar' => number_format($lotteryBalance_dollar), 'lottery_balance_riel' => number_format($lotteryBalance_riel), 'tran_balance_dollar' => number_format($tranBalance_dollar), 'tran_balance_riel' => number_format($tranBalance_riel), 'balance_dollar' => number_format($balance_dollar), 'balance_riel' => number_format($balance_riel)]);
	    		}
	    	}
	    	// dd($summaryDatas);
	    }

		//END SUMMARY  REAL LOTTERY TRANSACTION

	    $tr = $htmlDisplay;
	    $sumary_lottery = $sumary_lottery;

	    $totalGainsAndLosses_dollar = number_format($totalSummaryGainsAndLosses_dollar);
	    $totalGainsAndLosses_riel = number_format($totalSummaryGainsAndLosses_dollar);

	    // echo number_format($totalSummaryGainsAndLosses_riel);
	    // dd(number_format(-5026000));

    	return view("dashboard.index", compact('page','summaryDatas','tr','sumary_lottery','totalGainsAndLosses_dollar','totalGainsAndLosses_riel'));
    	// return view("dashboard.index", compact('page'));
    }
    public function getBalance($income,$expense){
    	$result = 0;
    	$balanceIncome = explode(" ", $income);
		$balanceExpence = explode(" ", $expense);
		$result = $balanceIncome[0] - $balanceExpence[0];
		return $result;
    }
    public function replaceCurency($str){
    	$str = str_replace('R', '', $str);
    	$getstr = str_replace('$', '', $str);
    	return $getstr;

    }
    public function currencyFormat($val){
    	 $val = explode(" ", $val);
    	$getval = number_format($val[0]).' '.$val[1];
    	return $getval;
    }

    public function editlogout(){

		if(Session::has('iduserlot')){
		   Session::forget('iduserlot');
		   Session::forget('usernameLot');
		   Session::forget('nameLot');
		   Session::forget('phoneLot');
		}

		return redirect('/login');
	}
}
