@extends('master')

@section('title')
<title>{{ trans('label.add_paper') }}</title>
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
			<li>{{ trans('label.sale') }}</li><li>{{ trans('label.add_paper') }}</li>
		</ol>
		<!-- end breadcrumb -->


	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		      <h1 class="page-title txt-color-blueDark">
		       <i class="fa fa-sort-numeric-asc fa-fw "></i> 
		        {{ trans('label.add_paper') }}
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
		         <h2>{{ trans('label.new_paper') }}</h2>    
		         
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
		             {!! Form::open(['route' => 'sale.store', 'files' => true , 'novalidate' => 'validate', 'id' => 'checkout-form', 'class'=>'smart-form']) !!}                   

		           <fieldset>

			            <div class="row">
				             <section class="col col-6">
				              {{ Form::label('s_id', trans('label.staff_name'), array('class' => 'label')) }}
				              <label class="select"><i class="icon-append fa"></i>
				               		{!! Form::select('s_id', (['' => 'Choose']+$staffs) , null,['class' => 'select2 ','id'=>'s_id']) !!}
				              		
				              </label>
				             </section>
				             <section class="col col-4">
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
				        </div>
			        	<div class="row">
				             
				             <section class="col col-6">
				              		{{ Form::label('p_time', trans('label.time'), array('class' => 'label')) }}
					              	<label class="select"> <i class="icon-append fa"></i>
					              		{!! Form::select('p_time', (['' => 'Choose']+$times) , null,['class' => ' ','id'=>'p_time']) !!}
					              	</label>
				             </section>
				             <section class="col col-6">
					              {{ Form::label('p_date', trans('label.date'), array('class' => 'label')) }}
					              <label class="input"> <i class="icon-append fa fa-calendar"></i>
					               {!! Form::text("p_date", date('Y-m-d'), $attributes = array( 'id' => 'p_date', 'placeholder'=>'YYYY-MM--DD')) !!}
					              </label>
				             </section>
			            </div>


			           
					
		           	</fieldset>
		           

		           <footer>
		            <button type="submit" name="submit" class="btn btn-primary">{{trans('label.save')}}</button>                        
		           </footer>

		           
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