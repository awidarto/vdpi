<script>
	$(document).ready(function() {
		

	});

	function loadImage(){
		
	}
</script>

<div id="content">
	
	<?php
		for($i=2010;$i<2025;$i++){
			$years[]=$i;
		}
		for($i=1;$i<13;$i++){
			$months[]=$i;
		}
		for($i=1;$i<32;$i++){
			$days[]=$i;
		}

		for($i=1;$i<24;$i++){
			$hours[]=$i;
		}
		for($i=1;$i<60;$i++){
			$mins[]=$i;
		}
		
	?>
	<div style="padding:20px">
	<?php echo form_open();?>
		From <?php echo form_dropdown('from_year',$years).'-'.form_dropdown('from_month',$months).'-'.form_dropdown('from_day',$days)?>
		<?php echo form_dropdown('from_hour',$hours).':'.form_dropdown('from_min',$mins).':'.form_dropdown('from_sec',$mins)?>
		<br /><br />
		To <?php echo form_dropdown('to_year',$years).'-'.form_dropdown('to_month',$months).'-'.form_dropdown('to_day',$days)?>
		<?php echo form_dropdown('to_hour',$hours).':'.form_dropdown('to_min',$mins).':'.form_dropdown('to_sec',$mins)?>
		<?php echo form_button('generate','generate');?>
	<?php echo form_close();?>
	</div>
	<img src="<?=site_url('admin/reports/bw/tcp')?>" id="tcp_graph" /><br />
	<img src="<?=site_url('admin/reports/bw/udp')?>" id="udp_graph" /><br />
</div> <!-- #content -->

