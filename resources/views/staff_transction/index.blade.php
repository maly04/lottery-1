@extends('master')

@section('title')
<title>{{trans('label.staff_transaction')}}</title>
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
			<li>{{trans('label.staff_transaction')}}</li>
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
		        {{trans('label.staff_transaction_list')}}
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
		         <h2>{{trans('label.staff_transaction_list')}}</h2>
		    
		        </header>
		    
		        <!-- widget div-->
		        <div>
		    
		         <!-- widget content -->
		         <div class="widget-body no-padding">          
		          <table id="datatable_tabletools" class="table table-striped table-bordered table-hover" width="100%">
		           
		           <thead>           
			            <tr>
				             <th >{{trans('label.id')}}</th>
				             <th >{{trans('label.staff_name')}}</th>
				             <th>{{trans('label.amount')}}</th>
				             <th class="desktopOnly">{{trans('label.currency')}}</th>
				             <th class="desktopOnly">{{trans('label.type')}}</th>
				             <th class="desktopOnly">{{trans('label.date_deposit')}}</th>
				             <th class="desktopOnly">{{trans('label.remark')}}</th>
				             <th>{{trans('label.action')}}</th>
			            </tr>
		           </thead>
		           <tbody>
			           <?php $i=0;?>
			           @foreach($transctions as $transction)
			           		<?php $i++;?>
				            <tr class="stafftransction-{{$transction->st_id}}">
				             <td>{{$i}}</td>
				             <td>{{$transction->s_name}}</td>
				             <td>

				             	{{  number_format($transction->st_price, 0) }}

				             </td>
				             <td class="desktopOnly">
				             	@if(array_key_exists($transction->st_currency,$getCurrencys))
				             		{{$getCurrencys[$transction->st_currency]}}
				             	@endif
				             </td>
				             <td class="desktopOnly">
				              	@if(array_key_exists($transction->st_type,$getTypes))
				             		{{$getTypes[$transction->st_type]}}
				             	@endif
				             </td>
				             <td class="desktopOnly">
				             	{{$transction->st_date_diposit}}
				             </td>
				             <td class="desktopOnly">
				             	{{str_limit($transction->st_remark, 15)}}
				             </td>
				                     
				             <td>
				              <a href="{{URL::to('/')}}/stafftransction/{{$transction->st_id}}/edit"><button class="padding-button btn btn-xs btn-primary">{{trans('label.edit')}}</button></a>
				              <button id="{{$transction->st_id}}" class="padding-button deleteStaffTransction btn btn-xs btn-danger">{{trans('label.delete')}}</button>
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


			$(document).off('click', '.deleteStaffTransction').on('click', '.deleteStaffTransction', function(e){
				var r = confirm("តើអ្នកចង់លុបវាឬទេ?");
	    		if (r == true) {
	    			var id = $(this).attr('id');
	    			$.ajax({
			              url: 'stafftransction/deleteItem',
			              type: 'GET',
			              data: {id:id},
			              success: function(data) {
			                if(data.status=="success"){
			                  $(".stafftransction-"+id).remove();
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