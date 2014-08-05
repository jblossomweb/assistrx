<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Home</a></li>
			{{#each breadcrumbs}}
			<li><a style="cursor:pointer;" onclick="LoadAjaxContent('/admin/ajax/{{page}}');">{{title}}</a></li>
			{{/each}}
		</ol>
	</div>
</div>