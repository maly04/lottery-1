@extends('master')

@section('title')
<title>{{trans('label.edit_transaction')}}</title>
@stop

@section('cssStyle')
	<style type="text/css">

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
			<li>{{trans('label.staff_transaction')}}</li><li>{{trans('label.edit_transaction')}}</li>
		</ol>
		<!-- end breadcrumb -->


	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		      <h1 class="page-title txt-color-blueDark">
		       <i class="fa fa-money fa-fw "></i> 
		        {{trans('label.edit_transaction')}}
		      </h1>
		     </div>
		</div>

		
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
		         <h2>{{trans('label.edit_transaction')}}</h2>    
		         
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
		             {!! Form::model($transction, ['route' => ['stafftransction.update', $transction->st_id] ,'method' => 'PATCH',  'class' => 'smart-form user-form', 'novalidate' => 'validate', 'id' => 'checkout-form' ,"autocomplete"=>"false"]) !!}
		           <fieldset>

			            <div class="row">
				             <section class="col col-6">
				              {{ Form::label('s_name', trans('label.staff_name'), array('class' => 'label')) }}
				              <label class="select"><i class="icon-append fa"></i>
				               		{!! Form::select('s_id', (['' => 'Choose']+$staffs) , null,['class' => 'select2 ','id'=>'s_id']) !!}
				              		
				              </label>
				             </section>
				             <section class="col col-4">
				              {{ Form::label('st_price', trans('label.amount'), array('class' => 'label')) }}
				              <label class="input"> <i class="icon-append fa fa-mobile"></i>
				               {!! Form::text("st_price", $value = number_format($transction->st_price), $attributes = array( 'id' => 'st_price', 'class'=>'form-control num')) !!}
				              </label>
				             </section>
				             <section class="col col-2">
				              		{{ Form::label('st_currency', trans('label.currency'), array('class' => 'label')) }}
					              	<label class="select"> <i class="icon-append fa"></i>
					              		{{ Form::select('st_currency', (['' =>$getCurrencys]) , null,['class' => 'select2 ','id'=>'st_currency']) }}
					              	</label>
				             </section>
				        </div>
			        	<div class="row">
				             
				             <section class="col col-6">
				              		{{ Form::label('st_type', trans('label.type'), array('class' => 'label')) }}
					              	<label class="select"> <i class="icon-append fa"></i>
					              		{{ Form::select('st_type', (['' =>$getTypes]) , null,['class' => 'select2 ','id'=>'st_type']) }}
					              	</label>
				             </section>
				             <section class="col col-6">
					              {{ Form::label('st_date_diposit', trans('label.date_deposit'), array('class' => 'label')) }}
					              <label class="input"> <i class="icon-append fa fa-calendar"></i>
					               {!! Form::text("st_date_diposit", $value = null, $attributes = array( 'id' => 'st_date_diposit', 'placeholder'=>'YYYY-MM--DD')) !!}
					              </label>
				             </section>
			            </div>
			            <div class="row">
				             <section class="col col-6">
				              		{{ Form::label('st_remark', trans('label.remark'), array('class' => 'label')) }}
				              <label class="textarea"> <i class="icon-append fa fa-comment"></i>
				               {!! Form::textarea("st_remark", $value = null, $attributes = array( 'id' => 'st_remark', 'class'=>'form-control', 'rows' => "4")) !!}
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

		   var $checkoutForm = $('#checkout-form').validate({
		   // Rules for form validation
		    rules : {
			     s_id : {
			      required : true
			     },
			     st_price : {
			      required : true,
			      number: true
			     },
			     st_date_diposit : {
			      required : true
			     }
		    },
		  
		    // Messages for form validation
		    messages : {
			     s_id : {
			      required : "{{trans('validation.custom.required.choose_staff_name')}}"
			     },
			     st_price : {
			      required : "{{trans('validation.custom.required.amount')}}",
			      number : "{{trans('validation.custom.required.amount_number')}}"
			     },
			     st_date_diposit : {
			      required : "{{trans('validation.custom.required.date_deposit')}}"
			     }
			},
		  
		    // Do not change code below
		    errorPlacement : function(error, element) {
		     error.insertAfter(element.parent());
		    }
		   });
		 
		   // START AND FINISH DATE
		   $('#st_date_diposit').datepicker({
			    dateFormat : 'yy-mm-dd',
			    prevText : '<i class="fa fa-chevron-left"></i>',
			    nextText : '<i class="fa fa-chevron-right"></i>',
			    // onSelect : function(selectedDate) {
			    //  $('#dob').datepicker('option', 'minDate', selectedDate);
			    // }
			});

		   $("#st_price").keyup(function(e){
		   		$(this).val(currencyFormat($(this).val()));
		   });
		   
		});

		function btnCancel(){
	   		var r = confirm("តើលោកអ្នកចង់ត្រលប់ក្រោយឬទេ?");
		    if (r == true) {
		        document.location.href='{{URL::to('/')}}/stafftransction';
		    }
	   }
	</script>
@stop