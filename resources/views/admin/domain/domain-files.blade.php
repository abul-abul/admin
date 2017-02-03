@extends('app-admin')
@section('content')
{!! Html::script( asset('js/admin-main.js')) !!}
	<h1>Domain Files</h1>
	<table id="mytable" class="table table-bordred table-striped" style="width:25%">	   
	   <thead>	   
		   <th>Files Upload Done</th>
		   <th>Delete</th>
	   </thead>
	   <tbody>
	   		@foreach($files as $file)
		 	<tr>
			    <td class="row_domain">{{$file->file_name}}</td>
				<td>
					<p data-placement="top" data-toggle="tooltip" title="Delete">
						<button class="btn btn-danger btn-xs delete" data-title="Delete" data-toggle="modal" data-target="#delete"  data-href="{{ action('AdminController@getDeleteDomainFiles' , [$file->id , $domainId]) }}">
							<span class="glyphicon glyphicon-trash">
														    	
							</span>
						</button>
					</p>
				</td>
		    </tr>
		    			
		    @endforeach	   
	    </tbody>
	</table>
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