<style type="text/css">
	#event_add_in_row_modify{
		visibility: visible !important;
	}
	#event_add_in_row_modify .formAddGroup{
		width: 80% !important;
		padding-bottom:10px;
		margin-bottom: 10px;
	}
	#event_add_in_row_modify.row_main{
			background-color: #fff !important;
	}
	#event_add_in_row_modify .lottery_num_select{
		width: 10% !important;
	}
	#event_add_in_row_modify .lottery_num{
		width: 35% !important;
	}
	#event_add_in_row_modify .main_checkbo{
		width: 12% !important;
		margin-left: 10px !important;
	}
	#event_add_in_row_modify .btnSave{
		float: left !important;
		width: 30% !important;
		margin-top: 5px !important;
	}

</style>
<div id="dialogmodifynumber" title="" style="display:none;">
 <div style="width:100%; padding:10px 20px; ">
 	<h1>{{ trans('label.modify_number') }} : <span class="view_number_modify"></span></h1>

 	<div class="modify_number_style">
 		<!-- form add lottery -->
		<div class='row_main custom_padding smart-form' id="event_add_in_row_modify">
			<div class="lottery_num pos_style formAddGroup">
				<select id="pos_id_add" name="pos_id_add" class="formlottery_select eventPostInRow">
					<option value="">{{trans('label.pos')}}</option>
					@foreach($groups as $group)
					<option value="{{ $group->g_id }}">{{ $group->g_name }}</option>
					@endforeach
				</select>
				<input type="hidden" id='pos_id_hidden' name="pos_id_hidden" class="required">
				<input type="hidden" id='pos_id_hidden_old' name="pos_id_hidden_old" class="">
				<input type="hidden" id='r_id_hidden' name="r_id_hidden" value="">
				<input type="hidden" id='p_id_hidden' name="p_id_hidden" value="">
				<input type="hidden" id='num_id_hidden' name="num_id_hidden" value="">
			</div>
			<div class="clear"></div>
			<div class="lottery_num">
				{!! Form::text("num_number_add", $value = null, $attributes = array( 'id' => 'num_number_add', 'class'=>'form-control formlottery threedigitNew num required eventControlnumber', 'placeholder'=>trans('label.number'))) !!}
			</div>
			<div class="lottery_num_select">
				<select id="sym_id_add" name="sym_id_add" class="formlottery_select eventControlSym">
					@foreach($symbols as $symbol)
					<option value="{{ $symbol->pav_id }}">{{ $symbol->pav_value }}</option>
					@endforeach
				</select>
			</div>
			<div class="lottery_num">
				{!! Form::text("num_number_end_add", $value = null, $attributes = array( 'id' => 'num_number_end_add','disabled' => 'true', 'class'=>'form-control formlottery threedigitNew num', 'placeholder'=>trans('label.number'))) !!}
			</div>
			<div class="lottery_num main_checkbo">
				<span>{{trans('label.multiply')}}</span>
				<input type="checkbox" id="num_reverse_add" name="num_reverse_add"​ class="check_style">
			</div>
			<div class="clear"></div>
			<div class="lottery_num main_price">
				{!! Form::text("num_amount_add", $value = null, $attributes = array( 'id' => 'num_amount_add', 'class'=>'form-control formlottery num required', 'placeholder'=>trans('label.money'))) !!}
			</div>
			<div class="lottery_num_select customStyleCurrency">
				<select id="currentcy_add" name="currentcy_add" class="formlottery_select customCurrency">
					@foreach($currencys as $currency)
					<option value="{{ $currency->pav_id }}">{{ $currency->pav_value }}</option>
					@endforeach
				</select>
			</div>
			<div class="btnSave">
				<button type="button" id="saveLotteryUpdate" colume="" page="" name="saveLottery" class="btn btn-xs btn-primary ">{{trans('label.save')}}</button>
			</div>
			<div class="clear"></div>
		</div>
 	</div>
 	
 </div>
</div>

