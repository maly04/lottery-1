@extends('master')

@section('title')
    <title>{{ trans('result.result') }}</title>
@stop

@section('cssStyle')
    <style type="text/css">
        .bee .form-control.required {
            padding: 0 10px;
        }
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
            <li>{{ trans('result.result') }}</li><li>{{ trans('result.view') }}</li>
        </ol>
        <!-- end breadcrumb -->


    </div>
    <!-- END RIBBON -->

    <!-- MAIN CONTENT -->
    <div id="content">



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
                <article class="col-sm-12 col-md-12 col-lg-12 bee">

                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                            <h2>{{ trans('result.result') }}{{ trans('result.view') }}</h2>

                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget edit box -->
                            <div class="jarviswidget-editbox">
                                <!-- This area used as dropdown edit box -->

                            </div>
                            <!-- end widget edit box -->

                            <!-- widget content -->
                            <article class="widget-body no-padding">
                                {!! Form::open(['route' => 'filterView', 'files' => true , 'novalidate' => 'validate', 'id' => 'filter','class'=>'smart-form filter-form']) !!}
                                <fieldset>
                                    @if(isset($var_date))
                                        <?php $date_filter = $var_date; ?>
                                    @else
                                        <?php $date_filter = date('Y-m-d'); ?>
                                    @endif

                                    @if(isset($var_sheet))
                                        <?php $sheet_filter = $var_sheet; ?>
                                    @else
                                        <?php $sheet_filter = null; ?>
                                    @endif
                                    <div class="row">

                                        <section class="col col-3">
                                            <label class="input">
                                                <i class="icon-append fa fa-calendar"></i>
                                                {!! Form::text("date", $value = $date_filter, $attributes = array('class' => 'form-control required', 'id' => 'date','sms'=>trans('result.pleaseChooseDate'))) !!}
                                            </label>
                                        </section>
                                        <section class="col col-3">
                                            <label class="select">
                                                {{ Form::select('sheet', ([
                                                   '' => trans('result.chooseShift')]+$sheets),$sheet_filter,['class' => 'required ','id'=>'sheet','sms'=>trans('result.pleaseChooseShift')]
                                                ) }}
                                                <i></i>
                                            </label>
                                        </section>
                                        <section class="col col-3">
                                            <label class="tesxt">
                                                <button type="submit" name="submit" class="btn btn-primary btn-sm btn-filter">{{ trans('result.filter') }}</button>
                                            </label>
                                        </section>

                                    </div>
                                </fieldset>
                                {{ Form::close() }}

                                @if(isset($var_date))
                                    <?php $date_filter = $var_date; ?>
                                @else
                                    <?php $date_filter = date('Y-m-d'); ?>
                                @endif

                                @if(isset($var_sheet))
                                    <?php $sheet_filter = $var_sheet; ?>
                                @else
                                    <?php $sheet_filter = null; ?>
                                @endif
                                @if(isset($poss))
                                    {!! Form::open(['route' => 'updateResult', 'files' => true , 'novalidate' => 'validate', 'id' => 'checkout-form', 'class'=>'smart-form form_add']) !!}
                                    <fieldset>
                                        <div class="row">
                                            <article class="col-sm-2 col-md-2 col-lg-2">
                                                <section class="col">
                                                    <b>{{trans('result.pos')}}</b>
                                                </section>
                                            </article>
                                            <article class="col-sm-2 col-md-2 col-lg-2">
                                                <section class="col">
                                                    <b>{{trans('label.priceFor2Digits')}}</b>
                                                </section>
                                            </article>
                                            <article class="col-sm-2 col-md-2 col-lg-2">
                                                <section class="col">
                                                    <b>{{trans('label.priceFor3Digits')}}</b>
                                                </section>
                                            </article>
                                        </div>
                                    </fieldset>

                                    <?php $i=0;?>
                                    @foreach($mainResult as $pos)
                                        <?php $i++;?>
                                        {{--POS group--}}
                                        <fieldset>
                                            <div class="row">
                                                {{--POS title--}}
                                                <article class="col-sm-2 col-md-2 col-lg-2">
                                                    <section class="col col-12">
                                                        <b>{{ $pos[1] }}</b>
                                                    </section>
                                                </article>

                                                {{--2digit--}}
                                                <article class="col-sm-2 col-md-2 col-lg-2">
                                                    @foreach($pos[2] as $val)
                                                        <section class="col">
                                                            {{$val}}
                                                        </section>
                                                        <div class="clearfix"></div>
                                                    @endforeach
                                                </article>
                                                {{--3digit--}}
                                                <article class="col-sm-3 col-md-3 col-lg-3">
                                                    @foreach($pos[3] as $val)
                                                        <section class="col">
                                                            {{$val}}
                                                        </section>
                                                        <div class="clearfix"></div>
                                                    @endforeach
                                                </article>
                                            </div>

                                        </fieldset>
                                    @endforeach


                            {{ Form::close() }}
                            @endif

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
        $(document).off('submit', '#filter').on('submit', '#filter', function(e) {
            if (validate_form_main('.filter-form') == 0) {

                return true;
            }
            return false;
        });

        $(document).off('submit', '#checkout-form').on('submit', '#checkout-form', function(e) {
            if (validate_form_main('.form_add') == 0) {

                return true;
            }
            return false;
        });


        $(document).ready(function() {
            // START AND FINISH DATE
            $('#date').datepicker({
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