<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web']], function () {

	// route for ajax
	Route::get('addnewcolume', 'SaleController@addnewcolume');
	Route::get('removecolume', 'SaleController@removecolume');
	Route::get('addnewnumberlottery', 'SaleController@addnewnumberlottery');
	Route::get('deletenumberlottery', 'SaleController@deletenumberlottery');
	Route::get('getnumberonly', 'SaleController@getnumberonly');
	Route::get('updatenumberlottery', 'SaleController@updatenumberlottery');

	
	
	
	

	Route::get('/', 'LoginController@index');
	Route::get('/logout', 'DashboardController@editlogout');
	Route::resource('login', 'LoginController',[
	  'only' => ['index','store','edit'],
	  'names' => [
	   'index' => 'logins_path'
	  ]
	 ]);

	Route::get('/dasboard','DashboardController@index');

	Route::resource('user', 'UserController',[
	  'only' => ['index','create','store','edit','update'],
	  'names' => ['index' => 'users_path']
	 ]);
	Route::get('user/deleteItem', 'UserController@deleteItem');

	Route::resource('staff', 'StaffController',[
	  'only' => ['index','create','store','edit','update','storecharge'],
	  'names' => ['index' => 'staffs_path']
	 ]);
	Route::get('staff/deleteItem', 'StaffController@deleteItem');
	Route::get('staff/delstaffcharge', 'StaffController@deleteStaffCharge');
	Route::get('storeCharge', 'StaffController@storeCharge');
	Route::get('getCharge', 'StaffController@getCharge');
	

	Route::resource('stafftransction', 'StaffTransctionController',[
	  'only' => ['index','create','store','edit','update'],
	  'names' => ['index' => 'stafftransctions_path']
	 ]);
	Route::get('stafftransction/deleteItem', 'StaffTransctionController@deleteItem');

	Route::resource('pos', 'PosController',[
	  'only' => ['index','create','store','edit','update'],
	  'names' => ['index' => 'poss_path']
	]);
	Route::get('pos/deleteItem', 'PosController@deleteItem');

	Route::resource('posgroup', 'PosGroupController',[
	  'only' => ['index','create','store','edit','update'],
	  'names' => ['index' => 'pos_group_path']
	]);

	Route::get('posgroup/{id}/edit/{sheet}', 'PosGroupController@edit');
	Route::get('posgroup/requestpos', 'PosGroupController@requestPos');
	Route::get('posgroup/deleteItem', 'PosGroupController@deleteItem');

	Route::resource('group', 'GroupController',[
	  'only' => ['index','create','store','edit','update'],
	  'names' => ['index' => 'group_path']
	]);
	Route::get('group/deleteItem', 'GroupController@deleteItem');

	Route::resource('sale', 'SaleController',[
	  'only' => ['index','create','store','edit','update'],
	  'names' => ['index' => 'sales_path']
	 ]);
	Route::get('sale/deleteItem', 'SaleController@deleteItem');


    //route Result
    Route::resource('result', 'ResultController',[
        'only' => ['index','create','store','edit','update'],
        'names' => ['index' => 'results_path']
    ]);
    Route::get('/result/{date}/{sheet}','ResultController@resultpage');
    Route::post('/result/filter', ['as' => 'filter','uses' => 'ResultController@filter']);
    Route::post('/result/filterUpdate', ['as' => 'filterUpdate','uses' => 'ResultController@filterUpdate']);
    Route::post('/result/updateResult', ['as' => 'updateResult','uses' => 'ResultController@updateResult']);
    Route::post('/result/filterView', ['as' => 'filterView','uses' => 'ResultController@filterView']);
    Route::get('/result/modify/{date}/{sheet}','ResultController@modify');
    Route::get('/result/delete/{date}/{sheet}','ResultController@remove');
    Route::get('/result/view/{date}/{sheet}','ResultController@view');




    // route Report

    Route::post('/report/filter', ['as' => 'reportFilter','uses' => 'ReportController@filter']);
	Route::get('report','ReportController@index');
    Route::get('report/summary_lottery','ReportController@summary_lottery');
//    Route::get('report/{startDate}/{endDate}/{sheet}/{staff}/{page}','ReportController@resultReport');
//    Route::post('/report/filter', ['as' => 'filter','uses' => 'ReportController@filter']);


	
});

