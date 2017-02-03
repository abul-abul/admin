{!! Html::script( asset('js/admin-main.js')) !!}
{!! Form::open(['action' => ['AdminController@postAddLanguage'] ,'files' => 'true' ,'id' => 'language_add_form', 'class' => 'form-horizontal', 'role' => 'form' ]) !!}
	<div class="container">
	    <div class="row clearfix">
			<div class="col-md-12 column">
				<table class="table table-bordered table-hover" id="tab_logic">
					<thead>
						<tr>
							<th class="text-center">
								Language
							</th>
						</tr>
					</thead>
					<tbody>
						<div id="domain_error">
							@foreach($errors->all() as $error)
								<p>{{ $error }}</p>
							@endforeach
						</div>
						<tr id='addr0'>
							<td>
								{!! Form::text('name', null, ['id' => 'language_add', 'maxlength' => '2', 'class' => 'form-control',  'autocomplete' => 'off']) !!}
							</td>
						</tr>
	                    <tr id='addr1'></tr>
					</tbody>
				</table>
				<div class="clearfix form-actions">

				</div>
				<div class="col-md-offset-3 col-md-9" style="margin:0">
					<button class="btn btn-info" type="button" id="add_lang" >
						<i class="ace-icon fa fa-check bigger-110"></i>
						{!! trans('fan.save') !!}
					</button>
				</div>
			</div>
		</div>
	</div>
{!! Form::close() !!}


														