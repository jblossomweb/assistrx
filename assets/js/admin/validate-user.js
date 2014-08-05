var validateUser = function(){
	var form = $(form_selector);
	var inputs = $(form_selector+" :input");
	var btn = $(form_selector+' button.submit');
	var cancel = $(form_selector+' button.cancel');
	var spinner = $(form_selector+' .fa-spin');

	cancel.click(function(e){
		e.preventDefault();
		LoadAjaxContent('/admin/ajax/users');
	});

	form.bootstrapValidator({
		message: 'This value is not valid',
		fields: {
			username: {
				message: 'Please enter a valid User Name',
				validators: {
					notEmpty: {
						message: 'The User Name is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The User Name must be between 1-50 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\.\- ]+$/,
						message: 'No special characters, please. Letters, Numbers, Space, Dot, Dash or Underscore'
					}
				}
			},
			password: {
				message: 'Please enter a valid password',
				validators: {
					notEmpty: {
						message: 'The password is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The password must be between 1-50 characters long'
					}
				}
			},
			client_id: {
				message: 'Please select a Client',
				validators: {
					notEmpty: {
						message: 'The Client is required and cannot be empty'
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'Please select a Client'
					}
				}
			},
			email: {
				message: 'Please enter a valid email',
				validators: {
					notEmpty: {
						message: 'The email is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The email must be between 1-50 characters long'
					},
					emailAddress: {
                        message: 'Please enter a valid email address'
                    }
				}
			},
			fname: {
				message: 'Please enter a valid First Name',
				validators: {
					notEmpty: {
						message: 'The First Name is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The First Name must be between 1-50 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\.\- ]+$/,
						message: 'No special characters, please. Letters, Numbers, Space, Dot, Dash or Underscore'
					}
				}
			},
			lname: {
				message: 'Please enter a valid Last Name',
				validators: {
					notEmpty: {
						message: 'The Last Name is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The Last Name must be between 1-50 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\.\- ]+$/,
						message: 'No special characters, please. Letters, Numbers, Space, Dot, Dash or Underscore'
					}
				}
			}
			// ,
			// phone: {
			// 	message: 'Please enter a valid phone (numbers only)',
			// 	validators: {
			// 		notEmpty: {
			// 			message: 'Please enter a valid phone (numbers only)'
			// 		},
			// 		regexp: {
			// 			regexp: /^[0-9]+$/,
			// 			message: 'Please enter a valid phone (numbers only)'
			// 		}
			// 	}
			// }
			
		},
		submitHandler: function(){
			inputs.prop("disabled", true);
			spinner.show();

			var raw_phone = form.find(":input[name='phone']").val();
			var phone = raw_phone.replace(/\D/g,'');

			form.ajaxSubmit({
				data: {
					id: 		form.find(":input[name='id']").val(), 
					username: 	form.find(":input[name='username']").val(),
					password: 	form.find(":input[name='password']").val(), 
					client_id: 	form.find(":input[name='client_id']").val(),
					email: 		form.find(":input[name='email']").val(),
					fname: 		form.find(":input[name='fname']").val(),
					lname: 		form.find(":input[name='lname']").val(),
					groups: 	form.find(":input[name='groups']").val(),
					email_alert_status: form.find(":input[name='email_alert_status']").is(':checked') ? 1 : 0,
					sms_alert_status: form.find(":input[name='sms_alert_status']").is(':checked') ? 1 : 0,
					carrier_id: form.find(":input[name='sms_alert_status']").is(':checked') ? form.find(":input[name='carrier_id']").val() : null,
					phone: form.find(":input[name='sms_alert_status']").is(':checked') ? phone : null
				},
				success: function(data) { 
					//alert(data);
					console.log(data);
					data = $.parseJSON(data);
			        console.log(data);
			        spinner.hide();
			        //form.fadeOut("fast");
			        LoadAjaxContent('/admin/ajax/users/edit?id='+data.id);
			    }
		    });
		}
	}); 
};