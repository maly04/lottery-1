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
use App\Model\Pos;
use App\Model\Group;
use App\Model\PosGroup;

class PosGroupController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $page = 'pos_group';
        $getGroups = Group::with('poss')->get();
        $posGroups = array();

        foreach ($getGroups as $key => $getGroup) {
            $posNames = array();
            $first = true;
            foreach ($getGroup->poss as $key_pos => $pos) {
                $posTimeName = $this->getTimeName($pos->pos_time);
                $posNames[$posTimeName][$pos->pos_time][] = $pos->pos_name;
            }
            // dd($posNames);

            if(!empty($posNames)){
                foreach ($posNames as $key_posName => $posName) {
                    foreach ($posName as $key_sheet => $sheet) {
                        $newGroup = array();
                        $newGroup['g_id'] = $getGroup->g_id;
                        $newGroup['g_name'] = $getGroup->g_name;
                        $newGroup['g_time'] = $key_sheet;
                        $newGroup['list_pos'] = rtrim(implode(',', $sheet), ',');
                        $newGroup['g_time_name'] = $key_posName;
                        $newGroup['g_info'] = $getGroup->g_info;
                        array_push($posGroups,  $newGroup);
                    }
                }
                // dd($posGroups);
            }
        }

        return view('pos_group.index', compact('page','posGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page = 'add_pos_group';
        $listGroup = Group::pluck('g_name','g_id')->all();
        $times = $this->getTime();
        $firstTime = array_keys($times)[0];
        $listPoss = Pos::where('pos_time','=',$firstTime)->pluck('pos_name','pos_id')->all();

        return view('pos_group.create', compact('page','listPoss','listGroup','times'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $g_id = $request->g_id;
        $pos_ids = $request->pos_id;
        $sheet_id = $request->pos_time;

        $rule = [
            'g_id' => 'required|unique:tbl_pos_group,g_id,null,pg_id,sheet_id,'.$sheet_id,
            'pos_id' => 'required'
        ];

        $messages = [
            'g_id.required' => trans('validation.custom.group.name.required'),
            'g_id.unique' => trans('message.pos_group_exist'),
            'pos_id.required' => trans('validation.custom.pos.name.check')
        ];

        $validator = Validator::make($request->all(), $rule, $messages);

        if ($validator->fails()) {
            return redirect('posgroup/create')->withInput($request->all())->withErrors($validator);
        }else{

            $datas = array();
            foreach ($pos_ids as $key_pos => $pos_id) {
                array_push($datas , ['g_id'=>$g_id,'pos_id'=>$pos_id,'sheet_id'=>$sheet_id]);
            }

            $checkInsert = PosGroup::insert($datas);
            if($checkInsert){
                flash()->success(trans('message.add_success'));
                return redirect('posgroup');
            }else{
                flash()->error(trans('message.add_error'));
                return redirect('posgroup'); 
            }
            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $sheet)
    {
        $page = 'pos_group';
        $listGroup = Group::pluck('g_name','g_id')->all();
        $posGoup = Group::with('poss')->find($id);
        $timeID = $sheet;
        if($posGoup){
            $posCheckeds = $posGoup->poss->where('pos_time','=',$sheet)->pluck('pos_name','pos_id');
            if($posCheckeds->count() > 0){
                $times = $this->getTime();
                $listPoss = Pos::where('pos_time','=',$timeID)->pluck('pos_name','pos_id')->all();
                return view('pos_group.edit', compact('page','listPoss','listGroup','posGoup','posCheckeds','times','timeID'));
            }
            return redirect('posgroup');
        }else{
            return redirect('posgroup');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $g_id = $request->g_id;
        $pos_ids = $request->pos_id;
        $timeID = $request->pos_time;

        if($g_id == $id){
            $rule = [
                'g_id' => 'required',
                'pos_id' => 'required'
            ];
        }else{
            $rule = [
                'g_id' => 'required|unique:tbl_pos_group,g_id',
                'pos_id' => 'required'
            ];
        }

        $messages = [
            'g_id.required' => trans('validation.custom.group.name.required'),
            'g_id.unique' => trans('message.pos_group_exist'),
            'pos_id.required' => trans('validation.custom.pos.name.check')
        ];

        $validator = Validator::make($request->all(), $rule, $messages);

        if ($validator->fails()) {
            return redirect('posgroup/'.$id.'/edit/'.$timeID)->withInput($request->all())->withErrors($validator);
        }else{

            $deleteCheck = PosGroup::where('g_id','=',$id)->where('sheet_id','=',$timeID)->delete();
            if($deleteCheck){

                $datas = array();
                foreach ($pos_ids as $key_pos => $pos_id) {
                    array_push($datas , ['g_id'=>$g_id,'pos_id'=>$pos_id,'sheet_id'=>$timeID]);
                }
                
                $checkUpdate = PosGroup::insert($datas);
                if($checkUpdate){
                    flash()->success(trans('message.update_success'));
                    return redirect('posgroup/'.$id.'/edit/'.$timeID);
                }else{
                    flash()->error(trans('message.update_error'));
                    return redirect('posgroup/'.$id.'/edit/'.$timeID);
                }

            }else{
                flash()->error(trans('message.update_error'));
                return redirect('posgroup/'.$id.'/edit/'.$timeID);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteItem(Request $request){
        $id = $request->id;
        $checkGroup = Group::find($id);
        $pos_time = $request->pos_time;
        
        if($checkGroup){
            $checkPermission = DB::table('tbl_number')->where('g_id', $id)->first();
            if($checkPermission){
                return response(['msg' => trans('message.pos_group_error_delete') , 'status' => 'error']);
            }else{
                $check = PosGroup::where('g_id','=',$id)->where('sheet_id','=',$pos_time)->delete();
                if($check){
                    return response(['msg' => $check, 'status' => 'success']);
                }else{
                    return response(['msg' => trans('message.delete_error'), 'status' => 'error']);
                }
                
                 
            }
        }else{
            return response(['msg' => trans('message.delete_error') , 'status' => 'error']);
        }
    }
    public function requestPos(Request $request){
        $timeID = $request->pos_time;
        $g_id = $request->g_id;
        $message = '';
        if($g_id != ''){
            $posGoup = Group::with('poss')->find($g_id);
            $posCheckeds = $posGoup->poss->pluck('pos_name','pos_id');
        }else{
            $posCheckeds = [];
        }
        $listPoss = Pos::where('pos_time','=',$timeID)->pluck('pos_name','pos_id')->all();
        if($listPoss){
            $message .= '<div class="row">';
            $q=0;
            foreach($listPoss as $keyPos => $listPos){
            $q++;
                if($q%3 != 0){
                    $message .= '<div class="col col-4"><label class="checkbox"><input type="checkbox" name="pos_id[]" value="'.$keyPos.'" '.((isset($posCheckeds[$keyPos]) == true) ? "checked" : "").'><i></i>'.$listPos.'</label></div>';
                }else{
                    $message .='<div class="col col-4"><label class="checkbox"><input type="checkbox" name="pos_id[]" value="'.$keyPos.'" '.((isset($posCheckeds[$keyPos]) == true) ? "checked" : "").'><i></i>'.$listPos.'</label></div></div><div class="row">';
                }
            }
            return response(['msg' => $message , 'status' => 'success']);
        }else{
            return response(['msg' => $message , 'status' => 'error']);
        }
    }

    private function getTime(){
        $result = DB::table('tbl_parameter_type')
                        ->where('tbl_parameter_type.pat_key','=','sheet')
                        ->join('tbl_parameter_value','tbl_parameter_type.pat_id','=','tbl_parameter_value.pat_id')
                        ->pluck('pav_value','pav_id')->all();
        return $result;
    }

    private function getTimeName($timeID){
        $result = '';
        $check = DB::table('tbl_parameter_value')->where('pav_id','=',$timeID)->first();
        if($check){
            $result = $check->pav_value;
        }
        return $result;
    }
}
