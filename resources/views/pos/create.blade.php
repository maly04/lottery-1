@extends('master')

@section('title')
<title>{{trans('label.new_pos')}}</title>
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
			<li>{{trans('label.pos')}}</li><li>{{trans('label.new_pos')}}</li>
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
		        {{trans('label.new_pos')}}
		      </h1>
		     </div>
		</div>

		
    	<section id="widget-grid" class="">
    		@include('flash::message')

		     <?php if($errors->all()){?>
		     <div class="alert alert-block alert-danger">
		      <a class="close" data-dismiss="alert" href="#">×</a>
		      <h4 class="alert-heading"><i class="fa fa-times"></i>{{trans('label.validationAlert')}}</h4>
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
		         <h2>{{trans('label.add_pos')}}</h2>    
		         
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
		             {!! Form::open(['route' => 'pos.store', 'files' => true , 'novalidate' => 'validate', 'id' => 'checkout-form', 'class'=>'smart-form']) !!}                   

		           <fieldset>

			            <div class="row">
				             <section class="col col-6">
					              {{ Form::label('pos_time', trans('label.time'), array('class' => 'label')) }}
					              <label class="select"> <i class="icon-append fa"></i>
				              		{{ Form::select('pos_time',(['' =>$times]) , null, ['class' => 'select2 ','id'=>'pos_time']) }}
				              	  </label>
				             </section>
				             <section class="col col-6">
					              {{ Form::label('pos_name', trans('label.pos_name'), array('class' => 'label')) }}
					              <label class="input"> 
					               {!! Form::text("pos_name", $value = null, $attributes = array('class' => 'form-control', 'id' => 'pos_name', 'placeholder'=>trans('label.pos_name'))) !!}
					              </label>
				             </section>
				        </div>
			        	
			        	<div class="row">
				             <section class="col col-3">
					              {{ Form::label('pos_two_digit', trans('label.number_2_digit'), array('class' => 'label')) }}
					              <label class="input">
					               {!! Form::text("pos_two_digit", $value = null, $attributes = array( 'id' => 'pos_two_digit', 'class' => 'num', 'placeholder'=>trans('label.number_2_digit'))) !!}
					              </label>
				             </section>
				             <section class="col col-3">
					              {{ Form::label('pos_three_digit', trans('label.number_3_digit'), array('class' => 'label')) }}
					              <label class="input">
					               {!! Form::text("pos_three_digit", $value = null, $attributes = array( 'id' => 'pos_three_digit', 'class' => 'num', 'placeholder'=>trans('label.number_3_digit'))) !!}
					              </label>
				             </section>
				             <section class="col col-6">
					              {{ Form::label('pos_info', trans('label.information'), array('class' => 'label')) }}
					              <label class="input">
					               {!! Form::text("pos_info", $value = null, $attributes = array( 'id' => 'pos_info', 'placeholder'=>trans('label.information'))) !!}
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
		      pos_name : {
		      required : true
		     },
		     pos_two_digit : {
		      required : true,
		      number: true
		     },
		     pos_three_digit : {
		      required : true,
		      number: true
		     }
		    },
		  
		    // Messages for form validation
		    messages : {
		     pos_name : {
		      required : "{{trans('validation.custom.pos.name.required')}}"
		     },
		     pos_two_digit : {
		      required : "{{trans('validation.custom.pos.number_2_digit.required')}}",
		      number : "{{trans('validation.custom.pos.number_2_digit.integer')}}"
		     },
		     pos_three_digit : {
		      required : "{{trans('validation.custom.pos.number_3_digit.required')}}",
		      number : "{{trans('validation.custom.pos.number_3_digit.integer')}}"
		     }
		    },
		  
		    // Do not change code below
		    errorPlacement : function(error, element) {
		     error.insertAfter(element.parent());
		    }
		   });
		 
		   // START AND FINISH DATE
		   $('#s_start').datepicker({
			    dateFormat : 'yy-mm-dd',
			    prevText : '<i class="fa fa-chevron-left"></i>',
			    nextText : '<i class="fa fa-chevron-right"></i>',
			    // onSelect : function(selectedDate) {
			    //  $('#dob').datepicker('option', 'minDate', selectedDate);
			    // }
			});
		   $('#s_end').datepicker({
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
		        document.location.href='{{URL::to('/')}}/pos';
		    }
	    }
	</script>
@stop