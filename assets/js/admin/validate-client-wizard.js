var validateClientWizard = function(){
	var form = $(form_selector);
	var inputs = $(form_selector+" :input");
	var btn = $(form_selector+' button.submit');
	var cancel = $(form_selector+' button.cancel');
	var spinner = $(form_selector+' .fa-spin');

	cancel.click(function(e){
		e.preventDefault();
		LoadAjaxContent('/admin/ajax/clients');
	});

	form.bootstrapValidator({
		message: 'This value is not valid',
		fields: {
			name: {
				message: 'Please enter a valid Client Name',
				validators: {
					notEmpty: {
						message: 'The Client Name is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The Client Name must be between 1-50 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\.\- ]+$/,
						message: 'No special characters, please. Letters, Numbers, Space, Dot, Dash or Underscore'
					}
				}
			},
			sales_order: {
				message: 'Please enter a valid sales order number from SAP',
				validators: {
					notEmpty: {
						message: 'Please enter a valid sales order number from SAP'
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'Please enter a valid sales order number from SAP'
					}
				}
			},
			package: {
				message: 'Please select a valid Package',
				validators: {
					notEmpty: {
						message: 'The Package is required and cannot be empty'
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'Please select a valid Package'
					}
				}
			},
			expires: {
				message: 'Please enter a valid Expire Date',
				validators: {
					notEmpty: {
						message: 'The Expire Date is required and cannot be empty'
					},
					regexp: {
						regexp: /^[0-9\/]+$/,
						message: 'Please enter a valid Expire Date'
					}
				}
			},
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
			form.ajaxSubmit({
				data: {
					id: 		form.find(":input[name='id']").val(), 
					name: 		form.find(":input[name='name']").val(), 
					sales_order: form.find(":input[name='sales_order']").val(), 
					package: 	form.find(":input[name='package']").val(),
					expires: 	form.find(":input[name='expires']").val(),
					active: 	form.find(":input[name='active']").is(':checked') ? 1 : 0
				},
				success: function(data) { 
					data = $.parseJSON(data);
			        console.log(data);
			        spinner.hide();
			        //form.fadeOut("fast");
			        LoadAjaxContent('/admin/ajax/clients/edit?id='+data.id);
			    }
		    });
		}
	}); 
};