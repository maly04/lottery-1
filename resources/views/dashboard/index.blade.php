@extends('master')

@section('title')
<title>Welcome to lottery</title>
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
			<li>{{trans('label.dashboard')}}</li>
		</ol>
		<!-- end breadcrumb -->


	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		     <!--  <h1 class="page-title txt-color-blueDark">
		       <i class="fa fa-users fa-fw "></i> របាយការណ៏
		       
		      </h1> -->
		     </div>
		    </div>


		<div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		     <!--  <h1 class="page-title txt-color-blueDark">
		       <i class="fa fa-users fa-fw "></i> របាយការណ៏
		       
		      </h1> -->
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
		       <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
		        
		        <header>
		         <span class="widget-icon"> <i class="fa fa-table"></i> </span>
		         <!-- <h2>របាយការណ៏</h2> -->
		          <h2>របាយការណ៏សរុប ទូទាត់លទ្ធផលឆ្នោត</h2> 
		        </header>
		    
		        <!-- widget div-->
		        <div>
		    
		         <!-- widget content -->
		         <div class="widget-body no-padding">          
		          <table id="datatable_tabletools1" class="table-report table table-striped table-bordered table-hover" width="100%">		           
		           <thead> 

		           		<tr>
		           			<th colspan="7" class="col_text">របាយការណ៏សរុប ទូទាត់លទ្ធផលឆ្នោត</th>
		           		</tr>  
		           		<tr>		           			
		           			<th rowspan="2" class="col_text col_staff" >{{ trans('label.child') }}</th>
		           			<th colspan="2" class="col_text">លុយដើមកូន</th>
		           			<th colspan="2" class="col_text">លុយកូនចាក់ត្រូវ</th>
		           			<th colspan="2" class="col_text">តុល្យភាព</th>
		           		</tr>       
			            <tr>
				             <!-- <th >ID</th> -->				           				             
				             <th class="col_text">{{ trans('label.dollar') }}</th>
				             <th class="col_text">{{ trans('label.reil') }}</th>					             
				             <th class="col_text">{{ trans('label.dollar') }}</th>			             
				             <th class="col_text">{{ trans('label.reil') }}</th>
				             <th class="col_text">{{ trans('label.dollar') }}</th>
				             <th class="col_text">{{ trans('label.reil') }}</th>
			            </tr>
			             
			            	
		           </thead>
		          
		           <tbody>
		           
		           <?php 
		           		$total_dollar= 0; $total_riel = 0;
		           ?>
			         @foreach($sumary_lottery as $sommary)
			         	<tr>
			         		<td class="col_text">{{$sommary->sname}}</td>
			         		<td class="col_text_right">{{number_format($sommary->incomeDollar)}} $</td>
			         		<td class="col_text_right">{{number_format($sommary->incomeRiel)}} R</td>
			         		<td class="col_text_right">{{number_format($sommary->expenseDollar)}} $</td>
			         		<td class="col_text_right">{{number_format($sommary->expenseRiel)}} R</td>
			         		<td class="col_text_right">{{number_format($sommary->incomeDollar - $sommary->expenseDollar)}} $</td>
			         		<td class="col_text_right">{{number_format($sommary->incomeRiel - $sommary->expenseRiel)}} R</td>
			         	</tr>
			         	<?php
				         	 $total_dollar += $sommary->incomeDollar - $sommary->expenseDollar;
				         	 $total_riel += $sommary->incomeRiel - $sommary->expenseRiel;
			         	?>
			         @endforeach  
			            
		           </tbody>
		           <tbody>
			           <tr>
			           		<td colspan="5" class="col_text_right">សរុប:</td>
			           		<td class="col_text_right">{{number_format($total_dollar)}} $</td>
			           		<td class="col_text_right">{{number_format($total_riel)}} R</td>
			           </tr>
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
		       <div class="jarviswidget jarviswidget-color-blueDark" id="" data-widget-editbutton="false">
		        
		        <header>
		         <span class="widget-icon"> <i class="fa fa-table"></i> </span>
		         <!-- <h2>របាយការណ៏</h2> -->
		         <h2>របាយការណ៏សរុប លុយទទួលបាន នឹងផ្តល់អោយកូន</h2>
		        </header>
		    
		        <!-- widget div-->
		        <div>
		    
		         <!-- widget content -->
		         <div class="widget-body no-padding">          
		          <table id="datatable_tabletools" class="table-report table table-striped table-bordered table-hover" width="100%">		

		           <thead>  
		           		<tr>
		           			<th colspan="7" class="col_text">របាយការណ៏សរុប លុយទទួលបាន នឹងផ្តល់អោយកូន</th>
		           		</tr>  
		           		<tr>		           			
		           			<th rowspan="2" class="col_text col_staff" >{{ trans('label.child') }}</th>
		           			<th colspan="2" class="col_text">លុយទទួលបានពីកូន</th>
		           			<th colspan="2" class="col_text">លុយផ្តល់អោយកូន</th>
		           			<th colspan="2" class="col_text">តុល្យភាព</th>
		           		</tr>       
			            <tr>
				             <!-- <th >ID</th> -->				           				             
				             <th class="col_text">{{ trans('label.dollar') }}</th>
				             <th class="col_text">{{ trans('label.reil') }}</th>					             
				             <th class="col_text">{{ trans('label.dollar') }}</th>			             
				             <th class="col_text">{{ trans('label.reil') }}</th>
				             <th class="col_text">{{ trans('label.dollar') }}</th>
				             <th class="col_text">{{ trans('label.reil') }}</th>
			            </tr>
			             
			            	
		           </thead>

		           <tbody>
			          {!! $tr !!}       
		            
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

		      <!-- NEW WIDGET SUMMARY  REAL LOTTERY TRANSACTION -->
		      <article class="col-sm-12 col-md-12 col-lg-12">
		      		<!-- Widget ID (each widget will need unique ID)-->
		       <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-summary-real-lottery-tran" data-widget-editbutton="false">
		        
		        <header>
		         <span class="widget-icon"> <i class="fa fa-table"></i> </span>
		         <h2>របាយការណ៏សរុប ចំណេញនឹងខាត</h2>
		        </header>
		    
		        <!-- widget div-->
		        <div>
		    
		         <!-- widget content -->
		         <div class="widget-body no-padding">          
		          <table id="datatable-summary-real-lottery-tran" class="table-report table table-striped table-bordered table-hover" width="100%">		           
		           <thead>           
			            <!-- <tr>
				             <th>ID</th>      
				             <th>Staff</th>
				             <th>Real Lottery ($)</th>         
				             <th>Real Lottery (R)</th>
				             <th>Real Transaction ($)</th>
				             <th>Real Transaction (R)</th>
				             <th>Balance ($)</th>
				             <th>Balance (R)</th>
			            </tr> -->
			            <tr>
		           			<th colspan="7" class="col_text">របាយការណ៏សរុប ចំណេញនឹងខាត</th>
		           		</tr>  
		           		<tr>		           			
		           			<th rowspan="2" class="col_text col_staff" >{{ trans('label.child') }}</th>
		           			<th colspan="2" class="col_text">សរុបទូទាត់លទ្ធផលឆ្នោះ</th>
		           			<th colspan="2" class="col_text">សរុបលុយទទួលបាន នឹងផ្តល់អោយកូន</th>
		           			<th colspan="2" class="col_text">តុល្យភាពលុយកូន/មេជំពាក់</th>
		           		</tr>       
			            <tr>
				             <!-- <th >ID</th> -->				           				             
				             <th class="col_text">{{ trans('label.dollar') }}</th>
				             <th class="col_text">{{ trans('label.reil') }}</th>					             
				             <th class="col_text">{{ trans('label.dollar') }}</th>			             
				             <th class="col_text">{{ trans('label.reil') }}</th>
				             <th class="col_text">{{ trans('label.dollar') }}</th>
				             <th class="col_text">{{ trans('label.reil') }}</th>
			            </tr>

		           </thead>
		           <tbody>
			           @foreach($summaryDatas as $summaryData)
		           		<tr>     
				             <td class="col_text">{{$summaryData['user_name']}}</td>
				             <td class="col_text_right">{{$summaryData['lottery_balance_dollar']}} $</td>         
				             <td class="col_text_right">{{$summaryData['lottery_balance_riel']}} R</td>
				             <td class="col_text_right">{{$summaryData['tran_balance_dollar']}} $</td>
				             <td class="col_text_right">{{$summaryData['tran_balance_riel']}} R</td>
				             <td class="col_text_right">{{$summaryData['balance_dollar']}} $</td>
				             <td class="col_text_right">{{$summaryData['balance_riel']}} R</td>
			             </tr>
			             @endforeach
		           </tbody>
		           <tbody><tr><td colspan="5" class="col_text_right">សរុប:</td><td class="col_text_right">{{$totalGainsAndLosses_dollar}} $</td><td class="col_text_right">{{$totalGainsAndLosses_riel}} R</td></tr></tbody>
		          </table>
		    
		         </div>
		         <!-- end widget content -->
		      </section>
		      <!-- END WIDGET SUMMARY  REAL LOTTERY TRANSACTION -->

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

			//WIDGET SUMMARY  REAL LOTTERY TRANSACTION

			$('#datatable-summary-real-lottery-tran').dataTable({
    
			    
			    "autoWidth" : true,
			    "preDrawCallback" : function() {
			     // Initialize the responsive datatables helper once.
			     if (!responsiveHelper_datatable_tabletools) {
			      responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable-summary-real-lottery-tran'), breakpointDefinition);
			     }
			    },
			    "rowCallback" : function(nRow) {
			     responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
			    },
			    "drawCallback" : function(oSettings) {
			     responsiveHelper_datatable_tabletools.respond();
			    }
			});


			$('#datatable_tabletools1').dataTable({  
			    
			    "autoWidth" : true,
			    "preDrawCallback" : function() {
			     // Initialize the responsive datatables helper once.
			     if (!responsiveHelper_datatable_tabletools) {
			      responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools1'), breakpointDefinition);
			     }
			    },
			    "rowCallback" : function(nRow) {
			     responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
			    },
			    "drawCallback" : function(oSettings) {
			     responsiveHelper_datatable_tabletools.respond();
			    }
			});



			
		});
	</script>
@stop