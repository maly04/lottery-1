@extends('master')

@section('title')
    <title>{{ trans('result.result') }}</title>
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
            <li>{{ trans('result.result') }}</li>
        </ol>
        <!-- end breadcrumb -->


    </div>
    <!-- END RIBBON -->

    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-folder-open fa-fw "></i>
                    {{ trans('result.resultDisplay') }}
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
                            <h2>{{ trans('result.resultDisplay') }}</h2>

                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <table id="datatable_tabletools" class="table table-striped table-bordered table-hover" width="100%">

                                    <thead>
                                        <tr>
                                            <th>{{ trans('result.id') }}</th>
                                            <th>{{ trans('result.date') }}</th>
                                            <th>{{ trans('result.shift') }}</th>
                                            <th>{{ trans('result.actioin') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=0;?>
                                    @foreach($results as $val)
                                        <?php $i++; ?>
                                        <tr>
                                            <td>
                                                {{ $i }}
                                            </td>
                                            <td>
                                                {{ date('Y-m-d', strtotime($val->re_date)) }}
                                            </td>
                                            <td>
                                                {{ $val->pav_value }}
                                            </td>
                                            <td>
                                                <a href="{{URL::to('/')}}/result/view/{{ date('Y-m-d', strtotime($val->re_date)) }}/{{ $val->pav_id }}"><button class="padding-button btn btn-xs btn-info">{{ trans('result.view') }}</button></a>
                                                <a href="{{URL::to('/')}}/result/modify/{{ date('Y-m-d', strtotime($val->re_date)) }}/{{ $val->pav_id }}"><button class="padding-button btn btn-xs btn-primary">{{ trans('result.update') }}</button></a>
                                                <a href="{{URL::to('/')}}/result/delete/{{ date('Y-m-d', strtotime($val->re_date)) }}/{{ $val->pav_id }}" id="deltelResult"><button class="padding-button btn btn-xs btn-danger">{{ trans('result.delete') }}</button></a>
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


            $(document).off('click', '#deltelResult').on('click', '#deltelResult', function(e){
                var r = confirm("{{ trans('result.doYouWantToDelete') }}");
                if (r == true) {
                    return true;
                }
                return false;
            });


        });
    </script>
@stop