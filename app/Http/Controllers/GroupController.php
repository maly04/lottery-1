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

use App\Model\Group;

class GroupController extends Controller
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
        $page = 'group';
        $groups = Group::get();
        return view('group.index', compact('page','groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = 'add_group';
        return view('group.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $g_name = $request->g_name;
        $g_info = $request->g_info;
        $rule = [
            'g_name' => 'required|unique:tbl_group,g_name',
            'g_info' => 'required',
        ];

        $messages = [
            'g_name.required' => trans('validation.custom.group.name.required'),
            'g_name.unique' => 'ក្រុមឈ្មោះ '.$g_name.' មានរួចហើយ',
            'g_info.required' => trans('validation.custom.group.info.required'),
        ];

        $validator = Validator::make($request->all(), $rule, $messages);

        if ($validator->fails()) {
            return redirect('group/create')->withInput($request->all())->withErrors($validator);
        }else{
            $group = new Group();
            $group->g_name = $g_name;
            $group->g_info = $g_info;
            $group->save();
            if($group){
                flash()->success(trans('message.add_success'));
                return redirect('/group');
            }else{
                flash()->error(trans('message.add_error'));
               return redirect('/group/create')->withInput(); 
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
    public function edit($id)
    {
        $page = 'group';  
        $group = Group::where('g_id','=',$id)->get()->first();
        return view('group.edit', compact('page','group'));
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
        $g_name = $request->g_name;
        $g_info = $request->g_info;
        $rule = [
            'g_name' => 'required|unique:tbl_group,g_name,'.$id.',g_id',
            'g_info' => 'required',
        ];

        $messages = [
            'g_name.required' => trans('validation.custom.group.name.required'),
            'g_name.unique' => 'ក្រុមឈ្មោះ '.$g_name.' មានរួចហើយ',
            'g_info.required' => trans('validation.custom.group.info.required'),
        ];

        $validator = Validator::make($request->all(), $rule, $messages);

        if ($validator->fails()) {
            return redirect('group/'.$id.'/edit')->withInput($request->all())->withErrors($validator);
        }else{
            $check = Group::find($id);
            if($check){
                $check->g_name = $g_name;
                $check->g_info = $g_info;
                $checkUpdate = $check->save();
                if($checkUpdate){
                    flash()->success(trans('message.update_success'));
                    return redirect('group/'.$id.'/edit');
                }else{
                    flash()->error(trans('message.update_error'));
                    return redirect('group/'.$id.'/edit')->withInput(); 
                }
            }else{
                flash()->error(trans('message.update_error'));
                return redirect('group/'.$id.'/edit')->withInput(); 
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
        $checkItem = Group::find($id);

        if($checkItem){

            $check = DB::table('tbl_pos_group')
                        ->where('g_id','=',$id)->first();
            if($check){
                return response(['msg' => trans('message.not_permission_delete'), 'status' => 'error']); 
            }else{
                $checkDelete = $checkItem->delete();

                if($checkDelete){
                  return response(['msg' => $id, 'status' => 'success']);  
                }else{
                  return response(['msg' => trans('message.fail_delete'), 'status' => 'error']); 
                }

            }

        }else{
            return response(['msg' => trans('message.fail_delete'), 'status' => 'error']); 
        }
    }

}
