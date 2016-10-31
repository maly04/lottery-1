<!-- User info -->
			<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
					
					<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
						
						<span>
							{{Session::get('nameLot')}}
						</span>
						<!-- <i class="fa fa-angle-down"></i> -->
					</a> 
					
				</span>
			</div>
			<!-- end user info -->

			<!-- NAVIGATION : This navigation is also responsive

			To make this navigation dynamic please make sure to link the node
			(the reference to the nav > ul) after page load. Or the navigation
			will not initialize.
			-->
			<nav>
				<!-- NOTE: Notice the gaps after each icon usage <i></i>..
				Please note that these links work a bit different than
				traditional href="" links. See documentation for details.
				-->

				<ul>
					<li>
						<a href="{{URL::to('/')}}/dasboard" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">{{trans('label.dashboard')}}</span></a>
					</li>

					<li>
						<a href="#"><i class="fa fa-lg fa-sort-numeric-asc"></i> <span class="menu-item-parent">{{ trans('label.sale') }}</span></a>
						<ul>
							<li @if ($page == 'sale') class="active" @endif>
								<a href="{{URL::to('/')}}/sale">{{ trans('label.list_paper') }}</a>
							</li>
							<li @if ($page == 'add_sale') class="active" @endif>
								<a href="{{URL::to('/')}}/sale/create">{{ trans('label.add_new_lottery') }}</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="#"><i class="fa fa-lg fa-sort-numeric-asc"></i> <span class="menu-item-parent">{{ trans('result.result') }}</span></a>
						<ul>
							<li @if ($page == 'result') class="active" @endif>
								<a href="{{URL::to('/')}}/result">{{ trans('result.resultDisplay') }}</a>
							</li>
							<li @if ($page == 'add_result') class="active" @endif>
								<a href="{{URL::to('/')}}/result/create">{{ trans('result.addResult') }}</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="#"><i class="fa fa-lg fa-sort-numeric-asc"></i> <span class="menu-item-parent">{{ trans('report.report_result') }}</span></a>
						<ul>
							<li @if ($page == 'report') class="active" @endif>
								<a href="{{URL::to('/')}}/report">{{ trans('sidebar.reportDisplay') }}</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-money"></i> <span class="menu-item-parent">{{trans('label.staff_transaction')}}</span></a>
						<ul>
							<li @if ($page == 'staff_transction') class="active" @endif>
								<a href="{{URL::to('/')}}/stafftransction">{{trans('label.view_staff_transaction')}}</a>
							</li>
							<li @if ($page == 'add_staff_transction') class="active" @endif>
								<a href="{{URL::to('/')}}/stafftransction/create">{{trans('label.add_new')}}</a>
							</li>
						</ul>
					</li>
					

					
					
					
				
					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-users"></i> <span class="menu-item-parent">{{trans('label.staff')}}</span></a>
						<ul>
							<li @if ($page == 'staff') class="active" @endif>
								<a href="{{URL::to('/')}}/staff">{{trans('label.view_staff')}}</a>
							</li>
							<li @if ($page == 'add_staff') class="active" @endif>
								<a href="{{URL::to('/')}}/staff/create">{{trans('label.add_new')}}</a>
							</li>
						</ul>
					</li>

					
					<!-- <li>
						<a href="#"><i class="fa fa-lg fa-fw fa-money"></i> <span class="menu-item-parent">Report</span></a>
						<ul>
							<li @if ($page == 'profit-loss') class="active" @endif>
								<a href="{{URL::to('/')}}/profit-loss">Profit_loss by staff</a>
							</li>							
						</ul>
					</li> -->

					

					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-folder-open"></i> <span class="menu-item-parent">{{trans('label.pos')}}</span></a>
						<ul>
							<li @if ($page == 'pos') class="active" @endif>
								<a href="{{URL::to('/')}}/pos">{{trans('label.view_pos')}}</a>
							</li>
							<li @if ($page == 'add_pos') class="active" @endif>
								<a href="{{URL::to('/')}}/pos/create">{{trans('label.add_new')}}</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-folder-open"></i> <span class="menu-item-parent">{{trans('label.group')}}</span></a>
						<ul>
							<li @if ($page == 'pos_group') class="active" @endif>
								<a href="{{URL::to('/')}}/posgroup">{{trans('label.view_pos_group')}}</a>
							</li>
							<li @if ($page == 'add_pos_group') class="active" @endif>
								<a href="{{URL::to('/')}}/posgroup/create">{{trans('label.add_pos_group')}}</a>
							</li>
							<li @if ($page == 'group') class="active" @endif>
								<a href="{{URL::to('/')}}/group">{{trans('label.view_group')}}</a>
							</li>
							<li @if ($page == 'add_group') class="active" @endif>
								<a href="{{URL::to('/')}}/group/create">{{trans('label.add_group')}}</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-user"></i> <span class="menu-item-parent">{{trans('label.user')}}</span></a>
						<ul>
							<li @if ($page == 'user') class="active" @endif>
								<a href="{{URL::to('/')}}/user">{{trans('label.list_user')}}</a>
							</li>
							<li @if ($page == 'add_user') class="active" @endif>
								<a href="{{URL::to('/')}}/user/create">{{trans('label.new_user')}}</a>
							</li>
						</ul>
					</li>

					
				</ul>
			</nav>
			<span class="minifyme" data-action="minifyMenu"> 
				<i class="fa fa-arrow-circle-left hit"></i> 
			</span>