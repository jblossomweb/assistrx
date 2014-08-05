$(function(){
	
	if(!WURFL.is_mobile){
		$("input[name='username']").focus();
	}
	
	$('#btnLogin').click(function(){
		var username = $("input[name='username']").val();
		var password = $("input[name='password']").val();
		validateUser(username, password);
		return false;
	});
	
});

function validateUser(username, password){
	//call the validate service

	console.log('validateUser('+username+', '+password+')');

	$.ajax({
		async: false,
		url: '/admin/validate_user',
		type: 'post',
		dataType: 'json',
		data: {username: username, password: password},
		success: function(res){
			if(res.status == 'OK'){
				// User has been validated. Redirect to dashboard.
				window.location.href='/admin/dashboard';
			}else if(res.status == 'ERROR'){
				console.log('Ajax error: '+res.error_msg);
				console.log(res);
			}else{
				console.log('Ajax error. Invalid status.');
				console.log(res);
			}
		},
        error: function(res){
        	console.log('Ajax error. Invalid json.');
        	console.log(res);
        }
	});
}