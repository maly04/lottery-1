@extends('master')

@section('title')
<title>{{trans('label.edit_user')}}</title>
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
			<li>អ្នកប្រើប្រាស់</li><li>{{trans('label.edit_user')}}</li>
		</ol>
		<!-- end breadcrumb -->


	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		      <h1 class="page-title txt-color-blueDark">
		       <i class="fa fa-user fa-fw "></i> 
		         
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
		         <h2>{{trans('label.edit_user')}}</h2>    
		         
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
		             {!! Form::model($user, ['route' => ['user.update', $user->u_id] ,'method' => 'PATCH',  'class' => 'smart-form user-form', 'novalidate' => 'validate', 'id' => 'checkout-form' ,"autocomplete"=>"false"]) !!}
		           <fieldset>

			            <div class="row">
			             <section class="col col-6">
			              {{ Form::label('u_name', 'ឈ្មោះ', array('class' => 'label')) }}
			              <label class="input">
			               {!! Form::text("u_name", $value = null, $attributes = array( 'id' => 'u_name', 'placeholder'=>'Name')) !!}
			              </label>
			             </section>


			             <section class="col col-6">
			              {{ Form::label('u_phone', 'លេខទូរស័ព្ទ', array('class' => 'label')) }}
			              <label class="input"> <i class="icon-append fa fa-envelope-o"></i>
			               {!! Form::text("u_phone", $value = null, $attributes = array('class' => 'form-control', 'id' => 'u_phone', 'placeholder'=>'xxx-xxx-xxxx', 'data-mask'=>'(999) 999-9999')) !!}
			              </label>
			             </section>

			            </div>


			            <div class="row">
			             
				             <section class="col col-6">
				              {{ Form::label('u_line', 'ID គណនីសង្គមLine', array('class' => 'label')) }}
				              <label class="input"> 
				               {!! Form::text("u_line", $value = null, $attributes = array( 'id' => 'u_line', 'placeholder'=>'Line ID')) !!}
				              </label>
				             </section>
			             
			            </div>
					
		           	</fieldset>
		            <fieldset>
		            	<legend>{{trans('label.user_register')}}</legend>
			            <div class="row">
			             <section class="col col-6">
			              {{ Form::label('role', trans('label.type_user'), array('class' => 'label')) }}
			              <label class="select">                              
			               <select name="role" id="role" class="form-control input-sm require"> 
			                                
			                <option value="1">Admin</option>
			                <option value="0">Normal</option>                            
			              
			               </select>
			              </label>
			             </section>
		             
		            	</div>
			            <div class="row">
			             <section class="col col-6">
			              {{ Form::label('u_username', 'ឈ្មោះអ្នកប្រើប្រាស់', array('class' => 'label')) }}
			              <label class="input"> <i class="icon-append fa fa-user"></i>
			               {!! Form::text("u_username", $value = null, $attributes = array('class' => 'form-control', 'id' => 'u_username', 'placeholder'=>'Username')) !!}
			              </label>
			             </section>
			             <section class="col col-6">
			              {{ Form::label('new_password', 'លេខសម្ងាត់ថ្មី', array('class' => 'label')) }}
			              <label class="input"> <i class="icon-append fa fa-lock"></i>
			               {!! Form::text("new_password", null, $attributes = array('class' => 'form-control', 'id' => 'new_password', 'placeholder'=>'Password','autocomplete'=>'off')) !!}
			              </label>
			             </section>
			            </div>

		           </fieldset>


		           <footer>
		             <button type="submit" name="submit" class="btn btn-primary">រក្សាទុក</button>  
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
	<script type="text/javascript">
		$(document).ready(function() {

		   pageSetUp();

		   var $checkoutForm = $('#checkout-form').validate({
		   // Rules for form validation
		    rules : {
		     
		     u_name : {
		      required : true
		     },
		     u_phone : {
		      required : true
		     },
		     u_username : {
		      required : true
		     },
		     u_password : {
		      required : true,
		      minlength : 6,
		      maxlength : 15
		     }
		    },
		  
		    // Messages for form validation
		    messages : {
		     u_name : {
		      required : 'Please enter your name'
		     },
		     u_phone : {
		      required : 'Please enter your phone number'
		     },
		     u_username : {
		      required : 'Please enter your username'
		     },
		     u_password : {
		      required : 'Please enter your password'
		     }
		    },
		  
		    // Do not change code below
		    errorPlacement : function(error, element) {
		     error.insertAfter(element.parent());
		    }
		   });
		 
		   // START AND FINISH DATE
		   $('#dob').datepicker({
		    dateFormat : 'yy-mm-dd',
		    prevText : '<i class="fa fa-chevron-left"></i>',
		    nextText : '<i class="fa fa-chevron-right"></i>',
		    // onSelect : function(selectedDate) {
		    //  $('#dob').datepicker('option', 'minDate', selectedDate);
		    // }
		   });

		   // alert("ok");
   		//   $('input[type="password"]').val('');
		});
		function btnCancel(){
	   		var r = confirm("តើលោកអ្នកចង់ត្រលប់ក្រោយឬទេ?");
		    if (r == true) {
		        document.location.href='{{URL::to('/')}}/user';
		    }
	   }
	</script>
@stop