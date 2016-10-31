@extends('master')

@section('title')
<title>Edit Pos Group</title>
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
			<li>{{trans('label.group')}}</li><li>{{trans('label.edit_pos_group')}}</li>
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
		        {{trans('label.edit_pos_group')}}
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
		         <h2>{{trans('label.edit_pos_group')}}</h2>    
		         
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
		             {!! Form::model($posGoup, ['route' => ['posgroup.update', $posGoup->g_id] ,'method' => 'PATCH',  'class' => 'smart-form user-form', 'novalidate' => 'validate', 'id' => 'checkout-form' ,"autocomplete"=>"false"]) !!} 
		           <fieldset>
			            <div class="row">
				             <section class="col col-6">
				              {{ Form::label('g_id', trans('label.group_name'), array('class' => 'label')) }}
				              <label class="select"><i class="icon-append fa"></i>
				               		{!! Form::select('g_id', (['' => 'Choose']+$listGroup) , null,['class' => 'select2 ','id'=>'g_id',' disabled']) !!}
				               		{{ Form::hidden('g_id', null) }}
				              </label>
				             </section>
				             <section class="col col-6">
					              {{ Form::label('pos_time', trans('label.time'), array('class' => 'label')) }}
					              <label class="select"> <i class="icon-append fa"></i>
				              		{{ Form::select('pos_time',(['' =>$times]) , $timeID, ['class' => 'select2 request-pos','id'=>'pos_time', ' disabled']) }}
				              		{{ Form::hidden('pos_time', $timeID) }}
				              	  </label>
				             </section>
				        </div>
			        	
			        	
		           	</fieldset>
		           	<fieldset>
							<section>
								<label class="label">{{trans('label.choose_pos')}}: </label>
								<div class="list-poss">
									<div class="row" >
									<?php $q=0; ?>
									@foreach($listPoss as $keyPos => $listPos)
										<?php $q++; ?>
										@if($q%3 != 0)
											<div class="col col-4">
												<label class="checkbox">
													<input type="checkbox" name="pos_id[]" value="{{$keyPos}}" @if(isset($posCheckeds[$keyPos])) checked @endif>
													<i></i>{{$listPos}}</label>
											</div>
										@else
											<div class="col col-4">
												<label class="checkbox">
													<input type="checkbox" name="pos_id[]" value="{{$keyPos}}" @if(isset($posCheckeds[$keyPos])) checked @endif>
													<i></i>{{$listPos}}</label>
											</div>
										</div>
										<div class="row">
										@endif
									@endforeach
									</div>
								</div>
								<div class="note note-error">{{trans('message.must_be_select')}}</div>
							</section>
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
		      'pos_id' : {
		      required : true
		     },
		     g_id : {
		      required : true,
		     }
		    },
		  
		    // Messages for form validation
		    messages : {
		     'pos_id' : {
		      required : "{{trans('validation.custom.group.name.required')}}"
		     },
		     g_id : {
		      required : "{{trans('validation.custom.group.name.required')}}",
		     },
		    },
		  
		    // Do not change code below
		    errorPlacement : function(error, element) {
		     error.insertAfter(element.parent());
		    }
		   });

		$(document).off('change', '.request-pos').on('change', '.request-pos', function(e){
			var id = $(this).val();
			var posGroupID = $('#g_id').val();
    			$.ajax({
		              url: '{{action("PosGroupController@requestPos", [])}}',
		              type: 'GET',
		              data: {pos_time:id,g_id:posGroupID},
		              success: function(data) {
		                if(data.status=="success"){
		                  $('.list-poss').html(data.msg);
		                }else{
		                  $('.list-poss').html(data.msg);
		                }        
		              }
		        });
		});

	});
	function btnCancel(){
   		var r = confirm("តើលោកអ្នកចង់ត្រលប់ក្រោយឬទេ?");
	    if (r == true) {
	        document.location.href='{{URL::to('/')}}/posgroup';
	    }
   }
</script>
@stop