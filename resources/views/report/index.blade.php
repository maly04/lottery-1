@extends('master')
<?php
use App\Http\Controllers\SaleController;
?>
@section('title')
<title>របាយការណ៏</title>
@stop

@section('cssStyle')
	<style type="text/css">
		.colume_style{
			padding-bottom:25px;
			padding-top:15px;
		}
		.colume_style:last-child{
			border-right: 1px solid #CCCCCC;
		}
		.colume_style:nth-child(8){
			border-right: 0px solid #CCCCCC;
		}
		.result_price{
			position: absolute;
			bottom: 0px;
			width: 100%;
			border-top:1px solid #CCCCCC;
			color:blue;
			padding-left:10px;
			padding-right:10px;
			font-weight:bold;
			font-size: 14px;
		}
		.result_price span{
			color:red;
		}
		.result_price_right span{
			 color:red;
		 }

		.result_price_top{
			position: absolute;
			top: 0px;
			width: 100%;
			border-bottom:1px solid #CCCCCC;
			color:blue;
			padding-left:10px;
			padding-right:10px;
			font-weight:bold;
			font-size: 14px;
		}
		.result_price_top span{
			color:red;
		}

		.display_result{
			border-top:1px solid #CCCCCC;
			font-size:18px;
			padding:10px 10px;
		}

		.val_r{
			color: blue;
		}
		.val_s{
			color: red;
		}
		.right_num{
			position: absolute;
			right:5px;
			top:2px;
			color: yellow;
		}
		.result_right{
			color:red;
			font-weight: bold;
		}
		.bee_highlight{
			background-color:lightyellow;
			font-size: 18px;
		}
		.display_total_result td{
			text-align: right;
		}
		.display_total_result tr td:nth-child(1),
		.display_total_result tr td:nth-child(2){
			text-align: left;
		}
		.result_right_total{
			color:blue;
			font-weight: bold;
		}
		.btn_print{
			margin-left: 30px;
		}

	</style>
@stop


