@extends('app-admin')
@section('content')
	{!! Html::script( asset('js/admin-main.js')) !!}
	{!! Html::script( asset('js/delete-modal.js')) !!}
	{!! Html::script( asset('js/lang-modal.js')) !!}
{!! Form::open(['action' => ['AdminController@postAddDomain'] ,'files' => 'true' , 'class' => 'form-horizontal','id' => 'add_domain', 'role' => 'form' ]) !!}
	<div class="container">
	    <div class="row clearfix">
			<div class="col-md-12 column">
				<table class="table table-bordered table-hover" id="tab_logic">
					<thead>
						<tr>
							<th class="text-center">
								Domain
							</th>
							<th class="text-center">
								Css
							</th>
							<th class="text-center">
								Client id
							</th>
							<th class="text-center">
								Client secret
							</th>
							<th class="text-center">
								Ticket Title
							</th>
							<th class="text-center">
								Fan Title
							</th>
							<th class="text-center">
								Favicon
							</th>
							<th class="text-center">
								Language
							</th>
						</tr>
					</thead>
					<tbody>
						<div id="domain_error">
							@include('message')
						</div>
						<tr id='addr0'>
							<td>
								{!! Form::text('sub_domain', null, ['id' => 'sub_domain', 'class' => 'form-control',  'autocomplete' => 'off']) !!}
							</td>
							<td>
								{!! Form::file('css',['id' => 'css', 'class' => 'filestyle', 'data-input' => 'false']) !!}
							</td>
							<td>
								{!! Form::text('client_id', null,['id' => 'clientid' , 'class' => 'form-control' ]) !!}	
							</td>
							<td>
								{!! Form::text('client_secret',null,['id' => 'client_secret' , 'class' => 'form-control' ]) !!}	
							</td>
							<td>
								{!! Form::text('ticket_title',null,['id' => 'ticket_title' , 'class' => 'form-control' ]) !!}	
							</td>
							<td>
								{!! Form::text('fan_title',null,['id' => 'fan_title' , 'class' => 'form-control' ]) !!}	
							</td>
							<td>
								{!! Form::file('favicon', array('id' => 'Favicon' , 'class'=>'filestyle', 'data-input' => 'false')) !!}
							</td>
							<td>
								<center>
									{!! Form::select('language',$lang ,null, array('id' => 'language' , 'class'=>'form-control', 'data-input' => 'false')) !!}
								</center>
							</td>
						</tr>
	                    <tr id='addr1'></tr>
					</tbody>
				</table>
				<div class="clearfix form-actions">

				</div>
				<div class="col-md-offset-3 col-md-9" style="margin:0">
					<button class="btn btn-info" type="button" id="save_activ" >
						<i class="ace-icon fa fa-check bigger-110"></i>
						{!! trans('fan.save') !!}
					</button>
				</div>
			</div>
		</div>
	</div>
{!! Form::close() !!}
@endsection

														