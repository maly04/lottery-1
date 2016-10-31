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

use App\Model\Report;

class ReportController extends Controller
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
        $page = 'report';

        $staff = DB::table('tbl_staff')
            ->select('tbl_staff.s_id','tbl_staff.s_name')
            ->join('tbl_staff_charge','tbl_staff.s_id','tbl_staff_charge.s_id')
            ->orderBy('tbl_staff.s_id', 'ASC')
            ->groupBy('tbl_staff.s_id')
            ->pluck('s_name','s_id')
            ->all();
        $pages = DB::table('tbl_paper')
            ->select('tbl_paper.p_number')
            ->groupBy('tbl_paper.p_number')
            ->orderBy('tbl_paper.p_number', 'ASC')
            ->pluck('p_number','p_number')
            ->all();

        $sheets = DB::table('tbl_parameter_type')
            ->select('tbl_parameter_type.pat_id','tbl_parameter_value.pav_id','tbl_parameter_value.pav_value')
            ->join('tbl_parameter_value', 'tbl_parameter_type.pat_id', '=', 'tbl_parameter_value.pat_id')
            ->where('tbl_parameter_type.pat_key', '=','sheet')
            ->orderBy('tbl_parameter_value.pav_id', 'ASC')
            ->pluck('pav_value','pav_id')
            ->all();
        return view('report.index', compact('page','sheets','staff','pages'));
    }

//    public function filter(Request $request)
//    {
//        $page = 'report';
//        $var_dateStart = $request->dateStart;
//        $var_dateEnd = $request->dateEnd;
//        $var_sheet = $request->sheet;
//        $var_staff = $request->staff;
//        $var_page = $request->page;
//
//        return redirect('report/'.$var_dateStart.'/'.$var_dateEnd.'/'.$var_sheet.'/'.$var_staff.'/'.$var_page);
//    }

    public function filter(Request $request)
    {
        $page = 'report';
        $var_dateStart = $request->dateStart;
        $var_dateEnd = $request->dateEnd;
        $var_sheet = $request->sheet;
        $var_staff = $request->staff;
        $var_page = $request->page;

        $staff = DB::table('tbl_staff')
            ->select('tbl_staff.s_id','tbl_staff.s_name')
            ->join('tbl_staff_charge','tbl_staff.s_id','tbl_staff_charge.s_id')
            ->orderBy('tbl_staff.s_id', 'ASC')
            ->groupBy('tbl_staff.s_id')
            ->pluck('s_name','s_id')
            ->all();
        $pages = DB::table('tbl_paper')
            ->select('tbl_paper.p_number')
            ->groupBy('tbl_paper.p_number')
            ->orderBy('tbl_paper.p_number', 'ASC')
            ->pluck('p_number','p_number')
            ->all();

        $sheets = DB::table('tbl_parameter_type')
            ->select('tbl_parameter_type.pat_id','tbl_parameter_value.pav_id','tbl_parameter_value.pav_value')
            ->join('tbl_parameter_value', 'tbl_parameter_type.pat_id', '=', 'tbl_parameter_value.pat_id')
            ->where('tbl_parameter_type.pat_key', '=','sheet')
            ->orderBy('tbl_parameter_value.pav_id', 'ASC')
            ->pluck('pav_value','pav_id')
            ->all();

        $conditions = "";

        if($var_sheet){
            $conditions .= " tbl_paper.p_time = '$var_sheet' AND ";
        }
        if($var_staff){
            $conditions .= " tbl_paper.s_id = '$var_staff' AND ";
        }
        if($var_page){
            $conditions .= " tbl_paper.p_number = '$var_page' AND ";
        }
        if($request->dateStart!="" && $request->dateEnd!=""){
            $conditions .= " tbl_paper.p_date >= '$var_dateStart' AND tbl_paper.p_date <= '$var_dateEnd' AND ";
        }elseif($request->dateStart!="" && $request->dateEnd==""){
            $conditions .= " tbl_paper.p_date = '$var_dateStart' AND ";
        }

        $conditions = substr($conditions, 0, -4);

        if($conditions){
            $report = DB::table('tbl_paper')
            ->join('tbl_row','tbl_paper.p_id','=','tbl_row.p_id')
            ->leftjoin('tbl_staff','tbl_paper.s_id','=','tbl_staff.s_id')
            ->leftjoin('tbl_parameter_value','tbl_paper.p_time','=','tbl_parameter_value.pav_id')
            ->whereRaw($conditions)
            ->orderBy('tbl_paper.p_date')
            ->get();
        }else{
            $report = DB::table('tbl_paper')
            ->join('tbl_row','tbl_paper.p_id','=','tbl_row.p_id')
            ->leftjoin('tbl_staff','tbl_paper.s_id','=','tbl_staff.s_id')
            ->leftjoin('tbl_parameter_value','tbl_paper.p_time','=','tbl_parameter_value.pav_id')
            ->orderBy('tbl_paper.p_date')
            ->get();
        }

//        dd($report);


        return view('report.index', compact('page','sheets','staff','pages','var_dateStart','var_dateEnd','var_staff','var_sheet','var_page','report'));
    }

    public function summary_lottery(Request $request)
    {
        $date = $request->date;
        $staff = $request->staff;
        $income_riel = $request->income_riel;
        $income_dollar = $request->income_dollar;
        $expense_riel = $request->expense_riel;
        $expense_dollar = $request->expense_dollar;
        $check = DB::table('tbl_summary_lottery')
            ->where('date',$date)
            ->where('s_id',$staff)
            ->first();
        if($check){
            DB::table('tbl_summary_lottery')
                ->where('date',$date)
                ->where('s_id',$staff)
                ->delete();

            DB::table('tbl_summary_lottery')->insert(
                [
                    'income_dollar' => $income_dollar,
                    'income_riel' => $income_riel,
                    'expense_dollar' => $expense_dollar,
                    'expense_riel' => $expense_riel,
                    'date' => $date,
                    's_id' => $staff
                ]
            );

            return response(['msg' => 'update', 'status' => 'success']);

        }else{
            DB::table('tbl_summary_lottery')->insert(
                [
                    'income_dollar' => $income_dollar,
                    'income_riel' => $income_riel,
                    'expense_dollar' => $expense_dollar,
                    'expense_riel' => $expense_riel,
                    'date' => $date,
                    's_id' => $staff
                ]
            );
            return response(['msg' => 'insert', 'status' => 'success']);
        }



    }









}
