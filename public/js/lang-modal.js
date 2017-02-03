$(document).ready(function(){
	$(".btn-xs").click(function(){
		window.id = $(this).attr('data');
		var token = $(this).attr('alt');
		$.ajax({
			type:'post',
			url:'language-modal-valaue/' + id,
			data:{id:id,_token:token},
			beforeSend:function(){
       			 $("#loading_modal").css("display","block")
     		},
			success:function(data){
				$('#lang_name').val(data.name.name);
				$("#loading_modal").css("display","none")
			}

		})
	})
	$(".btn-lang").click(function(){
		var data_action = $('#action_lang').attr('data-action');
		var action = data_action + '/' + id;
		$("#langFormUpdate").attr("action",action);
	})
})