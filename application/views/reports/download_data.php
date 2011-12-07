<style>
	#dialog_box{
		background: #FFF;
		font: 12px/1.7em arial,sans-serif;
	}
	
	#dialog_box h3{
		font-size:16px;
		font-weight:bold;
	}
</style>
<?php
	for($i=2010;$i<2025;$i++){
		$years[$i]=$i;
	}
	for($i=1;$i<13;$i++){
		$months[$i]=$i;
	}
	for($i=1;$i<32;$i++){
		$days[$i]=$i;
	}
	
?>
<div style="padding:20px" id="dialog_box">
<h3>Download <?php print $title;?></h3>
<?php echo form_open('admin/reports/download/'.$table_name);?>
	<?php echo form_hidden('table_name',$table_name);?>
	
	From (d/m/y) <?php echo form_dropdown('from_day',$days).' '.form_dropdown('from_month',$months).' '.form_dropdown('from_year',$years)?>
	To (d/m/y) <?php echo form_dropdown('to_day',$days).' '.form_dropdown('to_month',$months).' '.form_dropdown('to_year',$years)?>
	<?php echo form_submit('pdf','PDF');?>
	<?php echo form_submit('csv','CSV');?>
<?php echo form_close();?>
<?php 
	if($message){
		print $message;
	}
?>
</div>