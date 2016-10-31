@extends('master')
<?php 
use App\Http\Controllers\SaleController;
?>
@section('title')
<title>{{ trans('label.detail_paper') }}</title>
@stop

@section('cssStyle')
	<style type="text/css">
		/*style popup*/


	</style>
@stop


@section('content')

	<style type="text/css">
		.smart-form select.formlottery_select{
			box-sizing: border-box !important;
		}
	</style>
<!-- RIBBON -->
	<!-- include popup modify number -->
	@include('sale.popupmodify')

	<div id="ribbon">
		<span class="ribbon-button-alignment"> 
			<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
				<i class="fa fa-refresh"></i>
			</span> 
		</span>
		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>{{ trans('label.sale') }}</li><li>{{ trans('label.detail_paper') }}</li>
		</ol>
		<!-- end breadcrumb -->


	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">

		<!-- <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		      <h1 class="page-title txt-color-blueDark">
		       <i class="fa fa-sort-numeric-asc fa-fw "></i> 
		        New Paper 
		      </h1>
		     </div>
		</div> -->

		
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
		         <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
		         <h2>{{ trans('label.paper') }}</h2>    
		         
		        </header>

		        <!-- widget div-->
		        <div>
		         
		         <!-- widget edit box -->
		         <div class="jarviswidget-editbox">
		          <!-- This area used as dropdown edit box -->
		          
		         </div>
		         <!-- end widget edit box -->
		         
		         <!-- widget content -->
		         <div class="widget-body no-padding control_width">                  
		             

		            <div class="paperStyle">
		            	<div class="row">
		            		<!-- start form submit -->
		            		{!! Form::model($sale, ['route' => ['sale.update', $sale->p_id] ,'method' => 'PATCH',  'class' => 'smart-form user-form', 'novalidate' => 'validate', 'id' => 'checkout-form' ,"autocomplete"=>"false"]) !!}
					           <fieldset>

						            <div class="row">
							             <section class="col col-3">
							              {{ Form::label('s_id', trans('label.staff_name') , array('class' => 'label')) }}
							              <label class="select"><i class="icon-append fa"></i>
							               		{!! Form::select('s_id', (['' => 'Choose']+$staffs) , $sale->s_id,['class' => 'select2 ','id'=>'s_id']) !!}
							              		
							              </label>
							             </section>
							             <section class="col col-1">
							              {{ Form::label('p_code', trans('label.code'), array('class' => 'label')) }}
							              <label class="input">
							               {!! Form::text("p_code", $value = null, $attributes = array( 'id' => 'p_code', 'class'=>'form-control')) !!}
							              </label>
							             </section>
							             <section class="col col-2">
							              {{ Form::label('p_number', trans('label.number_paper'), array('class' => 'label')) }}
							              <label class="input">
							               {!! Form::text("p_number", $value = null, $attributes = array( 'id' => 'p_number', 'class'=>'form-control')) !!}
							              </label>
							             </section>
							             <section class="col col-2">
							              		{{ Form::label('p_time', trans('label.time'), array('class' => 'label')) }}
								              	<label class="select"> <i class="icon-append fa"></i>
								              		{!! Form::select('p_time', (['' => 'Choose']+$times) , $sale->p_time,['class' => ' ','id'=>'p_time']) !!}
								              	</label>
							             </section>
							             <section class="col col-3">
								              {{ Form::label('p_date', trans('label.date'), array('class' => 'label')) }}
								              <label class="input"> <i class="icon-append fa fa-calendar"></i>
								               {!! Form::text("p_date", $value = null, $attributes = array( 'id' => 'p_date', 'placeholder'=>'YYYY-MM--DD')) !!}
								              </label>
							             </section>
							             <section class="col col-1">
									            <button type="submit" name="submit" class="btn btn-primary stylebtninsection">{{trans('label.save')}}</button> 
							             </section>
							        </div>
								
					           	</fieldset>
					          {{ Form::close() }}
		            		<!-- end form -->
		            	</div>
		            	<div class="row boder controlColume">
		            		@foreach($rowList as $rowlist)
		            			<div class="colume_style" id="Remove_{{$rowlist->r_id}}">
			                        <div class="remove_row_style eventRemoveColume" colume="{{$rowlist->r_id}}" page="{{$rowlist->p_id}}">
			                            <i class="fa fa-minus-square txt-color-red" aria-hidden="true"></i>
			                        </div>

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

				                        @if($storeOrder != $number->num_sort)
				                        	<?php 
				                        		 $storeOrder = $number->num_sort;
				                        	?>
				                        	<div class="pos_style" id="pos_style_{{$number->num_sort}}">{{$number->g_name}}</div>
				                        @endif

				                        <?php 
				                        	$numberDisplay = '';  //display number to fromte
								            $displayCurrency = '';
								            if($number->num_currency == 2){
								            	$currencySym = DB::table('tbl_parameter_value')->where('pav_id',2)->first();
								                $displayCurrency = $currencySym->pav_value;
								            }

								           

								            if($number->num_sym == 7){ //check sym is -
								                $numberDisplay .='
								                <div class="row_main" id="row_main_'.$number->num_id.'">
								                    <div class="optionNumber" colume="'.$number->r_id.'" page="'.$sale->p_id.'" number="'.$number->num_id.'">
								                        <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
								                        <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
								                    </div>
								                    <div class="number_lot lot_int">'.$number->num_number.'</div>';
								                    if($number->num_reverse == 1){
								                        $numberDisplay .= '<div class="symbol_lot lot_int">x</div>';
								                    }else{
								                        $numberDisplay .= '<div class="symbol_lot lot_int">-</div>';
								                    }
								                    
								                $numberDisplay .= '
								                    <div class="amount_lot lot_int">'.number_format($number->num_price).$displayCurrency.'</div>
								                    <div class="clear"></div>
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
								                    <div class="row_main" id="row_main_'.$number->num_id.'">

								                        <div class="optionNumber" colume="'.$number->r_id.'" page="'.$sale->p_id.'" number="'.$number->num_id.'">
								                            <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
								                            <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
								                        </div>
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
								                    </div>
								                    '; 
								                }else{
								                    $check = substr($number->num_number, -1);
								                    if($check == '0' && $number->num_end_number == ''){
								                        $numberDisplay .='
								                            <div class="row_main" id="row_main_'.$number->num_id.'">
								                                <div class="optionNumber" colume="'.$number->r_id.'" page="'.$sale->p_id.'" number="'.$number->num_id.'">
								                                    <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
								                                    <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
								                                </div>
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
								                        <div class="row_main" id="row_main_'.$number->num_id.'">
								                            <div class="optionNumber" colume="'.$number->r_id.'" page="'.$sale->p_id.'" number="'.$number->num_id.'">
								                                <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
								                                <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
								                            </div>
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
								                        </div>
								                        '; 
								                    }
								                     
								                }
								                
								            }else{
								                if($number->num_reverse == 1){
								                    $numberDisplay .='
								                        <div class="row_main" id="row_main_'.$number->num_id.'">
								                            <div class="optionNumber" colume="'.$number->r_id.'" page="'.$sale->p_id.'" number="'.$number->num_id.'">
								                                <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
								                                <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
								                            </div>
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
								                        </div>
								                        '; 
								                }else{
								                    $numberDisplay .='
								                        <div class="row_main" id="row_main_'.$number->num_id.'">
								                            <div class="optionNumber" colume="'.$number->r_id.'" page="'.$sale->p_id.'" number="'.$number->num_id.'">
								                                <i class="fa fa-edit eventEditnumberAny" aria-hidden="true"></i>
								                                <i class="fa fa-minus txt-color-red eventDeletenumberAny" aria-hidden="true"></i>
								                            </div>
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
								                        </div>
								                        '; 
								                }
								            }
								            echo $numberDisplay;
				                        ?>

				            			
			            			@endforeach
			            			

			                        <!-- form add lottery -->
									<div class='row_main custom_padding smart-form' id="event_add_in_row_{{$rowlist->r_id}}">
			            				<div class="lottery_num pos_style formAddGroup">
			            					<select id="pos_id_add" name="pos_id_add" class="formlottery_select eventPostInRow">
			            						<option value="">{{trans('label.pos')}}</option>
			            						@foreach($groups as $group)
			            						<option value="{{ $group->g_id }}">{{ $group->g_name }}</option>
			            						@endforeach
			            					</select>
			            					<div class="lottery_num main_checkbo">
				            					<span>{{trans('label.new')}}</span>
				            					<input type="checkbox" id="need_new_group" name="need_new_group"​ class="check_style">
				            				</div>
			            					<input type="hidden" id='pos_id_hidden' name="pos_id_hidden" class="required">
			            					<input type="hidden" id='pos_id_hidden_old' name="pos_id_hidden_old" class="">
			            					<input type="hidden" id='r_id_hidden' name="r_id_hidden" value="{{$rowlist->r_id}}">
			            					<input type="hidden" id='p_id_hidden' name="p_id_hidden" value="{{$rowlist->p_id}}">
			            				</div>
			            				<div class="clear"></div>
			            				<div class="lottery_num">
			            					{!! Form::text("num_number_add", $value = null, $attributes = array( 'id' => 'num_number_add', 'class'=>'form-control formlottery threedigitNew num required eventControlnumber', 'placeholder'=>trans('label.number'))) !!}
			            				</div>
			            				<div class="lottery_num_select">
			            					<select id="sym_id_add" name="sym_id_add" class="formlottery_select eventControlSym">
			            						@foreach($symbols as $symbol)
			            						<option value="{{ $symbol->pav_id }}">{{ $symbol->pav_value }}</option>
			            						@endforeach
			            					</select>
			            				</div>
			            				<div class="lottery_num">
			            					{!! Form::text("num_number_end_add", $value = null, $attributes = array( 'id' => 'num_number_end_add','disabled' => 'true', 'class'=>'form-control formlottery threedigitNew num', 'placeholder'=>trans('label.number'))) !!}
			            				</div>
			            				<div class="lottery_num main_checkbo">
			            					<span>{{trans('label.multiply')}}</span>
			            					<input type="checkbox" id="num_reverse_add" name="num_reverse_add"​ class="check_style">
			            				</div>
			            				<div class="lottery_num main_price">
			            					{!! Form::text("num_amount_add", $value = null, $attributes = array( 'id' => 'num_amount_add', 'class'=>'form-control formlottery num required', 'placeholder'=>trans('label.money'))) !!}
			            				</div>
			            				<div class="lottery_num_select customStyleCurrency">
			            					<select id="currentcy_add" name="currentcy_add" class="formlottery_select customCurrency">
			            						@foreach($currencys as $currency)
			            						<option value="{{ $currency->pav_id }}">{{ $currency->pav_value }}</option>
			            						@endforeach
			            					</select>
			            				</div>
			            				<div class="clear"></div>
			            				<div class="btnSave">
			            					<button type="button" id="saveLotteryAdd" colume="{{$rowlist->r_id}}" page="{{$rowlist->p_id}}" name="saveLottery" class="btn btn-xs btn-primary saveLotteryAdd">{{trans('label.save')}}</button>
			            				</div>
			            				<div class="clear"></div>
			            			</div>
								</div>

								
		            		@endforeach
		            		@if($countRowInPage < 8)
		            		<div class="btn_add_colume addNewRowNumber" page_id='{{$sale->p_id}}' page_time='{{$sale->p_time}}'>
		            			<i class="fa fa-fw fa-plus-circle txt-color-green" aria-hidden="true"></i>
		            		</div>
		            		@else
		            		<div class="btn_add_colume addNewRowNumber" page_id='{{$sale->p_id}}' page_time='{{$sale->p_time}}' style="display:none;">
		            			<i class="fa fa-fw fa-plus-circle txt-color-green" aria-hidden="true"></i>
		            		</div>
		            		@endif


		            	</div>
		            </div>

		          
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
	<script src="{{ asset('/') }}js/plugin/jquery-form/jquery-form.min.js"></script>
	<script type="text/javascript">


		$(document).ready(function() {
		   pageSetUp();

		   // block function
		   function validate_end_number(main){
		   		var numStart = $('#'+main).find('#num_number_add').val();
		   		var symID = $('#'+main).find('#sym_id_add').val();
		   		lengthStr = numStart.length;
		   		if(lengthStr == 2){
		   			var firstDigit = numStart.substring(0, 1);
					var secondDigit = numStart.substring(1, 2);

					// alert(firstDigit);
					// alert(secondDigit);
					// alert(symID);

					
					if(symID == 7){
						$('#'+main).find('#num_number_end_add').val('').prop( "disabled", true );
					}else if(symID == '9'){
						$('#'+main).find('#num_number_end_add').val('').prop( "disabled", false );
					}else if(firstDigit != '0' && secondDigit == '0'){
						$('#'+main).find('#num_number_end_add').val('').prop( "disabled", true );
					}else if(firstDigit != '0' && secondDigit != '0' && symID == null){
						$('#'+main).find('#num_number_end_add').val('').prop( "disabled", true );
						$('#'+main).find('#sym_id_add option[value="7"]').prop( "selected", true );
					
					}else{
						$('#'+main).find('#num_number_end_add').val('').prop( "disabled", false );
					}
		   		}else{
		   			var firstDigit = numStart.substring(0, 1);
					var secondDigit = numStart.substring(1, 2);
					var thrithDigit = numStart.substring(2, 3);

					// alert(firstDigit);
					// alert(secondDigit);
					// alert(symID);

					
					if(symID == 7){
						$('#'+main).find('#num_number_end_add').val('').prop( "disabled", true );
					}else if(symID == '9'){
						$('#'+main).find('#num_number_end_add').val('').prop( "disabled", false );
					}else if(thrithDigit == '0'){
						$('#'+main).find('#num_number_end_add').val('').prop( "disabled", true );
					// }else if(firstDigit != '0' && secondDigit != '0' && symID == null){
					// 	$('#'+main).find('#num_number_end_add').val('').prop( "disabled", true );
					// 	$('#'+main).find('#sym_id_add option[value="7"]').prop( "selected", true );
					
					}else{
						$('#'+main).find('#num_number_end_add').val('').prop( "disabled", false );
					}
		   		}
		   }

		   // event click save number 
		   $(document).off('click', '.saveLotteryAdd').on('click', '.saveLotteryAdd', function(e){
		  		var main = $(this).parent().parent().attr('id');
		  		
		  		if (validate_form_main('#'+main) == 0) {
		  			var pos_id = $('#'+main).find('#pos_id_hidden').val();
		  			if($('#'+main).find('#need_new_group').is(":checked")){
		  				var checkNewGroup = 1;
		  			}else{
		  				var checkNewGroup = 0;
		  			}
		  			var num_start = $('#'+main).find('#num_number_add').val();
		  			var num_end = $('#'+main).find('#num_number_end_add').val();
		  			var sym_id = $('#'+main).find('#sym_id_add').val();
		  			if($('#'+main).find('#num_reverse_add').is(":checked")){
		  				var num_reverse = 1;
		  			}else{0
		  				var num_reverse = 0;
		  			}
		  			var num_amount = $('#'+main).find('#num_amount_add').val();
		  			var num_currency = $('#'+main).find('#currentcy_add').val();
		  			

		  			var colume_id = $('#'+main).find('#r_id_hidden').val();
		  			var page_id = $('#'+main).find('#p_id_hidden').val();

		  			// validate number before insert
		  			var error  = 0;
		  			lengthStr = num_start.length;
		  			if(sym_id == 8 && lengthStr == 2 && num_end != ''){
		  				var oneNumStart = num_start.substring(0, 1);
		  				var twoNumStart = num_start.substring(1, 2);
		  				var oneNumEnd = num_end.substring(0, 1);
		  				var twoNumEnd = num_end.substring(1, 2);
		  				if( (oneNumStart == oneNumEnd) || (twoNumStart == twoNumEnd) ){
		  					if( (oneNumStart == oneNumEnd) && (twoNumStart >= twoNumEnd) ){
		  						var error  = error + 1;
		  					}
		  					if( (twoNumStart == twoNumEnd) && (oneNumStart >= oneNumEnd) ){
		  						var error  = error + 1;
		  					}
		  				}else if( (oneNumStart == twoNumStart) && (oneNumEnd == twoNumEnd) ){

		  				
		  				}else{
		  					var error  = error + 1;
		  				}
		  			}else if(sym_id == 8 && lengthStr == 3 && num_end != ''){

		  				var oneNumStart = num_start.substring(0, 1);
		  				var twoNumStart = num_start.substring(1, 2);
		  				var threeNumStart = num_start.substring(2, 3);

		  				var oneNumEnd = num_end.substring(0, 1);
		  				var twoNumEnd = num_end.substring(1, 2);
		  				var threeNumEnd = num_end.substring(2, 3);

		  				// alert(oneNumStart);
		  				// alert(twoNumStart);
		  				// alert(threeNumStart);

		  				// alert(oneNumEnd);
		  				// alert(twoNumEnd);
		  				// alert(threeNumEnd);
		  				if( (oneNumStart != oneNumEnd) && (twoNumStart != twoNumEnd)  && (threeNumStart != threeNumEnd) ){

		  				}else if( ((oneNumStart == oneNumEnd) && (twoNumStart == twoNumEnd)) || ((oneNumStart == oneNumEnd) && (threeNumStart == threeNumEnd)) || ((twoNumStart == twoNumEnd) && (threeNumStart == threeNumEnd)) ){
		  					if( (oneNumStart == oneNumEnd) && (twoNumStart == twoNumEnd) && (threeNumStart >= threeNumEnd) ){
		  						var error  = error + 1;
		  					}
		  					if( (oneNumStart == oneNumEnd) && (threeNumStart == threeNumEnd) && (twoNumStart >= twoNumEnd) ){
		  						var error  = error + 1;
		  					}
		  					if( (twoNumStart == twoNumEnd) && (threeNumStart == threeNumEnd) && (oneNumStart >= oneNumEnd) ){
		  						var error  = error + 1;
		  					}

		  				}else{
		  					var error  = error + 1;
		  				}
		  			}else if(sym_id == 9){
		  				if(num_start > num_end){
		  					var error  = error + 1;
		  				}
		  			}



		  			if(error > 0){
		  				$('#'+main).find('#num_number_end_add').addClass('invalid');
						$('#'+main).find('#num_number_end_add').parent().addClass('state-error');
		  			}else{
		  				$('#'+main).find('#num_number_end_add').removeClass('invalid');
						$('#'+main).find('#num_number_end_add').parent().removeClass('state-error');
		  			}

		  			// check amount with currency
		  			if(num_currency == 1 && num_amount < 100){
		  				var error  = error + 1;
		  				$('#'+main).find('#num_amount_add').addClass('invalid');
						$('#'+main).find('#num_amount_add').parent().addClass('state-error');
		  			}else{
		  				$('#'+main).find('#num_amount_add').removeClass('invalid');
						$('#'+main).find('#num_amount_add').parent().removeClass('state-error');
		  			}

		  			// insert number to db
		  			if(error == 0){
		  				$.ajax({
				              url: '{{URL::to('/')}}/addnewnumberlottery',
				              type: 'GET',
				              data: {
				              	pos_id:pos_id,checkNewGroup:checkNewGroup,
				              	num_start:num_start,num_end:num_end,
				              	sym_id:sym_id,num_reverse:num_reverse,
				              	num_amount:num_amount,num_currency:num_currency,
				              	colume_id:colume_id,page_id:page_id

				              },
				              success: function(data) {
				              	console.log(data);
				                if(data.status=="success"){
				                  	$("#event_add_in_row_"+colume_id).before(data.msg);

				                  	$('#'+main).find('#pos_id_hidden_old').val(pos_id);

				                  	$('#'+main).find('#need_new_group').prop( "checked", false );
				                  	$('#'+main).find('#num_number_add').val('');
				                  	$('#'+main).find('#num_number_end_add').val('');
				                  	$('#'+main).find('#num_reverse_add').prop( "checked", false );
				                  	$('#'+main).find('#num_amount_add').val('');

				                  	$('#'+main).find('#num_number_add').focus();

				                }else{
				                	$('#'+main).find('#num_number_add').focus();
				                	alert(data.msg);
				                  // callPopupLogin();
				                }        
				              }
				        });
		  			}
		  			
		  		}
		  		return false;
		   });

			// control numer with sym
			$(document).off('change', '.eventControlnumber').on('change', '.eventControlnumber', function(e){
				var number = $(this).val();
				var main = $(this).parent().parent().attr('id');
				lengthStr = number.length;

				// remove class three and two firstDigit
				$('#'+main).find('#num_number_end_add').removeClass('twodigitNew').removeClass('threedigitNew');

				// alert(lengthStr);
				if(lengthStr == 2){
					
					$('#'+main).find('#num_number_end_add').addClass('twodigitNew');
					// var firstDigit = number.substring(0, 1);
					// var secondDigit = number.substring(1, 2);
					// if(firstDigit != '0' && secondDigit != '0'){
					// 	$('#'+main).find('#sym_id_add option[value="8"]').attr("disabled","disabled");
					// }else{
					// 	$('#'+main).find('#sym_id_add option[value="8"]').removeAttr("disabled");
					// }
					
				}else{
					// var firstDigit = number.substring(0, 1);
					// var secondDigit = number.substring(1, 2);
					// var thirthDigit = number.substring(2, 3);
					$('#'+main).find('#num_number_end_add').addClass('threedigitNew');
				// 	if(firstDigit != '0' && secondDigit != '0' && thirthDigit != '0'){
				// 		$('#'+main).find('#sym_id_add option[value="8"]').attr("disabled","disabled");
				// 	}else{
				// 		$('#'+main).find('#sym_id_add option[value="8"]').removeAttr("disabled");
				// 	}
				}

				// validate_end_number(main);

			});
			
	
			// control number with sym
			$(document).off('change', '.eventControlSym').on('change', '.eventControlSym', function(e){
				var sym_text = $(this).val();
				var main = $(this).parent().parent().attr('id');
				// var sym_text = $('#'+main).find('#sym_id_add option:selected').text();

				// console.log(sym_text);
				if(sym_text == 7){
					$('#'+main).find('#num_number_end_add').val('').prop( "disabled", true );
				}else{
					$('#'+main).find('#num_number_end_add').val('').prop( "disabled", false );
				}
				// validate_end_number(main);
			});

		   // event for select pos in row
		    $(document).off('change', '.eventPostInRow').on('change', '.eventPostInRow', function(e){
		    	var pos_id = $(this).val();
		    	var main = $(this).parent().parent().attr('id');
		    	$('#'+main).find('#pos_id_hidden').val(pos_id);
		    	var old_pos_id = $('#'+main).find('#pos_id_hidden_old').val();
		    	if(pos_id != old_pos_id){
		    		$('#'+main).find('#need_new_group').prop( "checked", true );
		    	}else{
		    		$('#'+main).find('#need_new_group').prop( "checked", false );
		    	}
		    	// $('#'+main).find('#pos_id_hidden').val(pos_id);
		    	// alert(pos_id);
		    	// alert(main);
		    });
		   

		   // event form add new row
		    $(document).off('click', '.addNewRowNumber').on('click', '.addNewRowNumber', function(e){
		    	var page_id = $(this).attr('page_id');
		    	var page_time = $(this).attr('page_time');
		    	if(page_id != ''){
		    		$.ajax({
			              url: '{{URL::to('/')}}/addnewcolume',
			              type: 'GET',
			              data: {page_id:page_id,page_time:page_time},
			              success: function(data) {
			              	console.log(data);
			                if(data.status=="success"){
			                  	$(".addNewRowNumber").before(data.msg);
			               		if(data.count_page == 8){
			               			$('.addNewRowNumber').hide();
			               		}
			                }else{
			                	$(".staff_charge .alert-danger").show();
			                  	$(".staff_charge .alert-danger").find('span').text(data.msg);
			                	alert();
			                  // callPopupLogin();
			                }        
			              }
			        });
		    	}
		    	
		    });
		    $(document).off('click', '.eventRemoveColume').on('click', '.eventRemoveColume', function(e){
		    	var r = confirm("{{trans('message.are_you_sure')}}");
	    		if (r == true) {
			    	var colume = $(this).attr('colume');
			    	var page = $(this).attr('page');
			    	if(colume != ''){
			    		$.ajax({
				              url: '{{URL::to('/')}}/removecolume',
				              type: 'GET',
				              data: {colume:colume,page:page},
				              success: function(data) {
				              	console.log(data);
				                if(data.status=="success"){
				                  	$("#Remove_"+data.msg).remove();
				                  	if(data.count_page < 8){
				               			$('.addNewRowNumber').show();
				               		}
				                }else{
				                	// $(".staff_charge .alert-danger").show();
				                 //  	$(".staff_charge .alert-danger").find('span').text(data.msg);
				                	alert(data.msg);
				                  // callPopupLogin();
				                }        
				              }
				        });
			    	}
			    }
		    	
		    });

		    // event delete number from row
		    $(document).off('click', '.eventDeletenumberAny').on('click', '.eventDeletenumberAny', function(e){
		    	var r = confirm("{{trans('message.are_you_sure')}}");
	    		if (r == true) {
			    	var this_value = $(this).parent().parent();
			    	var page_id = $(this).parent().attr('page');
			    	var colume_id = $(this).parent().attr('colume');
			    	var number_id = $(this).parent().attr('number');
			    	if(number_id != ''){
			    		$.ajax({
				              url: '{{URL::to('/')}}/deletenumberlottery',
				              type: 'GET',
				              data: {colume_id:colume_id,page_id:page_id,number_id:number_id},
				              success: function(data) {
				                if(data.status=="success"){
				                  	this_value.remove();
				                  	if(data.msg == ''){
				                  		$('#Remove_'+colume_id).find('.pos_style#pos_style_'+data.num_sort).remove();
				                  	}
				                }else{
				                	// $(".staff_charge .alert-danger").show();
				                 //  	$(".staff_charge .alert-danger").find('span').text(data.msg);
				                	alert(data.msg);
				                  // callPopupLogin();
				                }        
				              }
				        });
			    	}
			    }
		    	
		    });

			// event click modify number display popup
			$(document).off('click', '.eventEditnumberAny').on('click', '.eventEditnumberAny', function(e){
				var page_id = $(this).parent().attr('page');
		    	var colume_id = $(this).parent().attr('colume');
		    	var number_id = $(this).parent().attr('number');
		    	// alert("ABC");
		    	// get number by id
		    	$(".row_main").removeClass('backgroundColor');
		    	if(number_id != ''){
		    		$.ajax({
			              url: '{{URL::to('/')}}/getnumberonly',
			              type: 'GET',
			              data: {number_id:number_id},
			              success: function(data) {
			                if(data.status=="success"){
			                	// assign value to text box
			                	$('.view_number_modify').text(data.msg.num_number);

			                	$('#event_add_in_row_modify').find('#pos_id_add').val(data.msg.g_id);
			                	$('#event_add_in_row_modify').find('#pos_id_add').prop( "disabled", true );
			                	$('#event_add_in_row_modify').find('#pos_id_hidden').val(data.msg.g_id);
			                	$('#event_add_in_row_modify').find('#pos_id_hidden_old').val(data.msg.g_id);
			                	$('#event_add_in_row_modify').find('#num_id_hidden').val(data.msg.num_id);
			                	
			                	$('#event_add_in_row_modify').find('#r_id_hidden').val(data.msg.r_id);
			                	$('#event_add_in_row_modify').find('#p_id_hidden').val(page_id);

			                	$('#event_add_in_row_modify').find('#num_number_add').val(data.msg.num_number);
			                	$('#event_add_in_row_modify').find('#sym_id_add').val(data.msg.num_sym);
			                	$('#event_add_in_row_modify').find('#num_number_end_add').val(data.msg.num_end_number);
			                	if(data.msg.num_reverse == 1){
			                		$('#event_add_in_row_modify').find('#num_reverse_add').prop( "checked", true );
			                	}else{
			                		$('#event_add_in_row_modify').find('#num_reverse_add').prop( "checked", false );
			                	}

			                	$('#event_add_in_row_modify').find('#num_amount_add').val(data.msg.num_price);
			                	$('#event_add_in_row_modify').find('#currentcy_add').val(data.msg.num_currency);

			                  	$( "#dialogmodifynumber" ).dialog(
					                    {
					                    width: '500px',
					                    height: 'auto',
					                    position: ['center'],
					                    modal: true,
					                    fluid: true, //new option
					                    resizable: false,
					                    close: function( event, ui ) {
					                      // $(".control_popup_click").hide();
					                    }
					                  }
					            );
			                }else{
			                	
			                	alert(data.msg);
			                }        
			              }
			        });
		    	}
			});

			// update number lottery
			$(document).off('click', '#saveLotteryUpdate').on('click', '#saveLotteryUpdate', function(e){
		  		var main = $(this).parent().parent().attr('id');
		  		
		  		if (validate_form_main('#'+main) == 0) {
		  			var number_id = $("#"+main).find('#num_id_hidden').val();
		  			var pos_id = $('#'+main).find('#pos_id_hidden').val();
		  			if($('#'+main).find('#need_new_group').is(":checked")){
		  				var checkNewGroup = 1;
		  			}else{
		  				var checkNewGroup = 0;
		  			}
		  			var num_start = $('#'+main).find('#num_number_add').val();
		  			var num_end = $('#'+main).find('#num_number_end_add').val();
		  			var sym_id = $('#'+main).find('#sym_id_add').val();
		  			if($('#'+main).find('#num_reverse_add').is(":checked")){
		  				var num_reverse = 1;
		  			}else{0
		  				var num_reverse = 0;
		  			}
		  			var num_amount = $('#'+main).find('#num_amount_add').val();
		  			var num_currency = $('#'+main).find('#currentcy_add').val();
		  			

		  			var colume_id = $('#'+main).find('#r_id_hidden').val();
		  			var page_id = $('#'+main).find('#p_id_hidden').val();

		  			// validate number before insert
		  			var error  = 0;
		  			lengthStr = num_start.length;
		  			if(sym_id == 8 && lengthStr == 2 && num_end != ''){
		  				var oneNumStart = num_start.substring(0, 1);
		  				var twoNumStart = num_start.substring(1, 2);
		  				var oneNumEnd = num_end.substring(0, 1);
		  				var twoNumEnd = num_end.substring(1, 2);
		  				if( (oneNumStart == oneNumEnd) || (twoNumStart == twoNumEnd) ){
		  					if( (oneNumStart == oneNumEnd) && (twoNumStart >= twoNumEnd) ){
		  						var error  = error + 1;
		  					}
		  					if( (twoNumStart == twoNumEnd) && (oneNumStart >= oneNumEnd) ){
		  						var error  = error + 1;
		  					}
		  				}else if( (oneNumStart == twoNumStart) && (oneNumEnd == twoNumEnd) ){

		  				
		  				}else{
		  					var error  = error + 1;
		  				}
		  			}else if(sym_id == 8 && lengthStr == 3 && num_end != ''){

		  				var oneNumStart = num_start.substring(0, 1);
		  				var twoNumStart = num_start.substring(1, 2);
		  				var threeNumStart = num_start.substring(2, 3);

		  				var oneNumEnd = num_end.substring(0, 1);
		  				var twoNumEnd = num_end.substring(1, 2);
		  				var threeNumEnd = num_end.substring(2, 3);

		  				// alert(oneNumStart);
		  				// alert(twoNumStart);
		  				// alert(threeNumStart);

		  				// alert(oneNumEnd);
		  				// alert(twoNumEnd);
		  				// alert(threeNumEnd);

		  				if( ((oneNumStart == oneNumEnd) && (twoNumStart == twoNumEnd)) || ((oneNumStart == oneNumEnd) && (threeNumStart == threeNumEnd)) || ((twoNumStart == twoNumEnd) && (threeNumStart == threeNumEnd)) ){
		  					if( (oneNumStart == oneNumEnd) && (twoNumStart == twoNumEnd) && (threeNumStart >= threeNumEnd) ){
		  						var error  = error + 1;
		  					}
		  					if( (oneNumStart == oneNumEnd) && (threeNumStart == threeNumEnd) && (twoNumStart >= twoNumEnd) ){
		  						var error  = error + 1;
		  					}
		  					if( (twoNumStart == twoNumEnd) && (threeNumStart == threeNumEnd) && (oneNumStart >= oneNumEnd) ){
		  						var error  = error + 1;
		  					}

		  				}else{
		  					var error  = error + 1;
		  				}
		  			}else if(sym_id == 9){
		  				if(num_start > num_end){
		  					var error  = error + 1;
		  				}
		  			}

		  			if(error > 0){
		  				$('#'+main).find('#num_number_end_add').addClass('invalid');
						$('#'+main).find('#num_number_end_add').parent().addClass('state-error');
		  			}else{
		  				$('#'+main).find('#num_number_end_add').removeClass('invalid');
						$('#'+main).find('#num_number_end_add').parent().removeClass('state-error');
		  			}

		  			// check amount with currency
		  			if(num_currency == 1 && num_amount < 100){
		  				var error  = error + 1;
		  				$('#'+main).find('#num_amount_add').addClass('invalid');
						$('#'+main).find('#num_amount_add').parent().addClass('state-error');
		  			}else{
		  				$('#'+main).find('#num_amount_add').removeClass('invalid');
						$('#'+main).find('#num_amount_add').parent().removeClass('state-error');
		  			}


		  			// insert number to db
		  			if(error == 0){
		  				$(".row_main").removeClass('backgroundColor');
		  				$.ajax({
				              url: '{{URL::to('/')}}/updatenumberlottery',
				              type: 'GET',
				              data: {
				              	pos_id:pos_id,checkNewGroup:checkNewGroup,
				              	num_start:num_start,num_end:num_end,
				              	sym_id:sym_id,num_reverse:num_reverse,
				              	num_amount:num_amount,num_currency:num_currency,
				              	colume_id:colume_id,page_id:page_id,
				              	number_id:number_id

				              },
				              success: function(data) {
				              	console.log(data);
				                if(data.status=="success"){
				                  	$("#row_main_"+number_id).html(data.msg);
				                  	$("#row_main_"+number_id).addClass('backgroundColor');
				                  	$( "#dialogmodifynumber" ).dialog( "close" );

				                  	$('#'+main).find('#pos_id_hidden_old').val(pos_id);

				                  	// $('#'+main).find('#need_new_group').prop( "checked", false );
				                  	$('#'+main).find('#num_number_add').val('');
				                  	$('#'+main).find('#num_number_end_add').val('');
				                  	$('#'+main).find('#num_reverse_add').prop( "checked", false );
				                  	$('#'+main).find('#num_amount_add').val('');

				                }else{
				                	
				                	alert(data.msg);
				                  // callPopupLogin();
				                }        
				              }
				        });
		  			}
		  			
		  		}
		  		return false;
		   });
		   




		   var $checkoutForm = $('#checkout-form').validate({
		   // Rules for form validation
		    rules : {
			     s_id : {
			      required : true
			     },
			     p_number : {
			      required : true,
			      number: true
			     },
			     p_time : {
			      required : true
			     },
			     p_date : {
			      required : true
			     }
		    },
		  
		    // Messages for form validation
		    messages : {
			     s_id : {
			      required : 'Please select staff name'
			     },
			     p_number : {
			      required : 'Please enter number paper',
			      number : 'The amount must be a number'
			     },
			     p_time : {
			      required : 'Please select time'
			     },
			     p_date : {
			      required : 'Please enter date'
			     }
			},
		  
		    // Do not change code below
		    errorPlacement : function(error, element) {
		     error.insertAfter(element.parent());
		    }
		   });
		 
		   // START AND FINISH DATE
		   $('#p_date').datepicker({
			    dateFormat : 'yy-mm-dd',
			    prevText : '<i class="fa fa-chevron-left"></i>',
			    nextText : '<i class="fa fa-chevron-right"></i>',
			    // onSelect : function(selectedDate) {
			    //  $('#dob').datepicker('option', 'minDate', selectedDate);
			    // }
			});

		   
		   
		});
	</script>
@stop