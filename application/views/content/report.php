<script>
	$(document).ready(function() {
		$('#generate').click(
			function(){
				var from = $('#from_year').val() +'-'+ $('#from_month').val() +'-'+ $('#from_day').val()+' '+$('#from_hour').val() +':'+ $('#from_min').val() +':'+ $('#from_sec').val();
				var to = $('#to_year').val() +'-'+ $('#to_month').val() +'-'+ $('#to_day').val()+' '+$('#to_hour').val() +':'+ $('#to_min').val() +':'+ $('#to_sec').val();
				
				var url = '<?php echo site_url('admin/reports/index')?>/'+from +'/'+ to;
				//alert(url+'/'+from +'/'+ to);
				window.location = url;
			}
		);
	});

</script>

<div id="content">
	
	<?php
		for($i=2010;$i<2025;$i++){
			$years[$i]=$i;
		}
		for($i=1;$i<13;$i++){
			$i = str_pad($i,2,'0',STR_PAD_LEFT);
			$months[$i]=$i;
			
		}
		for($i=1;$i<32;$i++){
			$i = str_pad($i,2,'0',STR_PAD_LEFT);
			$days[$i]=$i;
		}

		for($i=1;$i<24;$i++){
			$i = str_pad($i,2,'0',STR_PAD_LEFT);
			$hours[$i]=$i;
		}
		for($i=1;$i<60;$i++){
			$i = str_pad($i,2,'0',STR_PAD_LEFT);
			$mins[$i]=$i;
		}
		
	?>
	<div style="padding:20px">
	<?php echo form_open();?>
		From (dd-mm-yyyy hh:mm:ss) <?php echo form_dropdown('from_day',$days,'','id="from_day"').'-'.form_dropdown('from_month',$months,'','id="from_month"').'-'.form_dropdown('from_year',$years,'','id="from_year"')?>
		<?php echo form_dropdown('from_hour',$hours,'','id="from_hour"').':'.form_dropdown('from_min',$mins,'','id="from_min"').':'.form_dropdown('from_sec',$mins,'','id="from_sec"')?>
		<br /><br />
		To (dd-mm-yyyy hh:mm:ss) <?php echo form_dropdown('to_day',$days,'','id="to_day"').'-'.form_dropdown('to_month',$months,'','id="to_month"').'-'.form_dropdown('to_year',$years,'','id="to_year"')?>
		<?php echo form_dropdown('to_hour',$hours,'','id="to_hour"').':'.form_dropdown('to_min',$mins,'','id="to_min"').':'.form_dropdown('to_sec',$mins,'','id="to_sec"')?>
		<?php echo form_button('generate','generate','id="generate"');?>
	<?php echo form_close();?>
	</div>
	<?php if($from == null):?>
		<img src="<?=site_url('admin/reports/bw/tcp')?>" id="tcp_graph" /><br />
		<img src="<?=site_url('admin/reports/bw/udp')?>" id="udp_graph" /><br />
	<?php else:?>
		<img src="<?=site_url('admin/reports/bw/tcp/'.$from.'/'.$to)?>" id="tcp_graph" /><br />
		<img src="<?=site_url('admin/reports/bw/udp/'.$from.'/'.$to)?>" id="udp_graph" /><br />
	<?php endif;?>
		
</div> <!-- #content -->

