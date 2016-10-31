<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Flash;
use Redirect;
use Hash;
use Session;

use App\Model\Result;
use App\Http\Requests;


class ResultController extends Controller
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
        $page = 'result';
        $results = DB::table('tbl_result')
            ->distinct()
            ->select('tbl_parameter_value.pav_value','tbl_result.re_date','tbl_parameter_value.pav_id')
            ->leftjoin('tbl_pos', 'tbl_result.pos_id', '=', 'tbl_pos.pos_id')
            ->leftjoin('tbl_parameter_value', 'tbl_pos.pos_time', '=', 'tbl_parameter_value.pav_id')
            ->orderBy('tbl_result.re_date','DESC')
            ->get();
        return view('result.index', compact('page','results'));
    }

    public function resultpage(Request $request)
    {
        $page = 'add_result';
        $var_sheet = $request->sheet;
        $var_date = $request->date;
        $sheets = DB::table('tbl_parameter_type')
            ->select('tbl_parameter_type.pat_id','tbl_parameter_value.pav_id','tbl_parameter_value.pav_value')
            ->join('tbl_parameter_value', 'tbl_parameter_type.pat_id', '=', 'tbl_parameter_value.pat_id')
            ->where('tbl_parameter_type.pat_key', '=','sheet')
            ->orderBy('tbl_parameter_value.pav_id', 'ASC')
            ->pluck('pav_value','pav_id')
            ->all();
        $poss = DB::table('tbl_pos')
            ->where('pos_time','=',$var_sheet)
            ->orderBy('tbl_pos.pos_order','ASC')->get();
        return view('result.create', compact('page','sheets','poss','var_sheet','var_date'));
    }
    public function filter(Request $request){
        $sheet = $request->sheet;
        $date = $request->date;

        return redirect('result/'.$date.'/'.$sheet);
    }

    public function create()
    {
        $page = 'add_result';
        $sheets = DB::table('tbl_parameter_type')
            ->select('tbl_parameter_type.pat_id','tbl_parameter_value.pav_id','tbl_parameter_value.pav_value'
            )
            ->join('tbl_parameter_value', 'tbl_parameter_type.pat_id', '=', 'tbl_parameter_value.pat_id')
            ->where('tbl_parameter_type.pat_key', '=','sheet')
            ->orderBy('tbl_parameter_value.pav_id', 'ASC')
            ->pluck('pav_value','pav_id')
            ->all();
        return view('result.create', compact('page','sheets'));
    }

    public function store(Request $request)
    {
        $post_id2 = $request->post_id2;
        $post_id3 = $request->post_id3;
        $two_digit = $request->two_digit;
        $three_digit = $request->three_digit;
        $var_sheet = $request->sheet_filter;
        $var_date = $request->date_filter;

        foreach($two_digit as $key => $val){
            if($val){
                $result = new Result;
                $result->re_date = $var_date;
                $result->re_num_result = $val;
                $result->pos_id = $post_id2[$key];
                $check = $result->save();
            }
        }
        foreach($three_digit as $key => $val){
            if($val){
                $result2 = new Result;
                $result2->re_date = $var_date;
                $result2->re_num_result = $val;
                $result2->pos_id = $post_id3[$key];
                $check2 = $result2->save();
            }
        }
        return redirect('result');
    }

    public function filterUpdate(Request $request){
        $sheet = $request->sheet;
        $date = $request->date;
        return redirect('result/modify/'.$date.'/'.$sheet);
    }

    public function modify(Request $request)
    {
        $page = 'result';
        $var_sheet = $request->sheet;
        $var_date = $request->date;
//      select sheet Afternoon or Evening
        $sheets = DB::table('tbl_parameter_type')
            ->select('tbl_parameter_type.pat_id','tbl_parameter_value.pav_id','tbl_parameter_value.pav_value')
            ->join('tbl_parameter_value', 'tbl_parameter_type.pat_id', '=', 'tbl_parameter_value.pat_id')
            ->where('tbl_parameter_type.pat_key', '=','sheet')
            ->orderBy('tbl_parameter_value.pav_id', 'ASC')
            ->pluck('pav_value','pav_id')
            ->all();

//      select all pos A,B or C ...
        $poss = DB::table('tbl_pos')
            ->where('pos_time','=',$var_sheet)
            ->orderBy('tbl_pos.pos_order','ASC')->get();

        $mainResult = [];

        foreach($poss as $pos) {
//      select all result by date and sheet
            $main = array();
            array_push($main, $pos->pos_id);
            array_push($main, $pos->pos_name);
            $results = DB::table('tbl_result')
                ->select('tbl_pos.pos_name', 'tbl_pos.pos_id', 'tbl_pos.pos_two_digit', 'tbl_pos.pos_three_digit', 'tbl_result.re_id', 'tbl_result.re_num_result', 'tbl_result.pos_id', 'tbl_result.re_date')
                ->leftjoin('tbl_pos', 'tbl_result.pos_id', '=', 'tbl_pos.pos_id')
                ->leftjoin('tbl_parameter_value', 'tbl_pos.pos_time', '=', 'tbl_parameter_value.pav_id')
                ->where('tbl_result.re_date', '=', $var_date)
                ->where('tbl_parameter_value.pav_id', '=', $var_sheet)
                ->where('tbl_pos.pos_id','=',$pos->pos_id)
                ->orderBy('tbl_pos.pos_order','ASC')
                ->get();

            $resulttwo = array();
            $resultthree = array();
            foreach($results as $val){
                if(strlen($val->re_num_result)==2){
                    $resulttwo[$val->re_id] = $val->re_num_result;
                }else{
                    $resultthree[$val->re_id] = $val->re_num_result;
                }

            }
            array_push($main, $resulttwo,$resultthree);
            array_push($mainResult, $main);
        }
        return view('result.modify', compact('page','results','poss','sheets','var_date','var_sheet','mainResult'));
    }

    public function remove(Request $request)
    {
        $page = 'result';
        $var_sheet = $request->sheet;
        $var_date = $request->date;

        $check = DB::table('tbl_result')
            ->select('tbl_pos.pos_name','tbl_pos.pos_id','tbl_pos.pos_two_digit','tbl_pos.pos_three_digit','tbl_result.re_id','tbl_result.re_num_result','tbl_result.pos_id','tbl_result.re_date')
            ->leftjoin('tbl_pos', 'tbl_result.pos_id', '=', 'tbl_pos.pos_id')
            ->leftjoin('tbl_parameter_value', 'tbl_pos.pos_time', '=', 'tbl_parameter_value.pav_id')
            ->where('tbl_result.re_date','=',$var_date)
            ->where('tbl_parameter_value.pav_id','=',$var_sheet)
            ->orderBy('tbl_pos.pos_order','ASC')
            ->delete();
        if($check){
            return redirect('result');
        }else{
            return redirect('result');
        }


    }

    public function updateResult(Request $request)
    {
        $post_id2 = $request->post_id2;
        $post_id3 = $request->post_id3;
        $two_digit = $request->two_digit;
        $three_digit = $request->three_digit;
        $var_sheet = $request->sheet_filter;
        $var_date = $request->date_filter;

        $check = DB::table('tbl_result')
            ->select('tbl_pos.pos_name','tbl_pos.pos_id','tbl_pos.pos_two_digit','tbl_pos.pos_three_digit','tbl_result.re_id','tbl_result.re_num_result','tbl_result.pos_id','tbl_result.re_date')
            ->leftjoin('tbl_pos', 'tbl_result.pos_id', '=', 'tbl_pos.pos_id')
            ->leftjoin('tbl_parameter_value', 'tbl_pos.pos_time', '=', 'tbl_parameter_value.pav_id')
            ->where('tbl_result.re_date','=',$var_date)
            ->where('tbl_parameter_value.pav_id','=',$var_sheet)
            ->orderBy('tbl_pos.pos_order','ASC')
            ->delete();
        if($check){
            foreach($two_digit as $key => $val){
                if($val){
                    $result = new Result;
                    $result->re_date = $var_date;
                    $result->re_num_result = $val;
                    $result->pos_id = $post_id2[$key];
                    $check = $result->save();
                }
            }
            foreach($three_digit as $key => $val){
                if($val){
                    $result2 = new Result;
                    $result2->re_date = $var_date;
                    $result2->re_num_result = $val;
                    $result2->pos_id = $post_id3[$key];
                    $check2 = $result2->save();
                }
            }
            return redirect('result');
        }else{
            return redirect('result');
        }

    }


    public function view(Request $request)
    {
        $page = 'result';
        $var_sheet = $request->sheet;
        $var_date = $request->date;
//      select sheet Afternoon or Evening
        $sheets = DB::table('tbl_parameter_type')
            ->select('tbl_parameter_type.pat_id','tbl_parameter_value.pav_id','tbl_parameter_value.pav_value')
            ->join('tbl_parameter_value', 'tbl_parameter_type.pat_id', '=', 'tbl_parameter_value.pat_id')
            ->where('tbl_parameter_type.pat_key', '=','sheet')
            ->orderBy('tbl_parameter_value.pav_id', 'ASC')
            ->pluck('pav_value','pav_id')
            ->all();

//      select all pos A,B or C ...
        $poss = DB::table('tbl_pos')
            ->where('pos_time','=',$var_sheet)
            ->orderBy('tbl_pos.pos_order','ASC')->get();

        $mainResult = [];

        foreach($poss as $pos) {
//      select all result by date and sheet
            $main = array();
            array_push($main, $pos->pos_id);
            array_push($main, $pos->pos_name);
            $results = DB::table('tbl_result')
                ->select('tbl_pos.pos_name', 'tbl_pos.pos_id', 'tbl_pos.pos_two_digit', 'tbl_pos.pos_three_digit', 'tbl_result.re_id', 'tbl_result.re_num_result', 'tbl_result.pos_id', 'tbl_result.re_date')
                ->leftjoin('tbl_pos', 'tbl_result.pos_id', '=', 'tbl_pos.pos_id')
                ->leftjoin('tbl_parameter_value', 'tbl_pos.pos_time', '=', 'tbl_parameter_value.pav_id')
                ->where('tbl_result.re_date', '=', $var_date)
                ->where('tbl_parameter_value.pav_id', '=', $var_sheet)
                ->where('tbl_pos.pos_id','=',$pos->pos_id)
                ->orderBy('tbl_pos.pos_order','ASC')
                ->get();

            $resulttwo = array();
            $resultthree = array();
            foreach($results as $val){
                if(strlen($val->re_num_result)==2){
                    $resulttwo[$val->re_id] = $val->re_num_result;
                }else{
                    $resultthree[$val->re_id] = $val->re_num_result;
                }

            }
            array_push($main, $resulttwo,$resultthree);
            array_push($mainResult, $main);
        }

        return view('result.view', compact('page','results','poss','sheets','var_date','var_sheet','mainResult'));
    }

    public function filterView(Request $request){
        $sheet = $request->sheet;
        $date = $request->date;
        return redirect('result/view/'.$date.'/'.$sheet);
    }
}
