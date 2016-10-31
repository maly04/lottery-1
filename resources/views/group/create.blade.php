@extends('master')

@section('title')
<title>{{trans('label.create_group')}}</title>
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
			<li>{{trans('label.group')}}</li><li>{{trans('label.new_group')}}</li>
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
		        {{trans('label.new_group')}}
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
		         <h2>{{trans('label.new_group')}}</h2>    
		         
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
		             {!! Form::open(['route' => 'group.store', 'files' => true , 'novalidate' => 'validate', 'id' => 'checkout-form', 'class'=>'smart-form']) !!}                   

		           <fieldset>
			        	<div class="row">
				             <section class="col col-6">
					              {{ Form::label('g_name', trans('label.group_name'), array('class' => 'label')) }}
					              <label class="input">
					               {!! Form::text("g_name", $value = null, $attributes = array( 'id' => 'g_name', 'placeholder'=>trans('label.group_name'))) !!}
					              </label>
				             </section>
				             <section class="col col-6">
					              {{ Form::label('g_info', trans('label.information'), array('class' => 'label')) }}
					              <label class="input">
					               {!! Form::text("g_info", $value = null, $attributes = array( 'id' => 'g_info', 'placeholder'=>trans('label.information'))) !!}
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
		     g_name : {
		      required : true
		     },
		     g_info : {
		      required : true
		     }
		    },
		  
		    // Messages for form validation
		    messages : {
		     g_name : {
		      required : "{{trans('validation.custom.group.name.required')}}"
		     },
		     g_info : {
		      required : "{{trans('validation.custom.group.info.required')}}"
		     },
		    },
		  
		    // Do not change code below
		    errorPlacement : function(error, element) {
		     error.insertAfter(element.parent());
		    }
		   });

		});

		function btnCancel(){
	   		var r = confirm("តើលោកអ្នកចង់ត្រលប់ក្រោយឬទេ?");
		    if (r == true) {
		        document.location.href='{{URL::to('/')}}/group';
		    }
	    }
	</script>
@stop