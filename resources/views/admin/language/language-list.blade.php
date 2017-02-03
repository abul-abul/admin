@extends('app-admin')
@section('content')
	{!! Html::script( asset('js/admin-main.js')) !!}
	{!! Html::script( asset('js/delete-modal.js')) !!}
	{!! Html::script( asset('assets/js/bootstrap-filestyle.js')) !!} 
	{!! Html::script( asset('js/lang-modal.js')) !!}
	 	<style>
			.btn-primary{
				width: 210px!important;
				border-radius:0!important;
			}
		</style>
	<h1>Language List</h1>
	<div class="container">
		<div class="row">
	        <div class="col-md-12">
		        <div class="table-responsive">

		       
		
			<!--//////// static En langugage table -->	

		        	<style>
				   		.btn-primary{
				   			width: 210px!important;
				   			border-radius:0!important;
				   		}
				   	</style>
		    <!-- static En langugage table -->
		       <!--  <table id="mytable" class="table table-bordred table-striped">	   
				   <thead>	   
					   <th>Name</th>
					   <th>Language Files</th>
					   <th>Upload Edited File</th>
				   </thead>
				   <tbody>
				   	<style>
				   		.btn-primary{
				   			width: 210px!important;
				   			border-radius:0!important;
				   		}
				   	</style>
						    <tr style="background-color: rgb(0, 160, 223);">
							    <td><h2>En</h2></td>
							    <td>
							    	<a href="{{action('AdminController@getDownloadEnLang' , 'errors')}}">
								    	<button class="btn btn-primary">
											Download Errors File
										</button>	
									</a><br>
									<a href="{{action('AdminController@getDownloadEnLang' , 'fan'  )}}">
								    	<button class="btn btn-primary">
											Download Fan File
										</button>
									</a><br>
									<a href="{{action('AdminController@getDownloadEnLang' ,  'login'  )}}">
								    	<button class="btn btn-primary">
											Download Login File
										</button>
									</a><br>
									<a href="{{action('AdminController@getDownloadEnLang' ,  'tickets'  )}}">
								    	<button class="btn btn-primary">
											Download Tickets File
										</button>
									</a><br>
									<a href="{{action('AdminController@getDownloadEnLang' ,  'pagination' )}}">
								    	<button class="btn btn-primary">
											Download Pagination File
										</button>
									</a><br>
									<a href="{{action('AdminController@getDownloadEnLang' ,  'reminders'  )}}">
								    	<button class="btn btn-primary">
											Download Reminders File
										</button>
									</a><br>
									<a href="{{action('AdminController@getDownloadEnLang' , 'validation'  )}}">
								    	<button class="btn btn-primary">
											Download Validation File
										</button>
									</a><br>
							    </td>
							    <td>
							    	{!! Form::open(['action' => ['AdminController@postUpdateEnLang']  , 'files' => 'true' , 'class' => 'form-horizontal', 'role' => 'form' ]) !!}
										<p>
											{!! Form::file('name' , [ 'data-input' => 'false', 'class' => 'filestyle']) !!}
											<div class="col-md-offset-3 col-md-9" style="margin:0">
												<button class="btn btn-info" type="submit" id="save_activ" >
													<i class="ace-icon fa fa-check bigger-110"></i>
													{!! trans('fan.save') !!}
												</button>
											</div>
										</p>
							    	{!! Form::close() !!}
							    </td>
						    </tr>
				   </tbody>
				</table> -->
			<!--//////// static En langugage table -->	
				<!-- <h1>More Languages</h1> -->

					<table id="mytable" class="table table-bordred table-striped">	   
					   <thead>	   
						   <th>Name</th>
						   <th>Language Files</th>
						   <th>Upload Edited File</th>
						   <th>Delete Language</th>
						   <th>Edit Language Name</th>
					   </thead>
					   <tbody>
					   <div id="domain_error">
					   			@if (Session::has('message'))
          						<div class="alert alert-success">
                					 {{ Session::get('message') }}   
             					</div>
	             				@else
	             					@include('message')
	          					@endif						
					   </div>
					    @foreach($names as $name)
						 	<tr style="background-color: rgb(230, 227, 234);">
							    <td><h2>{{$name->name}}</h2></td>
							    <td>
							    	<div class="btn-row">
                                  		<div class="btn-group-vertical">
                                  			<a href="{{action('AdminController@getDownloadLangFile' , [$name->id , 'errors' ] )}}">
                                      			<button class="btn btn-primary" type="button">Download Errors File</button>
                                      		</a><br>
                                      		<a href="{{action('AdminController@getDownloadLangFile' , [$name->id , 'fan' ] )}}">
                                      			<button class="btn btn-primary" type="button">Download Fan File</button>
                                      		</a><br>
                                      		<a href="{{action('AdminController@getDownloadLangFile' , [$name->id , 'login' ] )}}">
                                      			<button class="btn btn-primary" type="button">Download Login File</button>
                                      		</a><br>
                                      		<a href="{{action('AdminController@getDownloadLangFile' , [$name->id , 'tickets' ] )}}">
                                      			<button class="btn btn-primary" type="button">Download Tickets File</button>
                                      		</a><br>
                                      		<a href="{{action('AdminController@getDownloadLangFile' , [$name->id , 'pagination' ] )}}">
                                      			<button class="btn btn-primary" type="button">Download Pagination File</button>
                                      		</a><br>
                                      		<a href="{{action('AdminController@getDownloadLangFile' , [$name->id , 'reminders' ] )}}">
                                      			<button class="btn btn-primary" type="button">Download Reminders File</button>
                                      		</a><br>
                                      		<a href="{{action('AdminController@getDownloadLangFile' , [$name->id , 'validation' ] )}}">
                                      			<button class="btn btn-primary" type="button">Download Validation File</button>
                                      		</a><br>
                                  		</div>
                              		</div>
							    </td>
							    <td>
							    	{!! Form::open(['action' => ['AdminController@postEditLanguage' , $name->id ]  , 'files' => 'true' , 'id' => 'uploade_lang_file_form', 'class' => 'form-horizontal', 'role' => 'form' ]) !!}
										<p>
											{!! Form::file('name' , [ 'data-input' => 'false', 'class' => 'filestyle']) !!}
											<div class="col-md-offset-3 col-md-9" style="margin:0">
												<button class="btn btn-info uploade_lang_file" type="button" id="save_activ" >
													<i class="ace-icon fa fa-check bigger-110"></i>
													{!! trans('fan.save') !!}
												</button>
											</div>
										</p>
							    	{!! Form::close() !!}
							    </td>
							    <td>
								    <p data-placement="top" data-toggle="tooltip" title="Delete">
									    <button class="btn btn-danger btn-xs delete"  data-title="Delete" data-toggle="modal" data-target="#delete" alt="{{ csrf_token () }}"  data-href="{{ action('AdminController@getDeleteLanguage' , $name->id) }}" >
										    <span class="glyphicon glyphicon-trash">
										    	
										    </span>
									    </button>
								    </p>
							    </td>
							    <td>
							    	<p data-placement="top" data-toggle="tooltip" title="Edit">
								    	<button class="btn btn-primary btn-xs" data-title="Edit" alt="{{ csrf_token() }}"  data-toggle="modal" data-target="#edit" data="{{$name->id}}">
								    		<span class="glyphicon glyphicon-pencil">
								    			
								    		</span>
								    	</button>
							    	</p>
							    </td>
						    </tr>
					    @endforeach
					    </tbody>
					</table>
		        </div>
	        </div>
		</div>
	</div>
		<!-- Modal Dialog to Edit Domains -->
	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">

	    <div class="modal-dialog">
	    	<div class="modal-content">
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			        	<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			        </button>
			        <h4 class="modal-title custom_align" id="Heading">Edit Language Name</h4>
			        <div id="loading_modal" style="position:absolute;width: 100%;height: 97%;opacity: 1;z-index:5;background-color: #000;height: 100%;opacity: 0.7;top: 0;left: 0px;">
			        	<img src="../images/loading.gif" style="width: 18%;height:50%;position:absolute;top: 39px;left: 41%;">
			        </div>
		        <div class="modal-body">
		        {!! Form::open(['action' => ['AdminController@editLangName'] , 'files' => 'true' , 'data-*' => '' , 'id' => 'langFormUpdate' , 'class' => 'form-horizontal' , 'role' => 'form']) !!}

		          		<span style='display:none' data-action="{{action('AdminController@editLangName', false)}}" id='action_lang'></span> 
				        <div class="form-group">
				        	{!! Form::text('name', null , ['id' => 'lang_name', 'maxlength' => '2', 'class' => 'form-control',  'autocomplete' => 'off' ]) !!}
				        </div>
			    </div>
		      	<div class="modal-footer ">
		      		<button type="submit" class="btn btn-warning btn-lang" style="width: 100%;"  data-href="">
						<span class="glyphicon glyphicon-ok-sign"></span>Update
			        </button>
			    </div>
	        </div>
	        	{!! Form::close() !!}
	    <!-- /.modal-content --> 
	  	</div>
	      <!-- /.modal-dialog -->
	</div>
		<!-- Modal Dialog to delete Domains-->
	
</div>	
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