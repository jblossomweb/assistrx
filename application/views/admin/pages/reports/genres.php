<!--Start Breadcrumb -->
<div id="breadcrumbs-container"></div>
<!--End Breadcrumb-->
<?php $this->load->view('admin/templates/blocks/guts-loader');?>

<div class="row" id="guts" style="display:none;">

	<?php foreach ($groups as $i=>$group): ?>
	<div class="col-xs-12 col-sm-4">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<img style="width:20px" width="20" src="http://www.cornify.com/getacorn.php?r=<?php echo time()+$i;?>" />
					<span><?php echo $group['name'];?></span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content piechart-content">
				<div class="piechart-json" style="display:none;"><?php echo json_encode($group['data']);?></div>
				<canvas class="piechart" id="piechart-<?php echo $i;?>"></canvas>
				<div class="piechart-legend" id="piechart-legend-<?php echo $i;?>"></div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>


</div>
<div style="height: 40px;"></div>
<script id="piechart-legend-template" type="text/x-handlebars-template">
	<?php $this->load->view('admin/templates/piechart-legend');?>
</script>

<script type="text/javascript">
// based on: https://github.com/bebraw/Chart.js.legend/blob/master/src/legend.js
function piechart_legend(parent, data) {
    //parent.className = 'piechart-legend';
    var datas = data.hasOwnProperty('datasets') ? data.datasets : data;
    // remove possible children of the parent
    while(parent.hasChildNodes()) {
        parent.removeChild(parent.lastChild);
    }

    var legend = $("#"+parent.getAttribute('id'));
    var source   = $("#piechart-legend-template").html();
	var template = Handlebars.compile(source);
	var html = template(datas);
	legend.html(html);
}
$(document).ready(function() {


	$.getScript('/assets/js/admin/guts-global.js', function(){
		// load breadcrumbs
		loadCrumbs([
		    {page: "reports", title: "Reports"},
		    {page: "reports/genres", title: "Age Genres"}
		 ]);
		loadGuts();
		
		WinMove();

		var options = {
		    animateScale: true
		};
		var piechart = [];
		$("canvas.piechart").each( function(idx,el){
			var id = $(this).attr('id');
			//todo: ajax this instead 
			var data = $.parseJSON($(this).prev('.piechart-json').html());
			var ctx = document.getElementById(id).getContext("2d");
			piechart[idx] = new Chart(ctx).Pie(data,options);
			piechart_legend($(this).next('.piechart-legend').get(0), data);
		});
		
	});		
});
</script>