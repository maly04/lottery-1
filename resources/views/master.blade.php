<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		@yield('title')

		<meta name="description" content="">
		<meta name="author" content="">
			
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset("css/bootstrap.min.css"); ?>">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset("css/font-awesome.min.css"); ?>">

		<!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset("css/smartadmin-production.min.css"); ?>">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset("css/smartadmin-skins.min.css"); ?>">

		
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset("css/demo.min.css"); ?>">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset("css/your_style.css"); ?>">
		
		<!-- FAVICONS -->
		<link rel="shortcut icon" href="<?php echo asset("img/favicon/favicon.ico"); ?>" type="image/x-icon">
		<link rel="icon" href="<?php echo asset("img/favicon/favicon.ico"); ?>" type="image/x-icon">

		<!-- GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<!-- <link href="https://fonts.googleapis.com/css?family=Hanuman|Open+Sans|Ubuntu+Mono&amp;subset=khmer" rel="stylesheet"> -->

		<!-- Specifying a Webpage Icon for Web Clip 
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="<?php echo asset("img/splash/sptouch-icon-iphone.png"); ?>">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo asset("img/splash/touch-icon-ipad.png"); ?>">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo asset("img/splash/touch-icon-iphone-retina.png"); ?>">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo asset("img/splash/touch-icon-ipad-retina.png"); ?>">
		
		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		
		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="<?php echo asset("img/splash/ipad-landscape.png"); ?>" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="<?php echo asset("img/splash/ipad-portrait.png"); ?>" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="<?php echo asset("img/splash/iphone.png"); ?>" media="screen and (max-device-width: 320px)">
		<!-- vannarith style -->
		<link href='https://fonts.googleapis.com/css?family=Bayon|Francois+One' rel='stylesheet' type='text/css'>
		@yield('cssStyle')


	</head>
	<body class="">
		<!-- possible classes: minified, fixed-ribbon, fixed-header, fixed-width-->

		<!-- HEADER -->
		<header id="header">
			@include('header')

		</header>
		<!-- END HEADER -->

		<!-- Left panel : Navigation area -->
		<!-- Note: This width of the aside area can be adjusted through LESS variables -->
		<aside id="left-panel">

			@include('sidebar')

		</aside>
		<!-- END NAVIGATION -->

		<!-- MAIN PANEL -->
		<div id="main" role="main">

			@yield('content')

		</div>
		<!-- END MAIN PANEL -->

		@include('footer')

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		

		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script>
			if (!window.jQuery) {
				document.write('<script src="<?php echo asset("js/libs/jquery-2.0.2.min.js"); ?>"><\/script>');
			}
		</script>

		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script>
			if (!window.jQuery.ui) {
				document.write('<script src="<?php echo asset("js/libs/jquery-ui-1.10.3.min.js"); ?>"><\/script>');
			}
		</script>

		<!-- IMPORTANT: APP CONFIG -->
		<script src="<?php echo asset("js/app.config.js"); ?>"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
		<script src="<?php echo asset("js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"); ?>"></script> 

		<!-- BOOTSTRAP JS -->
		<script src="<?php echo asset("js/bootstrap/bootstrap.min.js"); ?>"></script>

		<!-- CUSTOM NOTIFICATION -->
		<script src="<?php echo asset("js/notification/SmartNotification.min.js"); ?>"></script>

		<!-- JARVIS WIDGETS -->
		<script src="<?php echo asset("js/smartwidgets/jarvis.widget.min.js"); ?>"></script>

		<!-- EASY PIE CHARTS -->
		<script src="<?php echo asset("js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"); ?>"></script>

		<!-- SPARKLINES -->
		<script src="<?php echo asset("js/plugin/sparkline/jquery.sparkline.min.js"); ?>"></script>

		<!-- JQUERY VALIDATE -->
		<script src="<?php echo asset("js/plugin/jquery-validate/jquery.validate.min.js"); ?>"></script>

		<!-- JQUERY MASKED INPUT -->
		<script src="<?php echo asset("js/plugin/masked-input/jquery.maskedinput.min.js"); ?>"></script>

		<!-- JQUERY SELECT2 INPUT -->
		<script src="<?php echo asset("js/plugin/select2/select2.min.js"); ?>"></script>

		<!-- JQUERY UI + Bootstrap Slider -->
		<script src="<?php echo asset("js/plugin/bootstrap-slider/bootstrap-slider.min.js"); ?>"></script>

		<!-- browser msie issue fix -->
		<script src="<?php echo asset("js/plugin/msie-fix/jquery.mb.browser.min.js"); ?>"></script>

		<!-- FastClick: For mobile devices -->
		<script src="<?php echo asset("js/plugin/fastclick/fastclick.min.js"); ?>"></script>

		<!--[if IE 8]>

		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->

		<!-- Demo purpose only -->
		<script src="<?php echo asset("js/demo.min.js"); ?>"></script>

		<!-- MAIN APP JS FILE -->
		<script src="<?php echo asset("js/app.min.js"); ?>"></script>

		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
		<!-- Voice command : plugin -->
		<script src="<?php echo asset("js/speech/voicecommand.min.js"); ?>"></script>
		
		<!-- PAGE RELATED PLUGIN(S) -->
		
		<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
		<script src="<?php echo asset("js/plugin/flot/jquery.flot.cust.min.js"); ?>"></script>
		<script src="<?php echo asset("js/plugin/flot/jquery.flot.resize.min.js"); ?>"></script>
		<script src="<?php echo asset("js/plugin/flot/jquery.flot.tooltip.min.js"); ?>"></script>
		
		<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
		<script src="<?php echo asset("js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"); ?>"></script>
		<script src="<?php echo asset("js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"); ?>"></script>
		
		<!-- Full Calendar -->
		<script src="<?php echo asset("js/plugin/fullcalendar/jquery.fullcalendar.min.js"); ?>"></script>

		<script src="{{ asset('/') }}js/plugin/datatables/jquery.dataTables.min.js"></script>
	    <script src="{{ asset('/') }}js/plugin/datatables/dataTables.colVis.min.js"></script>
	    <script src="{{ asset('/') }}js/plugin/datatables/dataTables.tableTools.min.js"></script>
	    <script src="{{ asset('/') }}js/plugin/datatables/dataTables.bootstrap.min.js"></script>
	    <script src="{{ asset('/') }}js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

	    <script src="{{ asset('/') }}js/custom.js"></script>



		<script>
			$(document).ready(function() {
				startTime();

				// bee input 2 charater only
				 $(document).off('keypress', '.twodigit').on('keypress', '.twodigit', function(e){
					var tval = $(this).val(),
							tlength = tval.length,
							set = 2,
							remain = parseInt(set - tlength);
					if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
						$(this).val((tval).substring(0, tlength - 1))
					}
				});
				// bee input 3 charater only
				$(document).off('keypress', '.threedigit').on('keypress', '.threedigit', function(e){
					var tval = $(this).val(),
							tlength = tval.length,
							set = 3,
							remain = parseInt(set - tlength);
					if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
						$(this).val((tval).substring(0, tlength - 1))
					}
				});


				$(document).off('keypress', '.twodigitNew').on('keypress', '.twodigitNew', function(e){
					var tval = $(this).val(),
							tlength = tval.length,
							set = 2,
							remain = parseInt(set - tlength);
					if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
						$(this).val((tval).substring(0, tlength - 1))
					}
				});
				$(document).off('keypress', '.threedigitNew').on('keypress', '.threedigitNew', function(e){
					var tval = $(this).val(),
							tlength = tval.length,
							set = 3,
							remain = parseInt(set - tlength);
					if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
						$(this).val((tval).substring(0, tlength - 1))
					}
				});				


				// bee only numberic
				$(document).off('keypress', '.num').on('keypress', '.num', function(e){
					//if the letter is not digit then display error and don't type anything
					if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
						//display error message
						// $("#errmsg").html("Digits Only").show().fadeOut("slow");
						return false;
					}
				});




			});

			function validate_by_vannarith(class_div,id,sms,type){

				
				// $('.required').remove();

				if(type == 'add'){
					$(class_div).find('#'+id).removeClass('invalid');
					$(class_div).find('#'+id).parent().removeClass('state-error');
					$(class_div).find('#em_'+id).remove();

					$(class_div).find('#'+id).addClass('invalid');
					$(class_div).find('#'+id).parent().addClass('state-error');
					var sms = '<em for="'+id+'" id="em_'+id+'" class="invalid">'+sms+'</em>';
					$(class_div).find('#'+id).parent().append(sms);
				}else{
					$(class_div).find('#'+id).removeClass('invalid');
					$(class_div).find('#'+id).parent().removeClass('state-error');
					$(class_div).find('#em_'+id).remove();
				}

			}
			function currencyFormat(num){
				    var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
				    if(str.indexOf(".") > 0) {
				        parts = str.split(".");
				        str = parts[0];
				    }
				    str = str.split("").reverse();
				    for(var j = 0, len = str.length; j < len; j++) {
				        if(str[j] != ",") {
				            output.push(str[j]);
				            if(i%3 == 0 && j < (len - 1)) {
				                output.push(",");
				            }
				            i++;
				        }
				    }
				    formatted = output.reverse().join("");
				    return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
			}

			

			function validate_form_main(class_div){
				var num = 0;
				$('.required').removeClass('invalid');
				$('.required').parent().removeClass('state-error');

				$(class_div + " .required").each(function(index, element) {
					var id, info, value, number;
					value = $(element).val();
					id = $(element).attr('id');
					number = $(element).attr('number');
					
					if($(element).attr('sms')){
						info = $(element).attr('sms');
					}else{
						info = '';
					}

					pattern_number = /^\d+$/;


					// alert(id);
					if (value === '') { //check value empty
						validate_by_vannarith(class_div,id,info,'add');
						num = num + 1;
					}else if(number === 'true' && !pattern_number.test(value)){ //check value number only
						validate_by_vannarith(class_div,id,'This field should be number only','add');
						num = num + 1;
					}else{ //else value good data
						validate_by_vannarith(class_div,id,'','remove');
					}
				});
				$(class_div + " .required.twodigit").each(function(index, element) {
					var id, info, value ;
					value = $(element).val();
					id = $(element).attr('id');

					if($(element).attr('sms')){
						info = $(element).attr('sms');
					}else{
						info = '';
					}

					pattern_number = /^\d{2}$/;
					// alert(id);
					if(value!=""){
						 if(!pattern_number.test(value)){ //check value number only
							validate_by_vannarith(class_div,id,'{{ trans('result.price2digits') }}','add');
							num = num + 1;
						}else{ //else value good data
							validate_by_vannarith(class_div,id,'','remove');
						}
					}
				});

				$(class_div + " .required.threedigit").each(function(index, element) {
					var id, info, value ;
					value = $(element).val();
					id = $(element).attr('id');

					if($(element).attr('sms')){
						info = $(element).attr('sms');
					}else{
						info = '';
					}

					pattern_number = /^\d{3}$/;
					// alert(id);
					if(value!=""){
						if(!pattern_number.test(value)){ //check value number only
							validate_by_vannarith(class_div,id,'{{ trans('result.price3digits') }}','add');
							num = num + 1;
						}else{ //else value good data
							validate_by_vannarith(class_div,id,'','remove');
						}
					}
				});
				$(class_div + " .twodigitNew").each(function(index, element) {
					var id, info, value ;
					value = $(element).val();
					id = $(element).attr('id');

					if($(element).attr('sms')){
						info = $(element).attr('sms');
					}else{
						info = '';
					}

					pattern_number = /^\d{2}$/;
					// alert(id);
					if(value!=""){
						 if(!pattern_number.test(value)){ //check value number only
							validate_by_vannarith(class_div,id,'','add');
							num = num + 1;
						}else{ //else value good data
							validate_by_vannarith(class_div,id,'','remove');
						}
					}
				});
				$(class_div + " .threedigitNew").each(function(index, element) {
					var id, info, value ;
					value = $(element).val();
					id = $(element).attr('id');

					if($(element).attr('sms')){
						info = $(element).attr('sms');
					}else{
						info = '';
					}

					pattern_number = /^\d{2,3}$/;
					// alert(id);
					if(value!=""){
						if(!pattern_number.test(value)){ //check value number only
							validate_by_vannarith(class_div,id,'','add');
							num = num + 1;
						}else{ //else value good data
							validate_by_vannarith(class_div,id,'','remove');
						}
					}
				});
				return num;
			}


		</script>

		@yield('javascript')


	</body>

</html>