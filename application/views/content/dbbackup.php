<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/grocery_crud/themes/flexigrid/css/flexigrid.css">
<div class="flexigrid" style="width: 100%;">
	<div class="mDiv">
		<div class="ftitle">
			Back Ups		
		</div>
	</div>
	<div id="main-table-box">
		<div id="ajax_list"><div class="bDiv">
			<?php
			echo $this->table->generate();
			?>
		</div>
	</div>
</div>