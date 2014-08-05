var validateComplex = function(){
	var form = $(form_selector);
	var inputs = $(form_selector+" :input");
	var btn = $(form_selector+' button.submit');
	var cancel = $(form_selector+' button.cancel');
	var spinner = $(form_selector+' .fa-spin');

	cancel.click(function(e){
		e.preventDefault();
		LoadAjaxContent('/admin/ajax/complexes');
	});

	form.bootstrapValidator({
		message: 'This value is not valid',
		fields: {
			token: {
				message: 'Please enter a valid Token',
				validators: {
					notEmpty: {
						message: 'The Token is required and cannot be empty'
					},
					stringLength: {
						min: 12,
						max: 45,
						message: 'The Token must be at least 12 digits'
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'The Token must be numeric'
					}
				}
			},
			accesskey: {
				message: 'Please enter a valid Access Key',
				validators: {
					notEmpty: {
						message: 'The Access Key is required and cannot be empty'
					},
					stringLength: {
						min: 24,
						max: 64,
						message: 'The Access Key must be between 24-64 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9]+$/,
						message: 'The Access Key must be alpha-numeric'
					}
				}
			},
			poller_loc: {
				message: 'Please enter a valid Poller Location',
				validators: {
					notEmpty: {
						message: 'The Poller Location is required and cannot be empty'
					},
					stringLength: {
						min: 10,
						max: 10,
						message: 'The Poller Location must be 10 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_]+$/,
						message: 'The Poller Location must be alpha-numeric with underscore'
					}
				}
			},
			poller_loc_id: {
				message: 'Please enter a valid Poller Location ID',
				validators: {
					notEmpty: {
						message: 'The Poller Location ID is required and cannot be empty'
					},
					stringLength: {
						min: 8,
						max: 11,
						message: 'The Poller Location ID must be between 8-11 digits'
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'The Poller Location ID must be numeric'
					}
				}
			},
			name: {
				message: 'Please enter a valid Complex Name',
				validators: {
					notEmpty: {
						message: 'The Complex Name is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The Complex Name must be between 1-50 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\.\- ]+$/,
						message: 'No special characters, please. Letters, Numbers, Space, Dot, Dash or Underscore'
					}
				}
			},
			total_auds: {
				message: 'Please enter total auditoriums',
				validators: {
					notEmpty: {
						message: 'Total auditoriums is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 10,
						message: 'Total auditoriums must an integer between 1-10 digits'
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'Total auditoriums must be numeric'
					}
				}
			},
			timezone_id: {
				message: 'Please select a valid time zone',
				validators: {
					notEmpty: {
						message: 'Time zone is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 10,
						message: 'Please select a valid time zone'
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'Please select a valid time zone'
					}
				}
			},
			client_id: {
				message: 'Please select a valid Cielo Client',
				validators: {
					notEmpty: {
						message: 'Cielo Client is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 10,
						message: 'Please select a valid Cielo Client'
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'Please select a valid Cielo Client'
					}
				}
			}
			
		},
		submitHandler: function(){
			inputs.prop("disabled", true);
			spinner.show();
			form.ajaxSubmit({
				data: {
					id: 		form.find(":input[name='id']").val(), 
					token: 		form.find(":input[name='token']").val(),
					accesskey: 	form.find(":input[name='accesskey']").val(),
					poller_loc: form.find(":input[name='poller_loc']").val(),
					poller_loc_id: form.find(":input[name='poller_loc_id']").val(),
					name: 		form.find(":input[name='name']").val(),
					total_auds: form.find(":input[name='total_auds']").val(),
					timezone_id: form.find(":input[name='timezone_id']").val(),
					client_id: form.find(":input[name='client_id']").val()
				},
				success: function(data) { 
			        console.log(data);
			        spinner.hide();
			        //form.fadeOut("fast");
			        LoadAjaxContent('/admin/ajax/complexes');
			    }
		    });
		}
	}); 
};