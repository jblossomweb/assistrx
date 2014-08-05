<?php foreach($templates as $tmpl): ?>
<script id="<?php echo $tmpl;?>-template" type="text/x-handlebars-template">
<?php $this->load->view('admin/templates/'.$tmpl);?>
</script>
<?php endforeach;?>
<?php /* manually:
<script id="mytemplate-template" type="text/x-handlebars-template">
<?php $this->load->view('admin/templates/mytemplate');?>
</script>
*/ ?>