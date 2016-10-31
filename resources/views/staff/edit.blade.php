@extends('master')

@section('title')
<title>{{trans('label.editStaff')}}</title>
@stop

@section('cssStyle')
	<style type="text/css">
		.form_add input{
			padding: 5px;
		}
		.show_input_add{
			display: none;
		}
		.staff_charge .alert-success,.staff_charge .alert-danger{
			display: none;
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
			<li>{{trans('label.staff')}}</li><li>{{trans('label.editStaff')}}</li>
		</ol>
		<!-- end breadcrumb -->


	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		      <h1 class="page-title txt-color-blueDark">
		       <i class="fa fa-users fa-fw "></i> 
		        {{trans('label.editStaff')}}
		      </h1>
		     </div>
		</div>

		
    	<section id="widget-grid" class="">
    		@include('flash::message')

		     <?php if($errors->all()){?>
		     <div class="alert alert-block alert-danger">
		      <a class="close" data-dismiss="alert" aria-label="Close" href="#">×</a>
		      <h4 class="alert-heading"><i class="fa fa-times"></i> {{ trans('label.validationAlert') }}</h4>
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
		         <h2>{{trans('label.editStaff')}}</h2>    
		         
		        </header>

		        <!-- widget div-->
		        <div>
		         
		         <!-- widget edit box -->
		         <div class="jarviswidget-editbox">
		          <!-- This area used as dropdown edit box -->
		          
		         </div>
		         <!-- end widget edit box -->
		         
		         <!-- widget content -->
		         <div class="widget-body no-padding">            
		              {!! Form::model($staff, ['route' => ['staff.update', $staff->s_id] ,'method' => 'PATCH',  'class' => 'smart-form user-form', 'novalidate' => 'validate', 'id' => 'checkout-form' ,"autocomplete"=>"false"]) !!}
		           <fieldset>

			            <div class="row">
				             <section class="col col-6">
				              {{ Form::label('s_name', trans('label.name'), array('class' => 'label')) }}
				              <label class="input">
				               {!! Form::text("s_name", $value = null, $attributes = array( 'id' => 's_name', 'placeholder'=>trans('label.name'))) !!}
				              </label>
				             </section>
				             <section class="col col-6">
				              {{ Form::label('s_phone', trans('label.phone'), array('class' => 'label')) }}
				              <label class="input"> <i class="icon-append fa fa-mobile"></i>
				               {!! Form::text("s_phone", $value = null, $attributes = array('class' => 'form-control', 'id' => 's_phone', 'placeholder'=>'xxx-xxx-xxxx', 'data-mask'=>'(999) 999-999?9')) !!}
				              </label>
				             </section>
				        </div>
			        	<div class="row">
				             <section class="col col-6">
				              {{ Form::label('s_line', trans('label.line'), array('class' => 'label')) }}
				              <label class="input"> 
				               {!! Form::text("s_line", $value = null, $attributes = array('class' => 'form-control', 'id' => 's_line', 'placeholder'=>trans('label.lineId'))) !!}
				              </label>
				             </section>
				             <section class="col col-6">
				              {{ Form::label('s_fb', trans('label.facebook'), array('class' => 'label')) }}
				              <label class="input"> 
				               {!! Form::text("s_fb", $value = null, $attributes = array('class' => 'form-control', 'id' => 's_fb', 'placeholder'=>trans('label.facebookName'))) !!}
				              </label>
				             </section>
			            </div>
			        	<div class="row">
				             <section class="col col-6">
				              {{ Form::label('s_address', trans('label.address'), array('class' => 'label')) }}
				              <label class="input"> 
				               {!! Form::text("s_address", $value = null, $attributes = array('class' => 'form-control', 'id' => 's_address', 'placeholder'=>trans('label.address'))) !!}
				              </label>
				             </section>
				             <section class="col col-6">
				              {{ Form::label('s_info', trans('label.detail'), array('class' => 'label')) }}
				              <label class="input"> <i class="icon-append fa fa-info"></i>
				               {!! Form::text("s_info", $value = null, $attributes = array('class' => 'form-control', 'id' => 's_info', 'placeholder'=> trans('label.detailOfStaff') )) !!}
				              </label>
				             </section>
			            </div>
			        	<div class="row">
				             <section class="col col-3">
					              {{ Form::label('s_start', trans('label.startDate') , array('class' => 'label')) }}
					              <label class="input"> <i class="icon-append fa fa-calendar"></i>
					               {!! Form::text("s_start", $value = null, $attributes = array( 'id' => 's_start', 'placeholder'=>'YYYY-MM--DD')) !!}
					              </label>
				             </section>
				             <section class="col col-3">
					              {{ Form::label('s_end', trans('label.endDate'), array('class' => 'label')) }}
					              <label class="input"> <i class="icon-append fa fa-calendar"></i>
					               {!! Form::text("s_end", $value = null, $attributes = array( 'id' => 's_end', 'placeholder'=>'YYYY-MM--DD')) !!}
					              </label>
				             </section>
			            </div>
		           	</fieldset>
		           <footer>
		            <button type="submit" name="submit" class="btn btn-primary">{{trans('label.save')}}</button>   
		            <button type="button" class="btn btn-warning" onclick="btnCancel()">{{trans('label.cancel')}}</button>          
		           </footer>

		           <div class="message">
		            <i class="fa fa-check fa-lg"></i>
		            <p>
		             Your comment was successfully added!
		            </p>
		           </div>
		          {{ Form::close() }}
		          
		         </div>
		         <!-- end widget content -->
		         
		        </div>
		        <!-- end widget div -->
		        
		       </div>
		       <!-- end widget -->
		    
		      </article>
		      <!-- WIDGET END -->

		      <article class="col-sm-12 col-md-12 col-lg-12">
		      	
			       	<!-- Widget ID (each widget will need unique ID)-->
			       	<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-18" data-widget-editbutton="false">        
				        <header>
				         <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
				         <h2>{{ trans('label.staffCharge') }}</h2>    
				        </header>
				        <div class="staff_charge">
				        	<div class="alert alert-success " style="margin-top:10px;">
				               <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
				               <span aria-hidden="true"></span>
				           </div>
				           <div class="alert alert-danger "  style="margin-top:10px;">
				               <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
				               <span aria-hidden="true"></span>
				           </div>
					        <div class="widget-body no-padding">          
					          	<table id="datatable_tabletools" class="table table-striped table-bordered table-hover" width="100%">
					           
						           <thead>           
							            <tr>
								             <th>{{ trans('label.id') }}</th>
								             <th>{{ trans('label.date') }}</th>
								             <th>{{ trans('label.priceFor2Digits') }}</th>
								             <th>{{ trans('label.priceFor3Digits') }}</th>
								             <th>{{ trans('label.action') }}</th>
							            </tr>
						           </thead>
						           <tbody>
						           		
						           		<tr class="form_add smart-form">
								             <td><button id="btn_add_staff_charge" class="padding-button btn btn-xs btn-primary">{{ trans('label.add') }}</button></td>
								            
								             <td class="show_input_add">
								             	<label class="input">
								             		{!! Form::text("stc_date_add", $value = null, $attributes = array( 'id' => 'stc_date_add', 'placeholder'=>'YYYY-MM--DD', 'class'=>'required', 'sms'=>'សូមបញ្ចូលកាលបរិច្ឆេទ')) !!} 
								             	</label>
								             </td>
								             <td class="show_input_add">
								             	<label class="input">
								             		{!! Form::text("stc_two_digit_charge_add", $value = null, $attributes = array( 'id' => 'stc_two_digit_charge_add','class'=>'required num', 'placeholder'=>trans('label.priceFor2Digits'),'sms'=>trans('validation.custom.required.price2digits'), 'number'=>'true','data-mask'=>'9?9')) !!}</td>
								             	</label>
								             <td class="show_input_add">
								             	<label class="input">
								             		{!! Form::text("stc_three_digit_charge_add", $value = null, $attributes = array( 'id' => 'stc_three_digit_charge_add','class'=>'required num', 'placeholder'=>trans('label.priceFor3Digits') ,'sms'=>trans('validation.custom.required.price3digits'), 'number'=>'true','data-mask'=>'9?9')) !!}</td>
								             	</label>

								             <td class="show_input_add">
								             	<button id="btn_new_staff_charge" type="add" idData='' class="padding-button btn btn-xs btn-success">{{trans('label.save')}}</button>
								             </td>
								       	</tr>
								       

						           	<?php $i=0;?>
			           				@foreach($staff_charges as $staff_charge)
			           					<?php $i++;?>
							            <tr class="staff_charge-{{$staff_charge->stc_id}}">
								             <td>{{$i}}</td>
								             <td>{{$staff_charge->stc_date}}</td>
								             <td>{{$staff_charge->stc_two_digit_charge}}</td>
								             <td>{{$staff_charge->stc_three_digit_charge}}</td>
								             <td>
								             	<button id="{{$staff_charge->stc_id}}" class="padding-button EditStaffCharge btn btn-xs btn-primary">{{ trans('label.edit') }}</button>
								             	<button id="{{$staff_charge->stc_id}}" class="padding-button deleteStaffCharge btn btn-xs btn-danger">{{ trans('label.delete') }}</button>
								             </td>
								       	</tr>        
						            @endforeach 
						           </tbody>
					          	</table>
					    
					         </div>
					    </div>
					</div>
		     </article>
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
	
		function validate_form_main(class_div){
			var num = 0;
			$(class_div + " .required").each(function(index, element) {
	          var id, info, value, number;
	          value = $(element).val();
	          id = $(element).attr('id');
	          number = $(element).attr('number');
	          info = $(element).attr('sms');

	          pattern_number = /^\d+$/;

	          // alert(id);
	          if (value === '') { //check value empty
	          	validate_by_vannarith(id,info,'add');
	          	num = num + 1;
	          }else if(number === 'true' && !pattern_number.test(value)){ //check value number only
	          	 validate_by_vannarith(id,'សូមបញ្ចូលតំលៃជាលេខ','add');
	          		num = num + 1;
	          }else{ //else value good data
	          	validate_by_vannarith(id,'','remove');
	          }
	        });
	        return num;
		}


		$(document).ready(function() {
		   pageSetUp();

		   var $checkoutForm = $('#checkout-form').validate({
		   // Rules for form validation
		    rules : {
		     
		     s_name : {
		      required : true
		     },
		     s_phone : {
		      required : true
		     },
		     s_start : {
		      required : true
		     }
		    },
		  
		    // Messages for form validation
		    messages : {
		     s_name : {
		      required : 'សូមបញ្ចូលឈ្មោះថ្មី'
		     },
		     s_phone : {
		      required : 'សូមបញ្ចូលលេខទូរស័ព្ទ'
		     },
		     s_start : {
		      required : 'សូមបញ្ចូលកាលបរិច្ឆេទចាប់ផ្តើម'
		     }
		    },
		  
		    // Do not change code below
		    errorPlacement : function(error, element) {
		     error.insertAfter(element.parent());
		    }
		   });

		   
		   // btn controll show hide form insert data
		   $(document).off('click', '#btn_add_staff_charge').on('click', '#btn_add_staff_charge', function(e){
				
				if($('.show_input_add').css('display') == 'none'){
					$('#stc_date_add').val('');
					$('#stc_two_digit_charge_add').val('');
					$('#stc_three_digit_charge_add').val('');
					$('.show_input_add').show();
					$("#btn_new_staff_charge").attr( "type", "add" );
					$("#btn_new_staff_charge").attr( "idData", '' );
					$(this).text("{{ trans('label.delete') }}");
					$('#stc_currency_add').val($('#stc_currency_add option:first-child').val()).trigger('change');
				}else{
					$('#stc_date_add').val('');
					$('#stc_two_digit_charge_add').val('');
					$('#stc_three_digit_charge_add').val('');
					$('.show_input_add').hide();
					$(this).text("{{ trans('label.add') }}");
				}

			});

		   // insert data to database
		   $(document).off('click', '#btn_new_staff_charge').on('click', '#btn_new_staff_charge', function(e){
				$(".staff_charge .alert-success").hide();
				$(".staff_charge .alert-danger").hide();
				if(validate_form_main('.form_add') == 0){
					var stc_date_add = $("#stc_date_add").val();
					var stc_two_digit_charge_add = $("#stc_two_digit_charge_add").val();
					var stc_three_digit_charge_add = $("#stc_three_digit_charge_add").val();
					
					// var checkCurrency = $("#stc_currency_add").select2('val');
					// var new_currency = $("#stc_currency_add option:first-child").attr('value');
					// var stc_currency_add = 0;
					// //check first select option of currency
					// if(checkCurrency == null){
					// 	stc_currency_add = new_currency;
					// }else{
					// 	stc_currency_add = checkCurrency;
					// }

					var staff_id = '{{ $staff->s_id }}';
					var checkType = $(this).attr('type');
					var iddata = $(this).attr('iddata');
					var idDataTable = $('#datatable_tabletools .staff_charge-'+iddata+' > td:nth-child(1)').text();
					$.ajax({
			              url: '{{URL::to('/')}}/storeCharge',
			              type: 'GET',
			              data: {stc_date_add:stc_date_add,
			              		 stc_two_digit_charge_add:stc_two_digit_charge_add,
			              		 stc_three_digit_charge_add:stc_three_digit_charge_add,
			              		 staff_id:staff_id,
			              		 checkType:checkType,
			              		 iddata:iddata,
			              		 idDataTable:idDataTable
			              		},
			              success: function(data) {
			                if(data.status=="success"){
			                  $('tr.form_add.smart-form').after(data.msg);
			                  $(".staff_charge .alert-success").show();
			                  $(".staff_charge .alert-success").find('span').text("{{trans('message.add_success')}}");
			                  $(".staff_charge input").val("");
			                  $("#btn_add_staff_charge").text("{{trans('label.delete')}}");
			                  $("#btn_new_staff_charge").attr('type','add').attr('iddata');
			                }else if(data.status=="updatesuccess"){
			                	$(".staff_charge .alert-success").show();
			                  	$(".staff_charge .alert-success").find('span').text("{{trans('message.update_success')}}");
			                  	$(".staff_charge input").val("");
			                  	$(".staff_charge-"+iddata).html(data.msg);
			                  	$("#btn_add_staff_charge").text("{{trans('label.delete')}}");
			                  	$("#btn_new_staff_charge").attr('type','add').attr('iddata','');
			                }else{
			                	$(".staff_charge .alert-danger").show();
			                  	$(".staff_charge .alert-danger").find('span').text(data.msg);
			                	// alert();
			                  // callPopupLogin();
			                }        
			              }
			        });
				}
				
			});

			$(document).off('click', '.EditStaffCharge').on('click', '.EditStaffCharge', function(e){
				var id = $(this).attr('id');
				$.ajax({
		              url: '{{URL::to('/')}}/getCharge',
		              type: 'GET',
		              data: {id:id},
		              success: function(data) {
		                if(data.status=="success"){

		                	$("#btn_add_staff_charge").text("{{trans('label.delete')}}");
		                	$("#stc_date_add").val(data.msg.stc_date);
							$("#stc_two_digit_charge_add").val(data.msg.stc_two_digit_charge);
							$("#stc_three_digit_charge_add").val(data.msg.stc_three_digit_charge);
							$("#stc_currency_add").val(data.msg.stc_currency).trigger("change");
							$('.show_input_add').show();
							$("#btn_new_staff_charge").attr( "type", "modify" );
							$("#btn_new_staff_charge").attr( "idData", data.msg.stc_id );
							
		                }else{
		                	$("#btn_add_staff_charge").text("{{trans('label.delete')}}");
		                	$("#btn_new_staff_charge").attr( "type", "add" );
		                	$("#btn_new_staff_charge").attr( "idData", '' );
		                	$('.show_input_add').hide();
		                  // callPopupLogin();
		                }        
		              }
		        });
			});

			$(document).off('click', '.deleteStaffCharge').on('click', '.deleteStaffCharge', function(e){
				
				var r = confirm("តើអ្នកចង់លុបវាឬទេ?");
	    		if (r == true) {
	    			var id = $(this).attr('id');
	    			$.ajax({
			              url: '{{action("StaffController@deleteStaffCharge",[""])}}',
			              type: 'GET',
			              data: {id:id},
			              success: function(data) {
			                if(data.status=="success"){
			                  $(".staff_charge-"+id).remove();
			                }else{
			                	alert(data.msg);
			                }        
			              }
			        });
	    		}
			});
		   

		 
		   // START AND FINISH DATE
		   $('#s_start').datepicker({
			    dateFormat : 'yy-mm-dd',
			    prevText : '<i class="fa fa-chevron-left"></i>',
			    nextText : '<i class="fa fa-chevron-right"></i>',
			    onSelect : function(selectedDate) {
			     $('#s_end').datepicker('option', 'minDate', selectedDate);
			    }
			});

		   $('#s_end').datepicker({
			    dateFormat : 'yy-mm-dd',
			    prevText : '<i class="fa fa-chevron-left"></i>',
			    nextText : '<i class="fa fa-chevron-right"></i>',
			    onSelect : function(selectedDate) {
			     $('#s_start').datepicker('option', 'minDate', selectedDate);
			    }
			});

		   $('#stc_date_add').datepicker({
			    dateFormat : 'yy-mm-dd',
			    prevText : '<i class="fa fa-chevron-left"></i>',
			    nextText : '<i class="fa fa-chevron-right"></i>',
			    // onSelect : function(selectedDate) {
			    //  $('#dob').datepicker('option', 'minDate', selectedDate);
			    // }
			});
		});
		function btnCancel(){
	   		var r = confirm("តើលោកអ្នកចង់ត្រលប់ក្រោយឬទេ?");
		    if (r == true) {
		        document.location.href='{{URL::to('/')}}/staff';
		    }
	    }
	</script>
@stop