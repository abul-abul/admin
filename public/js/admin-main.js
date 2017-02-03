$(document).ready(function(){
	$('.delete').click(function(){
		var url = $(this).attr('data-href');
		$('.yes').attr('href',url);
	});
	$(".btn-xs").click(function(){
		window.id = $(this).attr('data');
		var token = $(this).attr('alt');

		$.ajax({
			type:"POST",
			url: '/modal-value/' + id +'/edit',
			datatype:'json',
			beforeSend:function(){
        		$("#loading_modal").css("display","block")
      		},
			data:{id:id , _token:token},
			success: function(data){
				$('#sub_domain').val(data.domain.sub_domain);
		  		$('#client_id').val(data.domain.client_id);
		  		$('#client_secret').val(data.domain.client_secret);
				$('#fan_title').val(data.domain.fan_title);
		  		$('#ticket_title').val(data.domain.ticket_title);
		  		$('#language').find("option[value='"+data.domain.language+"']").attr("selected","selected");
		  		$("#loading_modal").css("display","none");

			}
		})

	})
	
	$(".btn-lg").click(function(){
		var data_action = $('#action').attr('data-action');
		var action = data_action + '/' + id;
		$("#modalForm").attr("action",action);
	})
	$(".domain_list_button").click(function(){
		$("#domain_list").submit();
		$(this).attr("disabled","disabled");
	})
	$(".language_button_add").click(function(){
		$(this).attr("disabled","disabled");
		$("#language_add").submit();
	})
	$("#save_activ").click(function(){
		$(this).attr("disabled","disabled");
		$("#add_domain").submit();
	})
	$("#add_lang").click(function(){
		$(this).attr("disabled","disabled");
		$("#language_add_form").submit();
	})
	$(".uploade_lang_file").click(function(){
		$(this).attr("disabled","disabled");
		$("#uploade_lang_file_form").submit();
	})
	$(".lang_update_modal").click(function(){
		$(this).attr("disabled","disabled");
		$("#langFormUpdate").submit();
	})
	

});