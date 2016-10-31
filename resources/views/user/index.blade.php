@extends('master')

@section('title')
<title>អ្នកប្រើប្រាស់</title>
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
			<li>អ្នកប្រើប្រាស់</li>
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
		         <h2>{{trans('label.list_user')}}</h2>
		    
		        </header>
		    
		        <!-- widget div-->
		        <div>
		    		
		         <!-- widget content -->
		         <div class="widget-body no-padding"> 
		                
		          <table id="datatable_tabletools" class="table table-striped table-bordered table-hover" width="100%">
		           
		           <thead>           
			            <tr>
				             <th >ល.រ</th>
				             <th >ឈ្មោះ</th>
				             <th class="desktopOnly">លេខទូរស័ព្ទ</th>
				             <th class="desktopOnly">គណនីសង្គមLine</th>
				             <th>ឈ្មោះអ្នកប្រើប្រាស់</th>
				             <th class="desktopOnly">ប្រភេទអ្នកប្រើប្រាស់</th>
				             <th>សកម្មភាព</th>
			            </tr>
		           </thead>
		           <tbody>
			           <?php $i=0;?>
			           @foreach($users as $user)
			           		<?php $i++;?>
				            <tr class="user-{{$user->u_id}}">
				             <td>{{$i}}</td>
				             <td>{{$user->u_name}}</td>
				             <td class="desktopOnly">{{$user->u_phone}}</td>
				             <td class="desktopOnly">{{$user->u_line}}</td>
				             <td>{{$user->u_username}}</td>
				             @if($user->role == 1)
				             	<td class="desktopOnly">Admin</td> 
				             @else
				             	<td class="desktopOnly">Normal</td> 
				             @endif
				                     
				             <td>
				              <a href="{{URL::to('/')}}/user/{{$user->u_id}}/edit"><button class="padding-button btn btn-xs btn-primary">កែប្រែ</button></a>
				              <button id="{{$user->u_id}}" class="padding-button deleteUser btn btn-xs btn-danger">លុបចោល</button>
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
			$(document).off('click', '.deleteUser').on('click', '.deleteUser', function(e){
				var r = confirm("Do you want to delete?");
	    		if (r == true) {
	    			var id = $(this).attr('id');
	    			$.ajax({
			              url: 'user/deleteItem',
			              type: 'GET',
			              data: {id:id},
			              success: function(data) {
			                if(data.status=="success"){
			                  $(".user-"+id).remove();
			                }else{
			                  // callPopupLogin();
			                }        
			              }
			        });
	    		}
	    	});
		});
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
	</script>
@stop