@section('content')
<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment"> 
			<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
				<i class="fa fa-refresh"></i>
			</span> 
		</span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li><!-- Staffs -->របាយការណ៏</li>
		</ol>
		<!-- end breadcrumb -->


	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		     <!--  <h1 class="page-title txt-color-blueDark">
		       <i class="fa fa-users fa-fw "></i> របាយការណ៏
		       
		      </h1> -->
		     </div>
		    </div>
		    
		    <!-- widget grid -->
		    <section id="widget-grid" class="">
		    
		     

		     @include('flash::message')

		     <?php if($errors->all()){?>
		     <div class="alert alert-block alert-danger">
		      <a class="close" data-dismiss="alert" href="#">×</a>
		      <h4 class="alert-heading"><i class="fa fa-times"></i> Check not validation!</h4>
		      <p>
		       {{ Html::ul($errors->all(), array('class' => 'alert alert-danger')) }}
		      </p>
		     </div>
		     <?php }?>




		     <!-- row -->
		     <div class="row">
		    
		      <!-- NEW WIDGET START -->
		      <article class="col-sm-12 col-md-12 col-lg-12">

		       <!-- Widget ID (each widget will need unique ID)-->
		       <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false">
		        
		        <header>
		         <span class="widget-icon"> <i class="fa fa-table"></i> </span>
		         <!-- <h2>របាយការណ៏</h2> -->
		         <h2>របាយការណ៏</h2>
		        </header>
		    
		        <!-- widget div-->
		        <div>
		    
		         <!-- widget content -->
		         <div class="widget-body no-padding">


					 {!! Form::open(['route' => 'reportFilter', 'files' => true , 'novalidate' => 'validate', 'id' => 'filter','class'=>'smart-form filter-form']) !!}
					 <fieldset>
						 <?php $attr_sheet =0; ?>
						 <?php $attr_page = 0; ?>
						 @if(isset($var_dateStart))
							 <?php $startDate_filter = $var_dateStart; ?>
						 @else
							 <?php $startDate_filter = null; ?>
						 @endif



						 @if(isset($var_staff))
							 <?php $staff_filter = $var_staff; ?>
						 @else
							 <?php $staff_filter = null; ?>
						 @endif

						 @if(isset($var_page))
							 <?php $page_filter = $var_page; ?>
							 <?php $attr_page = $var_page; ?>
						 @else
							 <?php $page_filter = null; ?>
							 <?php $attr_page = 0; ?>
						 @endif

						 @if(isset($var_sheet))
							 <?php $sheet_filter = $var_sheet; ?>
							 <?php $attr_sheet = $var_page; ?>
						 @else
							 <?php $sheet_filter = null; ?>
							 <?php $attr_sheet = 0; ?>
						 @endif
						 <div class="row">

							 <section class="col col-2">
								 <label class="input">
									 <i class="icon-append fa fa-calendar"></i>
									 {!! Form::text("dateStart", $value = $startDate_filter, $attributes = array('class' => 'form-control required', 'id' => 'dateStart','placeholder'=> trans('result.dateStart'),'sms'=> trans('result.pleaseChooseDate') )) !!}
								 </label>

							 </section>

							 <section class="col col-2">
								 <label class="select">
									 {{ Form::select('staff', ([
                                        '' => trans('result.chooseStaff') ]+$staff),$staff_filter,['class' => 'required ','id'=>'staff','sms'=> trans('result.pleaseChooseStaff') ]
                                     ) }}
									 <i></i>
								 </label>
							 </section>

							 <section class="col col-2">
								 <label class="select">
									 {{ Form::select('sheet', ([
                                        '' => trans('result.chooseShift') ]+$sheets),$sheet_filter,['class' => ' ','id'=>'sheet','sms'=> trans('result.pleaseChooseShift') ]
                                     ) }}
									 <i></i>
								 </label>
							 </section>



							 <section class="col col-2">
								 <label class="select">
									 {{ Form::select('page', ([
                                        '' => trans('result.choosePage') ]+$pages),$page_filter,['class' => ' ','id'=>'pages','sms'=> trans('result.pleaseChoosePage') ]
                                     ) }}
									 <i></i>
								 </label>
							 </section>

							 <section class="col col-2">
								 <label class="tesxt">
									 <button type="submit" name="submit" class="btn btn-primary btn-sm btn-filter">{{ trans('result.filter') }}</button>
								 </label>
							 </section>

						 </div>
					 </fieldset>
					 {{ Form::close() }}

					 @if(isset($report))

						 <style type="text/css">
							 .smart-form select.formlottery_select{
								 box-sizing: border-box !important;
							 }
						 </style>

						 <div class="widget-body no-padding control_width">

							 <div class="">
								 <div class="">
									 <?php
									 	$page_id = 0;
										 $sum_total_twodigit_r = 0;
										 $sum_total_twodigit_s = 0;
										 $sum_total_threedigit_r = 0;
										 $sum_total_threedigit_s = 0;
										 $controlTotal = count($report)-1;

										 $sum_price_right_twodigit_r = 0;
										 $sum_price_right_twodigit_s = 0;
										 $sum_price_right_threedigit_r = 0;
										 $sum_price_right_threedigit_s = 0;


									 ?>
									 @foreach($report as $key => $rowlist)

										 @if($page_id != $rowlist->p_id)

												 {{--#display total amount by page--}}
											 	@if($key > 0)
													 <div class="col-md-6 display_result">
														 {{trans('label.total_price_number_2_digit')}} :
														 <b><span class="val_r">{{number_format($sum_total_twodigit_r)}} ៛</span></b>
														 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														 <b><span class="val_s">{{number_format($sum_total_twodigit_s)}} $</span></b>
													 </div>
													 <div class="col-md-6 display_result">
														 {{trans('label.total_price_number_3_digit')}} :
														 <b><span class="val_r">{{number_format($sum_total_threedigit_r)}} ៛</span></b>
														 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														 <b><span class="val_s">{{number_format($sum_total_threedigit_s)}} $</span></b>
													 </div>

													 <div class="col-md-6 display_result">
														 {{trans('label.total_price_number_2_digit_right')}} :
														 <b><span class="val_r">{{number_format($sum_price_right_twodigit_r)}} ៛</span></b>
														 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														 <b><span class="val_s">{{number_format($sum_price_right_twodigit_s)}} $</span></b>
													 </div>

													 <div class="col-md-6 display_result">
														 {{trans('label.total_price_number_3_digit_right')}} :
														 <b><span class="val_r">{{number_format($sum_price_right_threedigit_r)}} ៛</span></b>
														 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														 <b><span class="val_s">{{number_format($sum_price_right_threedigit_s)}} $</span></b>
													 </div>



													<input type="hidden" id="page_{{$key}}" class="report_total"
														   total2digitR="{{$sum_total_twodigit_r}}"
														   total2digitS="{{$sum_total_twodigit_s}}"
														   total3digitR="{{$sum_total_threedigit_r}}"
														   total3digitS="{{$sum_total_threedigit_s}}"
														   total2digitRright="{{$sum_price_right_twodigit_r}}"
														   total2digitSright="{{$sum_price_right_twodigit_s}}"
														   total3digitRright="{{$sum_price_right_threedigit_r}}"
														   total3digitSright="{{$sum_price_right_threedigit_s}}" >

												 @endif

												 <?php
												 $sum_total_twodigit_r = 0;
												 $sum_total_twodigit_s = 0;
												 $sum_total_threedigit_r = 0;
												 $sum_total_threedigit_s = 0;

												 $sum_price_right_twodigit_r = 0;
												 $sum_price_right_twodigit_s = 0;
												 $sum_price_right_threedigit_r = 0;
												 $sum_price_right_threedigit_s = 0;
												 ?>


												 </div>
							 				</div>
							 				<br>
							 					{{--<button class="btn_print" attr_id="print_page_{{$key}}" attr_date="{{$var_dateStart}}" attr_staff="{{$var_staff}}" attr_sheet="{{$attr_sheet}}" attr_page="{{$attr_page}}">{{trans('label.download_this')}}</button>--}}

											 <div id="print_page_{{$key}}" class="paperStyle" >

													 <div class="col-md-3">
														 {{trans('label.staff_name')}} :
														 <b>{{$rowlist->s_name}} </b>
													 </div>

													 <div class="col-md-2">
														 {{trans('label.date')}} :
														 <b>{{$rowlist->p_date}}</b>
													 </div>

													 <div class="col-md-2">
														 {{trans('label.number_paper')}} :
														 <b>{{$rowlist->p_number}}</b>
													 </div>

													 <div class="col-md-2">
														 {{trans('label.time')}} :
														 <b>{{$rowlist->pav_value}}</b>
													 </div>
												 <input type="hidden" id="page_info_{{$key}}" class="report_total_info"
														time="{{$rowlist->pav_value}}"
														page="{{$rowlist->p_number}}" >

												 <div class="clearfix"></div>
												 <br>
												 <div class="row boder controlColume">
											 <?php
											 	$page_id = $rowlist->p_id;
											 ?>
										 @endif

										 <div class="colume_style" id="Remove_{{$rowlist->r_id}}">
											 <?php
											 $total_twodigit_r = 0;
											 $total_threedigit_r = 0;
											 $total_twodigit_s = 0;
											 $total_threedigit_s = 0;

											 $price_right_twodigit_s = 0;
											 $price_right_twodigit_r = 0;
											 $price_right_threedigit_s = 0;
											 $price_right_threedigit_r = 0;
											 ?>

											 <!-- block list number lottery -->
											 <?php
											 $numberLotterys = DB::table('tbl_number')
													 ->leftjoin('tbl_parameter_value', 'tbl_number.num_sym','=','tbl_parameter_value.pav_id')
													 ->leftjoin('tbl_group', 'tbl_number.g_id','=','tbl_group.g_id')
													 ->where('tbl_number.r_id',$rowlist->r_id)
													 ->orderBy('tbl_number.num_sort','ASC')
													 ->get();

											 $storeOrder = 0;
											 ?>
											 @foreach($numberLotterys as $number)

												 {{--{{$number->num_number}}--}}
												 {{--{{$number->num_price}}--}}
												 {{--{{$number->num_sym}}--}}
												 {{--{{$number->num_end_number}}--}}
												 {{--{{$number->num_reverse}}--}}
												 {{--{{$number->num_currency}}--}}


												 @if($storeOrder != $number->num_sort)
														 <?php
														 $storeOrder = $number->num_sort;

														 ?>
														 <div class="pos_style" id="pos_style_{{$number->num_sort}}">{{$number->g_name}}</div>
												 @endif







											 <?php
												 $numberDisplay = '';  //display number to fromte
												 $displayCurrency = '';

												//	Resulte price by row
												 $price_result = App\Model\Report::calculate( $number->num_number,$number->num_end_number,$number->num_sym,$number->num_reverse,$number->num_price,$number->num_currency,$number->g_id,$rowlist->p_time,$rowlist->p_date);
												 $val_price = explode("-", $price_result);
												 $num_right = "";
												 if($val_price[2] > 0){

													 $actived = 'actived';
													 if($val_price[2]>1){
													 	$num_right = '<div class="right_num"><b>* '.$val_price[2].'</b></div>';
													 }

												 }else{
													 $actived = '';
												 }

												 if($number->num_currency == 2){
													 $currencySym = DB::table('tbl_parameter_value')->where('pav_id',2)->first();
													 $displayCurrency = ' '.$currencySym->pav_value;
													 if($val_price[1]=='2'){
														 $total_twodigit_s = $total_twodigit_s + $val_price['0'];
														 $price_right_twodigit_s = $price_right_twodigit_s + ($number->num_price * $val_price[2]);
													 }else{
														 $total_threedigit_s = $total_threedigit_s + $val_price['0'];
														 $price_right_threedigit_s = $price_right_threedigit_s + ($number->num_price * $val_price[2]);
													 }

												 }else{

													 if($val_price[1]=='2'){
														 $total_twodigit_r = $total_twodigit_r + $val_price['0'];
														 $price_right_twodigit_r = $price_right_twodigit_r + ($number->num_price * $val_price[2]);
													 }else{
														 $total_threedigit_r = $total_threedigit_r + $val_price['0'];
														 $price_right_threedigit_r = $price_right_threedigit_r + ($number->num_price * $val_price[2]);
													 }


												 }



												 if($number->num_sym == 7){ //check sym is -
													 $numberDisplay .='
													<div class="row_main '.$actived.'" id="row_main_'.$number->num_id.'">

														<div class="number_lot lot_int">'.$number->num_number.'</div>';
													 if($number->num_reverse == 1){
														 $numberDisplay .= '<div class="symbol_lot lot_int">x</div>';
													 }else{
														 $numberDisplay .= '<div class="symbol_lot lot_int">-</div>';
													 }

													 $numberDisplay .= '
														<div class="amount_lot lot_int">'.number_format($number->num_price).$displayCurrency.'</div>
														<div class="clear"></div>
														'.$num_right.'
													</div>
													';
												 }else if($number->num_sym == 8){

													 if($number->num_reverse == 1){
														 $end_number_new = '';
														 if($number->num_end_number == ''){
															 $end_number_new = substr($number->num_number, 0, -1).'9';
														 }else{
															 $end_number_new = $number->num_end_number;
														 }
														 $numberDisplay .='
														<div class="row_main '.$actived.'" id="row_main_'.$number->num_id.'">

															<div class="number_lot lot_int">'.$number->num_number.'</div>
															<div class="symbol_lot lot_int">x</div>
															<div class="clear"></div>
															<div class="display_total_number">'.SaleController::calculate_number($number->num_number,$end_number_new,1).'</div>
															<div class="number_lot lot_int clear_margin">
																|
																<div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
																<div class=" lot_int sym_absolube_amount">'.number_format($number->num_price).$displayCurrency.'</div>
															</div>
															<div class="clear"></div>
															<div class="number_lot lot_int">'.$end_number_new.'</div>
															<div class="symbol_lot lot_int">x</div>
															<div class="clear"></div>
															'.$num_right.'
														</div>
														';
													 }else{
														 $check = substr($number->num_number, -1);
														 if($check == '0' && $number->num_end_number == ''){
															 $numberDisplay .='
																<div class="row_main '.$actived.'" id="row_main_'.$number->num_id.'">

																	<div class="number_lot lot_int">'.$number->num_number.'</div>
																	<div class="symbol_lot lot_int"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
																	<div class="amount_lot lot_int">'.number_format($number->num_price).$displayCurrency.'</div>
																	<div class="clear"></div>
																</div>
																';
														 }else{
															 $end_number_new = '';
															 if($number->num_end_number == ''){
																 $end_number_new = substr($number->num_number, 0, -1).'9';
															 }else{
																 $end_number_new = $number->num_end_number;
															 }
															 $numberDisplay .='
															<div class="row_main '.$actived.'" id="row_main_'.$number->num_id.'">

																<div class="number_lot lot_int">'.$number->num_number.'</div>
																<div class="clear"></div>
																<div class="display_total_number">'.SaleController::calculate_number($number->num_number,$end_number_new,0).'</div>
																<div class="number_lot lot_int clear_margin">
																	|
																	<div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
																	<div class=" lot_int sym_absolube_amount">'.number_format($number->num_price).$displayCurrency.'</div>
																</div>
																<div class="clear"></div>
																<div class="number_lot lot_int">'.$end_number_new.'</div>
																<div class="clear"></div>
																'.$num_right.'
															</div>
															';
														 }

													 }

												 }else{
													 if($number->num_reverse == 1){
														 $numberDisplay .='
															<div class="row_main '.$actived.'" id="row_main_'.$number->num_id.'">

																<div class="number_lot lot_int">'.$number->num_number.'</div>
																<div class="symbol_lot lot_int">x</div>
																<div class="clear"></div>
																<div class="number_lot lot_int clear_margin">
																	|
																	<div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
																	<div class=" lot_int sym_absolube_amount">'.number_format($number->num_price).$displayCurrency.'</div>
																</div>
																<div class="clear"></div>
																<div class="number_lot lot_int">'.$number->num_end_number.'</div>
																<div class="symbol_lot lot_int">x</div>
																<div class="clear"></div>
																'.$num_right.'
															</div>
															';
													 }else{
														 $numberDisplay .='
															<div class="row_main '.$actived.'" id="row_main_'.$number->num_id.'">

																<div class="number_lot lot_int">'.$number->num_number.'</div>
																<div class="clear"></div>
																<div class="number_lot lot_int clear_margin">
																	|
																	<div class="sym_absolube"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
																	<div class=" lot_int sym_absolube_amount">'.number_format($number->num_price).$displayCurrency.'</div>
																</div>
																<div class="clear"></div>
																<div class="number_lot lot_int">'.$number->num_end_number.'</div>
																<div class="clear"></div>
																'.$num_right.'
															</div>
															';
													 }
												 }
												 echo $numberDisplay;
												 ?>
											 @endforeach
											 <div class="clearfix"></div>
											 <div class="result_price_top" id="row_result_2_{{$rowlist->r_id}}">{{number_format($total_twodigit_r)}} ៛  <span class="pull-right">{{number_format($total_twodigit_s)}} $</span></div>
											 <div class="result_price" id="row_result_3_{{$rowlist->r_id}}">{{number_format($total_threedigit_r)}} ៛  <span class="pull-right">{{number_format($total_threedigit_s)}} $</span></div>


										 </div>
										 		 <?php $sum_total_twodigit_r = $sum_total_twodigit_r + $total_twodigit_r;?>
												 <?php $sum_total_twodigit_s = $sum_total_twodigit_s + $total_twodigit_s;?>
												 <?php $sum_total_threedigit_r = $sum_total_threedigit_r + $total_threedigit_r;?>
												 <?php $sum_total_threedigit_s = $sum_total_threedigit_s + $total_threedigit_s;?>

												 <?php $sum_price_right_twodigit_r = $sum_price_right_twodigit_r + $price_right_twodigit_r;?>
												 <?php $sum_price_right_twodigit_s = $sum_price_right_twodigit_s + $price_right_twodigit_s;?>
												 <?php $sum_price_right_threedigit_r = $sum_price_right_threedigit_r + $price_right_threedigit_r;?>
												 <?php $sum_price_right_threedigit_s = $sum_price_right_threedigit_s + $price_right_threedigit_s;?>



												 {{--#display total amount by page--}}
												 @if($controlTotal == $key)


													 <div class="col-md-6 display_result">
														 {{trans('label.total_price_number_2_digit')}} :
														 <b><span class="val_r">{{number_format($sum_total_twodigit_r)}} ៛</span></b>
														 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														 <b><span class="val_s">{{number_format($sum_total_twodigit_s)}} $</span></b>
													 </div>

													 <div class="col-md-6 display_result">
														 {{trans('label.total_price_number_3_digit')}} :
														 <b><span class="val_r">{{number_format($sum_total_threedigit_r)}} ៛</span></b>
														 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														 <b><span class="val_s">{{number_format($sum_total_threedigit_s)}} $</span></b>
													 </div>

													 <div class="col-md-6 display_result">
														 {{trans('label.total_price_number_2_digit_right')}} :
														 <b><span class="val_r">{{number_format($sum_price_right_twodigit_r)}} ៛</span></b>
														 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														 <b><span class="val_s">{{number_format($sum_price_right_twodigit_s)}} $</span></b>
													 </div>

													 <div class="col-md-6 display_result">
														 {{trans('label.total_price_number_3_digit_right')}} :
														 <b><span class="val_r">{{number_format($sum_price_right_threedigit_r)}} ៛</span></b>
														 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														 <b><span class="val_s">{{number_format($sum_price_right_threedigit_s)}} $</span></b>
													 </div>

													 <input type="hidden" id="page_{{$key}}" class="report_total"
															total2digitR="{{$sum_total_twodigit_r}}"
															total2digitS="{{$sum_total_twodigit_s}}"
															total3digitR="{{$sum_total_threedigit_r}}"
															total3digitS="{{$sum_total_threedigit_s}}"
															total2digitRright="{{$sum_price_right_twodigit_r}}"
															total2digitSright="{{$sum_price_right_twodigit_s}}"
															total3digitRright="{{$sum_price_right_threedigit_r}}"
															total3digitSright="{{$sum_price_right_threedigit_s}}">


												 @endif

									 @endforeach

								 </div>

							 </div>
							 <?php
							 $twodigit_charge = 0;
							 $threedigit_charge = 0;
							 $getStaffCharge = DB::table('tbl_staff_charge')
									 ->select('stc_id','stc_three_digit_charge','stc_two_digit_charge')
									 ->where('s_id',$var_staff)
									 ->where('stc_date','<=',$var_dateStart)
									 ->orderBy('stc_date','DESC')
									 ->first();
							 $twodigit_charge = $getStaffCharge->stc_two_digit_charge;
							 $threedigit_charge = $getStaffCharge->stc_three_digit_charge;
							 ?>
							 @if($var_sheet=='' && $var_page=='')
								 <br>
							 	​ <br>
								 {{--<button class="btn_print" attr_id="html-content-holder" attr_date="{{$var_dateStart}}" attr_staff="{{$var_staff}}" attr_sheet="{{$attr_sheet}}" attr_page="{{$attr_page}}">{{trans('label.download_this')}}</button>--}}
								 <div id="html-content-holder" class="widget-body paperStyle">
									 <h1>{{trans('label.summary_result_per_day')}}</h1>
									 <table id="" class="table table-bordered summary_result_per_day">
										 <thead>
										 <tr>
											 <th>{{trans('label.time')}}</th>
											 <th>{{trans('label.number_paper')}}</th>
											 <th>{{trans('label.two_digit_R')}}</th>
											 <th>{{trans('label.two_digit_S')}}</th>
											 <th>{{trans('label.three_digit_R')}}</th>
											 <th>{{trans('label.three_digit_S')}}</th>
											 <th>{{trans('label.two_digit_R_right')}}</th>
											 <th>{{trans('label.two_digit_S_right')}}</th>
											 <th>{{trans('label.three_digit_R_right')}}</th>
											 <th>{{trans('label.three_digit_S_right')}}</th>
										 </tr>
										 </thead>
										 <tbody class="display_total_result">
										 </tbody>
									 </table>
								</div>

							 @endif
						 </div>




					 @endif



		    
		         </div>
		         <!-- end widget content -->
		    
		        </div>
		        <!-- end widget div -->
		    
		       </div>
		       <!-- end widget -->
		    
		      </article>
		      <!-- WIDGET END -->
		     </div>
		     <!-- end row -->
		    
		    </section>
		    <!-- end widget grid -->

	</div>
<!-- END MAIN CONTENT -->
@endsection


@section('javascript')
	<script type="text/javascript">
		$(document).off('submit', '#filter').on('submit', '#filter', function(e){
			if (validate_form_main('#filter') == 0) {
				return true;
			}
			return false;
		});

@if(isset($report))

		function commaSeparateNumber(val){
			while (/(\d+)(\d{3})/.test(val.toString())){
				val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
			}
			return val;
		}



		$(document).ready(function() {
			var total2digitr = '';
			var total2digits = '';
			var total3digitr = '';
			var total3digits = '';
			var total2digitrright = '';
			var total2digitsright = '';
			var total3digitrright = '';
			var total3digitsright = '';
			var time = '';
			var page = '';
			var tr = '';
			var sum_total2digitrright = 0;
			var sum_total2digitsright = 0;
			var sum_total3digitrright = 0;
			var sum_total3digitsright = 0;

			var num_total2digitrright = 0;
			var num_total2digitsright = 0;
			var num_total3digitrright = 0;
			var num_total3digitsright = 0;


			var twodigit_charge = <?php echo $twodigit_charge;?>;
			var threedigit_charge = <?php echo $threedigit_charge;?>;

			var sum_total2digitr = 0;
			var sum_total2digits = 0;
			var sum_total3digitr = 0;
			var sum_total3digits = 0;


			$(".report_total").each(function(index, element) {
				total2digitr = $(this).attr('total2digitr');
				total2digits = $(this).attr('total2digits');
				total3digitr = $(this).attr('total3digitr');
				total3digits = $(this).attr('total3digits');
				total2digitrright = $(this).attr('total2digitrright');
				total2digitsright = $(this).attr('total2digitsright');
				total3digitrright = $(this).attr('total3digitrright');
				total3digitsright = $(this).attr('total3digitsright');

				if(total2digitrright==0){
					num_total2digitrright = 0;
					total2digitrright = '-';
				}else{
					num_total2digitrright = total2digitrright;
					total2digitrright = total2digitrright+' X 70';

				}
				if(total2digitsright==0){
					num_total2digitsright = 0;
					total2digitsright = '-';
				}else{
					num_total2digitsright = total2digitsright;
					total2digitsright = total2digitsright+' X 70';
				}
				if(total3digitrright==0){
					num_total3digitrright = 0;
					total3digitrright = '-';
				}else{
					num_total3digitrright = total3digitrright;
					total3digitrright = total3digitrright+' X 600';
				}
				if(total3digitsright==0){
					num_total3digitsright = 0;
					total3digitsright = '-';
				}else{
					num_total3digitsright = total3digitsright;
					total3digitsright = total3digitsright+' X 600';
				}

				sum_total2digitr = sum_total2digitr + parseInt(total2digitr);
				sum_total2digits = sum_total2digits + parseInt(total2digits);
				sum_total3digitr = sum_total3digitr + parseInt(total3digitr);
				sum_total3digits = sum_total3digits + parseInt(total3digits);

				sum_total2digitrright = sum_total2digitrright + parseInt(num_total2digitrright);
				sum_total2digitsright = sum_total2digitsright + parseInt(num_total2digitsright);
				sum_total3digitrright = sum_total3digitrright + parseInt(num_total3digitrright);
				sum_total3digitsright = sum_total3digitsright + parseInt(num_total3digitsright);

				tr = '<tr><td id="td_time_'+index+'">'+time+'</td><td id="td_page_'+index+'">'+page+'</td><td>'+commaSeparateNumber(total2digitr)+'</td><td>'+commaSeparateNumber(total2digits)+'</td><td>'+commaSeparateNumber(total3digitr)+'</td><td>'+commaSeparateNumber(total3digits)+'</td><td class="result_right">'+commaSeparateNumber(total2digitrright)+'</td><td class="result_right">'+commaSeparateNumber(total2digitsright)+'</td><td class="result_right">'+commaSeparateNumber(total3digitrright)+'</td><td class="result_right">'+commaSeparateNumber(total3digitsright)+'</td><tr>';
				$('.display_total_result').append(tr);


			});

			var total_income_expense_riel = 0;
			var total_income_expense_dollar = 0;

			var income_riel = parseInt(Math.round(((parseInt(sum_total2digitr) * parseInt(twodigit_charge)) / 100)) + Math.round(((parseInt(sum_total3digitr) * parseInt(threedigit_charge)) / 100)));
			var income_dollar = (((parseInt(sum_total2digits) * parseInt(twodigit_charge)) / 100) + ((parseInt(sum_total3digits) * parseInt(threedigit_charge)) / 100)).toFixed(2);
			var expense_riel = (parseInt(sum_total2digitrright * 70) + parseInt(sum_total3digitrright * 600) );
			var expense_dollar = (parseInt(sum_total2digitsright * 70) + parseInt(sum_total3digitsright * 600));

			var total_income_expense_riel = income_riel - expense_riel;
			var total_income_expense_dollar = income_dollar - expense_dollar;

			tr = '<tr class="bee_highlight"><td></td><td>{{trans('label.total')}}</td><td>'+commaSeparateNumber(sum_total2digitr)+'</td><td>'+commaSeparateNumber(sum_total2digits)+'</td><td>'+commaSeparateNumber(sum_total3digitr)+'</td><td>'+commaSeparateNumber(sum_total3digits)+'</td><td class="result_right">'+commaSeparateNumber(sum_total2digitrright)+' X 70</td><td class="result_right">'+commaSeparateNumber(sum_total2digitsright)+' X 70</td><td class="result_right">'+commaSeparateNumber(sum_total3digitrright)+' X 600</td><td class="result_right">'+commaSeparateNumber(sum_total3digitsright)+' X 600</td><tr>';
			$('.display_total_result').append(tr);
			tr = '<tr class="bee_highlight"><td></td><td>{{trans('label.total_charge')}}</td><td>'+commaSeparateNumber(Math.round(((parseInt(sum_total2digitr) * parseInt(twodigit_charge)) / 100)))+'</td><td>'+commaSeparateNumber(((parseInt(sum_total2digits) * parseInt(twodigit_charge)) / 100).toFixed(2))+'</td><td>'+commaSeparateNumber(Math.round(((parseInt(sum_total3digitr) * parseInt(threedigit_charge)) / 100)))+'</td><td>'+commaSeparateNumber(((parseInt(sum_total3digits) * parseInt(threedigit_charge)) / 100).toFixed(2))+'</td><td class="result_right">'+commaSeparateNumber(sum_total2digitrright * 70)+'</td><td class="result_right">'+commaSeparateNumber(sum_total2digitsright * 70 )+'</td><td class="result_right">'+commaSeparateNumber(sum_total3digitrright * 600)+'</td><td class="result_right">'+commaSeparateNumber(sum_total3digitsright * 600)+'</td><tr>';
			$('.display_total_result').append(tr);
			tr = '<tr class=""><td colspan="10"></td><tr>';
			$('.display_total_result').append(tr);
			tr = '<tr class="bee_highlight"><td></td><td>{{trans('label.total_pay')}}</td><td>'+commaSeparateNumber(income_riel)+' ៛</td><td>'+commaSeparateNumber(income_dollar)+' $</td><td class="result_right"></td><td class="result_right"></td><td class="result_right"></td><td class="result_right"></td><td class="result_right"></td><td class="result_right"></td><tr>';
			$('.display_total_result').append(tr);
			tr = '<tr class="bee_highlight"><td></td><td>{{trans('label.total_right')}}</td><td class="result_right">'+commaSeparateNumber(expense_riel)+' ៛</td><td class="result_right">'+commaSeparateNumber(expense_dollar)+' $</td><td></td><td></td><td class="result_right"></td><td class="result_right"></td><td class="result_right"></td><td class="result_right"></td><tr>';
			$('.display_total_result').append(tr);
			tr = '<tr class="bee_highlight"><td></td><td>{{trans('label.total')}}</td><td class="result_right_total">'+commaSeparateNumber(total_income_expense_riel)+' ៛</td><td class="result_right_total">'+commaSeparateNumber(total_income_expense_dollar.toFixed(2))+' $</td><td></td><td></td><td class="result_right"></td><td class="result_right"></td><td class="result_right"></td><td class="result_right"></td><tr>';
			$('.display_total_result').append(tr);

			$(".report_total_info").each(function(index, element) {
				time = $(this).attr('time');
				page = $(this).attr('page');
				$('.display_total_result').find('#td_time_'+index).text(time);
				$('.display_total_result').find('#td_page_'+index).text(page);

			});

			@if($var_dateStart!='' &&  $var_staff!='' && $var_page=='' && $var_sheet=='')
				var date = '{{$var_dateStart}}';
				var staff = '{{$var_staff}}';
				var income_riel = parseInt(Math.round(((parseInt(sum_total2digitr) * parseInt(twodigit_charge)) / 100)) + Math.round(((parseInt(sum_total3digitr) * parseInt(threedigit_charge)) / 100)));
				var income_dollar = (((parseInt(sum_total2digits) * parseInt(twodigit_charge)) / 100) + ((parseInt(sum_total3digits) * parseInt(threedigit_charge)) / 100)).toFixed(2);
				var expense_riel = (parseInt(sum_total2digitrright * 70) + parseInt(sum_total3digitrright * 600) );
				var expense_dollar = (parseInt(sum_total2digitsright * 70) + parseInt(sum_total3digitsright * 600));
//				console.log(income_riel);
//				console.log(income_dollar);
//				console.log(expense_riel);
//				console.log(expense_dollar);
				$.ajax({
					url: 'summary_lottery',
					type: 'GET',
					data: {date:date,staff:staff,income_riel:income_riel,income_dollar:income_dollar,expense_riel:expense_riel,expense_dollar:expense_dollar},
					success: function(data) {
						if(data.status=="success"){
//							console.log(data.msg);
						}else{
//							console.log(data.msg);
						}
					}
				});
		    @endif






		});

@endif
	$(document).ready(function() {
		// START AND FINISH DATE
		$('#dateStart').datepicker({
			dateFormat : 'yy-mm-dd',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#dateEnd').datepicker('option', 'minDate', selectedDate);
			}
		});
		$('#dateEnd').datepicker({
			dateFormat : 'yy-mm-dd',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#dateStart').datepicker('option', 'mixDate', selectedDate);
			}
		});
	});
	$(document).ready(function(){

		$('.btn_print').click(function(){
			var attr_id = $(this).attr('attr_id');
			var attr_date = $(this).attr('attr_date');
			var attr_staff = $(this).attr('attr_staff');
			var attr_sheet = $(this).attr('attr_sheet');
			if(attr_sheet==''){
				attr_sheet = 0;
			}
			var attr_page = $(this).attr('attr_page');
			if(attr_page==''){
				attr_page = 0;
			}
			var form_upload = $('#frmupload');
			var fram_upload = $('<iframe style="border:0px; width:0px; height:0px; opacity: 0px;" src="http://188.166.234.165/lottery/screenshot/download.php?attr_id='+attr_id+'&attr_date='+attr_date+'&attr_staff='+attr_staff+'&attr_sheet='+attr_sheet+'&attr_page='+attr_page+'" id="framupload" name="framupload"></iframe>');

			$('body').append(fram_upload);

		});
	});
	</script>
@stop