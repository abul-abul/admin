$(document).ready(function(){
	$('.delete').click(function(){
		var url = $(this).attr('data-href');
		$('.yes').attr('href',url);
	});


});