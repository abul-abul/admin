@extends('app-admin')
@section('content')	 
{!! Html::script( asset('js/admin-main.js')) !!}
{!! Html::script( asset('assets/js/bootstrap-filestyle.js')) !!} 	
	<section class="panel">
        <header class="panel-heading">
            Domain List
        </header>
        
        <table class="table table-striped table-advance table-hover">
         <tbody>
            <tr>
               <th>Domain</th>
               <th>Css</th>
               <th>Client id</th>
               <th>Client secret</th>
               <th>Favicon</th>
               <th>Ticket Title</th>
               <th>Fan Title</th>
               <th>Add Domain File</th>
               <th>Domain Files List</th>
               <th>Add Domain Languages</th>
               <th>Edit/Delete</th>
              

            </tr>
         
          @foreach($domains as $domain)
			<tr>
			   		<td class="row_domain" data="{{$domain->sub_domain}}">{{$domain->sub_domain}}</td>
			   		<td class="row_css" data="{{$domain->css}}">{{$domain->css}}</td>
			   		<td>{{$domain->client_id}}</td>
			   		<td>{{$domain->client_secret}}</td>
			   		<td>{{$domain->favicon}}</td>
			   		<td>{{$domain->ticket_title}}</td>
			   		<td>{{$domain->fan_title}}</td>
			   		<td>
				    	{!! Form::open(['action' => ['AdminController@postAddFile' , $domain->id ] , 'files' => 'true' ,'id' => 'domain_list',   'class' => 'form-horizontal' , 'role' => 'form' , 'style' => 'float:left;']) !!}
				    		{!! Form::file('file', array('id' => 'input-1a','style' => 'float:left;' )) !!}
				    		<button class="btn btn-info domain_list_button" type="button">
								<i class="ace-icon fa fa-check bigger-110"></i>
								{!! trans('fan.add_files') !!}
							</button>
				    	{!! Form::close() !!}
			   		</td>
			    <td>
			    	<a href="{{action('AdminController@domainFiles' , $domain->id)}}">
				    	<button class="btn btn-warning">
							Domain Files
						</button>
					</a>
			    </td>
			    <td>
			    	<a href="{{action('AdminController@getdomainLanguage' , $domain->id)}}">
				    	<button class="btn btn-success">
							Add Domain Language 
						</button>
					</a>
			    </td>
			    <td>
			    	<p data-placement="top" data-toggle="tooltip" title="Edit">
				    	<button class="btn btn-primary btn-xs" data-title="Edit" alt="{{ csrf_token () }}"  data-toggle="modal" data-target="#edit" data="{{$domain->id}}">
				    		<span class="glyphicon glyphicon-pencil">
				    			
				    		</span>
				    	</button>
				    	<button class="btn btn-danger btn-xs delete" data-title="Delete" data-toggle="modal" data-target="#delete"  data-href="{{ action('AdminController@deleteDomain',$domain->id) }}">
						    <span class="glyphicon glyphicon-trash">
						    	
						    </span>
					    </button>
			    	</p>
				</td>
			</tr>   
		@endforeach  						  
								    
		 </tbody>
      </table>
    </section>									
									
  		
            
          
           
           
           
           
                                        
        
		<!-- Modal Dialog to Edit Domains -->
	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">

	    <div class="modal-dialog">
	    	<div id="domain_error">
				@if (Session::has('message'))
          			<div class="alert alert-success">
                		{{ Session::get('message') }}   
             		</div>
             		@else
             			@include('message')
          			@endif
			</div>
	    	<div class="modal-content">
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			        	<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			        </button>
			        <h4 class="modal-title custom_align" id="Heading">Edit Domain</h4>
			        <div id="loading_modal" style="position:absolute;width: 100%;height: 97%;opacity: 1;z-index:5;background-color: #000;height: 100%;opacity: 0.7;top: 0;left: 0px;">
			        	<img src="../images/loading.gif" style="width: 21%;height: 17%;position:absolute;top: 37%;left: 37%;">
			        </div>
		      	</div>
		        <div class="modal-body">
		          	{!! Form::open(['action' => ['AdminController@editDomain'] , 'files' => 'true' , 'data-*' => '' , 'id' => 'modalForm' , 'class' => 'form-horizontal' , 'role' => 'form']) !!}
		          		<span style='display:none' data-action="{{action('AdminController@editDomain', false)}}" id='action'></span> 
				        <div class="form-group">
				        	{!! Form::text('sub_domain', null , ['id' => 'sub_domain',  'class' => 'form-control',  'autocomplete' => 'off' ]) !!}
				        </div>
				        	
				        <div class="form-group">
				        	<span>Css</span>{!! Form::file('css',  array('id' => 'css' , 'class' => 'filestyle' , 'data-input' => 'false')) !!}
				        </div>

				        <div class="form-group">
				        	<span>Favicon</span>{!! Form::file('favicon', array('id' => 'favicon' , 'class' => 'filestyle' , 'data-input' => 'false')) !!}
				        </div>
				        <div class="form-group">
				        	<span>Client id</span>{!! Form::text('client_id', null, array('id' => 'client_id' , 'class' => 'form-control' , 'autocomplete' => 'off' )) !!}
				        </div>
				        <div class="form-group">
				        	<span>Client Secret</span>{!! Form::text('client_secret', null, array('id' => 'client_secret' , 'class' => 'form-control' , 'autocomplete' => 'off' )) !!}
				        </div>
				        <div class="form-group">
				        	<span>Fan Title</span>{!! Form::text('fan_title', null, array('id' => 'fan_title' , 'class' => 'form-control' , 'autocomplete' => 'off' )) !!}
				        </div>
				        <div class="form-group">
				        	<span>Ticket Title</span>{!! Form::text('ticket_title',null,['id' => 'ticket_title' , 'class' => 'form-control', 'autocomplete' => 'off' ]) !!}
				        </div>
				        <div class="form-group">
				        	<span>Language </span> {!! Form::select('language', $lang , null, [ 'id' => 'language' ]) !!}
				        </div>
			    </div>
			   <!--  <div class="modal-backdrop"></div> -->
		      	<div class="modal-footer ">
		      		<button type="submit" class="btn btn-warning btn-lg" style="width: 100%;"  data-href="">
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
	<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
	  	<div class="modal-dialog">
		    <div class="modal-content">
	            <div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
		        	<h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
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