<script>
	var lasttimetcp = 0;
	$(document).ready(function() {

	    chart_tcp = new Highcharts.Chart({
	        chart: {
	            renderTo: 'container_tcp',
	            events: {
	                load: requestDataTCP
	            }
	        },
	        title: {
	            text: 'TCP Bandwidth'
	        },
	        xAxis: {
	            type: 'datetime',
	            tickPixelInterval: 150,
	            maxZoom: 20 * 1000
	        },
	        yAxis: {
	            minPadding: 0.2,
	            maxPadding: 0.2,
	            title: {
	                text: 'Value',
	                margin: 80
	            }
	        },
	        series: [{
	            name: 'TCP',
	            data: []
	        }]
	    });
	        
	});

	function requestDataTCP() {
	    $.ajax({
	        url: '<?=site_url('admin/home/sess');?>/'+lasttimetcp,
	        success: function(point) {
				chart_tcp.series.data = point;
	            // call it again after one second
	            setTimeout(requestDataTCP, 1000);    
	        },
	        cache: false
	    });
	}

	

</script>
<div id="masthead">
	
	<div class="content_pad">
		
		<h1 class="no_breadcrumbs">Home</h1>
		
	</div> <!-- .content_pad -->
	
</div> <!-- #masthead -->	

<div id="content">
	<div id="lasttime"></div>
	<div id="container_tcp" style="width:1000px;height:250px;"></div>
</div> <!-- #content -->

