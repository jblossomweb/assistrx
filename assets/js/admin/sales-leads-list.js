$(document).ready(function() {
	//fill in breadcrumbs
	var source   = $("#breadcrumbs-template").html();
	var breadcrumbs_template = Handlebars.compile(source);
	var context = {
	  breadcrumbs: [
	    {page: "sales-leads/list", title: "Sales Leads"}
	  ]
	};
	var html = breadcrumbs_template(context);
	$("#breadcrumbs-container").html(html);


	$("button.download-excel").click(function(){

		var url = "/admin/ajax/sales-leads/export";

		$.getScript('/assets/js/jquery.fileDownload.min.js', function(){
			//var $preparingFileModal = $("#preparing-file-modal");
	        //$preparingFileModal.dialog({ modal: true });
	        // $.fileDownload(url, {
	        //     successCallback: function (url) {
	        //     	alert('success');
	        //         //$preparingFileModal.dialog('close');
	        //     },
	        //     failCallback: function (responseHtml, url) {
	        //     	alert('fail');
	        //         //$preparingFileModal.dialog('close');
	        //         //$("#error-modal").dialog({ modal: true });
	        //     }
	        // });

			// todo: find out why we don't get a callback
			// for now: just download without modal 
			$.fileDownload(url);

		});
	});

	
});