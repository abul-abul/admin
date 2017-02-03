@extends('app-admin')
@section('content')
{!! Html::script( asset('js/admin-main.js')) !!}
{!! Html::script( asset('js/delete-modal.js')) !!}
	<h1>Domain Languages</h1> 
	<h3 style='color:red;font-style:italic;'>
		{{$subDomain}}
	</h3>
	<div class="container" style="float:left">
		<div class="row">
	        <div class="col-md-12">
		        <div class="table-responsive">
					<table id="mytable" class="table table-bordred table-striped" style="width: 16%;">	   
					   <thead>	   
						   <th>Domain Languages </th>
						   <th>Delete Languages </th>
					   </thead>
					   <tbody>
					    @foreach($domainLangs as $domainLang)
						 	<tr style="background-color: rgb(230, 227, 234);">
							    <td><h2 style="margin:0">{{$domainLang->name}}</h2></td>
							    <td>
								    <p data-placement="top" data-toggle="tooltip" title="Delete">
									    <button class="btn btn-danger btn-xs delete" data-title="Delete" data-toggle="modal" data-target="#delete"  data-href="{{ action('AdminController@getDeleteDomainLanguage' , [ $domainId ,$domainLang->id]) }}">
										    <span class="glyphicon glyphicon-trash">
										    	
										    </span>
									    </button>
								    </p>
							    </td>
							    <td>
							    		
							    </td>
						    </tr>
					    @endforeach
					    </tbody>
					</table>
		        </div>
	        </div>
		</div>
	</div>
	<div>
		{!! Form::open(['action' => ['AdminController@postAddDomainLang' , $domainId] ,'files' => 'true' , 'id' => 'language_add','class' => 'form-horizontal', 'role' => 'form' ]) !!}
			<div class="form-group">
				{!! Form::label('language', 'Select Language', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
				<div class="col-sm-9">
					{!! Form::select('language' , $language , ['id' => 'filter_category', 'class' => 'col-xs-10 col-sm-5']) !!}	
				</div>

			</div>
			<div class="col-md-offset-3 col-md-9">
				<button id='add_user' class="btn btn-info language_button_add" type="button">
					<i class="ace-icon fa fa-check bigger-110"></i>
						Save
				</button>
			</div>
		{!!Form::close()!!}
	</div>	
			<!-- Modal Dialog to delete Domains-->
	<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
	  	<div class="modal-dialog">
		    <div class="modal-content">
	            <div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
		        	<h4 class="modal-title custom_align" id="Heading">Delete this language</h4>
		        </div>
			    <div class="modal-body">
			       <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
			    </div>
			    <div class="modal-footer ">
			    	<a class='yes' href='#'><button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span>Yes</button></a>
			        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
			    </div>
		    </div>
	    <!-- /.modal-content --> 
	  	</div>
	  <!-- /.modal-dialog --> 
	</div>
@endsection