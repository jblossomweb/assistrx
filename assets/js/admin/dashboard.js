$(document).ready(function() {
	//fill in breadcrumbs
	var source   = $("#breadcrumbs-template").html();
	var breadcrumbs_template = Handlebars.compile(source);
	var context = {
	  breadcrumbs: [
	    {page: "dashboard", title: "Dashboard"}
	  ]
	};
	var html = breadcrumbs_template(context);
	$("#breadcrumbs-container").html(html);

	
});