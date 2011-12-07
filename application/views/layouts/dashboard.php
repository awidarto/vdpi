<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml"> 
 
<head> 
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" /> 
	<title>Dashboard | Dashboard Admin</title> 
	
	<?php $this->tf_assets->render_css(); ?>
    <?php $this->tf_assets->render_js(); ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head> 
<script>
	$(document).ready(function() {
		$('.uribox').fancybox({
			maxWidth	: 800,
			maxHeight	: 600,
			fitToView	: false,
			width		: '70%',
			height		: '70%',
			autoSize	: false,
			closeClick	: false,
			openEffect	: 'elastic',
	    	openEasing : 'easeOutBack',
	    	closeEffect	: 'elastic',
			closeEasing : 'easeInBack',
		});
	});
	
	function triggerRefresh(){
		$('#ajax_refresh_and_loading').trigger('click');
		//setTimeout('triggerRefresh()', 1000);
	}
	$(document).ready(function() {
		if($('#ajax_refresh_and_loading').length > 0){
			triggerRefresh();
		}
	});
	
	
	
</script>
 
<body> 
<div id="test"></div>
<div id="wrapper">
<?php $this->tf_assets->render_partial('dash_top'); ?>
<?php $this->tf_assets->render_partial('dash_header'); ?>

<?php $this->tf_assets->render_content(); ?>
<div style="clear:both;"></div>
	
</div> <!-- #wrapper -->
<?php $this->tf_assets->render_partial('dash_footer'); ?>

</body> 
 
</html>