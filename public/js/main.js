

$(function(){
		$("div[id^='chatUser']").click(function(event) {
			event.preventDefault();
			var test = $(this).attr('id');
			var num = test.split('-');
			var nume = num[1]; //console.log(nume);
			uploadNewMessages(nume, function(){
				$("div[id^='chat-']").slideUp();
				$('#chat-'+nume).slideDown();
				$('#count-'+nume).css('display','none');		
			});

		});

})

function uploadNewMessages(userid, callback) {
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		//url: "http://localhost/laravel/virtualCamoma/app/http/uploadMessages",
		url: "uploadMessages",
		dataType: 'json',
		type: 'POST',
		data: {
			userid: userid,
			_token: CSRF_TOKEN
		},
		success: function(data) {
				console.log('saved');
		},
		error: function(){
			callback();
		}
	});
}