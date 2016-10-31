@extends('master')

@section('title')
<title>{{trans('label.addStaff')}}</title>
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
			<li>{{trans('label.staff')}}</li><li>{{trans('label.addStaff')}}</li>
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
		        {{trans('label.addStaff')}}
		      </h1>
		     </div>
		</div>

		
    	<section id="widget-grid" class="">
    		@include('flash::message')

		     <?php if($errors->all()){?>
		     <div class="alert alert-block alert-danger">
		      <a class="close" data-dismiss="alert" href="#">×</a>
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
		         <h2>{{trans('label.addStaff')}}</h2>    
		         
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
		             {!! Form::open(['route' => 'staff.store', 'files' => true , 'novalidate' => 'validate', 'id' => 'checkout-form', 'class'=>'smart-form']) !!}                   

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
				               {!! Form::text("s_info", $value = null, $attributes = array('class' => 'form-control', 'id' => 's_info', 'placeholder'=>trans('label.detailOfStaff'))) !!}
				              </label>
				             </section>
			            </div>
			        	<div class="row">
				             <section class="col col-3">
					              {{ Form::label('s_start', trans('label.startDate'), array('class' => 'label')) }}
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
		});
		function btnCancel(){
	   		var r = confirm("តើលោកអ្នកចង់ត្រលប់ក្រោយឬទេ?");
		    if (r == true) {
		        document.location.href='{{URL::to('/')}}/staff';
		    }
	    }
	</script>
@stop