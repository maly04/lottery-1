@extends('master')

@section('title')
<title>បុគ្គលិក</title>
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
			<li>បុគ្គលិក</li>
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
		        បញ្ជីបុគ្គលិក
		      </h1>
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
		         <h2>បញ្ជីបុគ្គលិក</h2>
		        </header>
		    
		        <!-- widget div-->
		        <div>
		    
		         <!-- widget content -->
		         <div class="widget-body no-padding">          
		          <table id="datatable_tabletools" class="table table-striped table-bordered table-hover" width="100%">
		           
		           <thead>           
			            <tr>
				             <th>{{trans('label.id')}}</th>
				             <th>{{trans('label.name')}}</th>
				             <th>{{trans('label.startDate')}}</th>
				             <th>{{trans('label.endDate')}}</th>
				             <th class="desktopOnly">{{trans('label.phone')}}</th>
				             <th class="desktopOnly">{{trans('label.line')}}</th>
				             <th class="desktopOnly">{{trans('label.facebook')}}</th>
				             <th class="desktopOnly">{{trans('label.address')}}</th>
				             <th class="desktopOnly">{{trans('label.detail')}}</th>
				             <th>{{trans('label.action')}}</th>
			            </tr>
		           </thead>
		           <tbody>
			           <?php $i=0;?>
			           @foreach($staffs as $staff)
			           		<?php $i++;?>
				            <tr class="staff-{{$staff->s_id}}">
				             <td>{{$i}}</td>
				             <td>{{$staff->s_name}}</td>
				             <td>{{$staff->s_start}}</td>
				             <td>
				             		{{$staff->s_end}}
				             </td>
				             {{-- <td class="desktopOnly">{{$staff->s_two_digit_charge}}</td>
				             <td class="desktopOnly">{{$staff->s_three_digit_charge}}</td> --}}
				             <td class="desktopOnly">{{$staff->s_phone}}</td> 
				             <td class="desktopOnly">{{$staff->s_line}}</td> 
				             <td class="desktopOnly">{{$staff->s_fb}}</td>
				             <td class="desktopOnly">{{$staff->s_address}}</td> 
				             <td class="desktopOnly">{{$staff->	s_info}}</td> 
				                     
				             <td>
				              <a href="{{URL::to('/')}}/staff/{{$staff->s_id}}/edit"><button class="padding-button btn btn-xs btn-primary">{{trans('label.edit')}}</button></a>
				              <button id="{{$staff->s_id}}" class="padding-button deleteStaff btn btn-xs btn-danger">{{trans('label.delete')}}</button>
				             </td>
				            </tr>
			           @endforeach            
		            
		           </tbody>
		          </table>
		    
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

			var responsiveHelper_datatable_tabletools = undefined;
    
		    var breakpointDefinition = {
		     tablet : 1024,
		     phone : 480
		    };
			$('#datatable_tabletools').dataTable({
    
			    
			    "autoWidth" : true,
			    "preDrawCallback" : function() {
			     // Initialize the responsive datatables helper once.
			     if (!responsiveHelper_datatable_tabletools) {
			      responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
			     }
			    },
			    "rowCallback" : function(nRow) {
			     responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
			    },
			    "drawCallback" : function(oSettings) {
			     responsiveHelper_datatable_tabletools.respond();
			    }
			});



			$(document).off('click', '.deleteStaff').on('click', '.deleteStaff', function(e){
				var r = confirm("តើអ្នកចង់លុបវាឬទេ?");
	    		if (r == true) {
	    			var id = $(this).attr('id');
	    			$.ajax({
			              url: 'staff/deleteItem',
			              type: 'GET',
			              data: {id:id},
			              success: function(data) {
			                if(data.status=="success"){
			                  $(".staff-"+id).remove();
			                }else{
			                	alert(data.msg);
			                  // callPopupLogin();
			                }        
			              }
			        });
	    		}
	    	});
		});
	</script>
@stop