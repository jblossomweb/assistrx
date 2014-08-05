function loadCrumbs(crumbs){
	var source   = $("#breadcrumbs-template").html();
	var breadcrumbs_template = Handlebars.compile(source);
	var context = {
	  breadcrumbs: crumbs
	};
	var html = breadcrumbs_template(context);
	$("#breadcrumbs-container").html(html);
}
function loadGuts(){
	$("#guts-loader").hide();
	$("#guts").slideDown("fast");
}
function renderTemplate(src,target,data){
	var source   = $(src).html();
	var template = Handlebars.compile(source);
	var html = template(data);
	$(target).html(html);	
}