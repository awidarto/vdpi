	<script>
		var lasttimehttp = 0;
		var lasttimeftp = 0;
		var lasttimearp = 0;
		$(document).ready(function() {


		    chart_http = new Highcharts.Chart({
		        chart: {
		            renderTo: 'container_http',
		            events: {
		                load: requestDataTCP
		            }
		        },
		        title: {
		            text: 'HTTP'
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
		            name: 'HTTP',
		            data: []
		        }]
		    });
			
		    chart_ftp = new Highcharts.Chart({
		        chart: {
		            renderTo: 'container_ftp',
		            events: {
		                load: requestDataFTP
		            }
		        },
		        title: {
		            text: 'FTP'
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
		            name: 'FTP',
		            data: []
		        }]
		    });

		    chart_arp = new Highcharts.Chart({
		        chart: {
		            renderTo: 'container_arp',
		            events: {
		                load: requestDataARP
		            }
		        },
		        title: {
		            text: 'ARP'
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
		            name: 'ARP',
		            data: []
		        }]
		    });
		        
		});

		function requestDataTCP() {
		    $.ajax({
		        url: '<?=site_url('admin/home/sess');?>/'+lasttimehttp,
		        success: function(point) {
		            var series = chart_http.series[0],
						
		            shift = series.data.length > 60; // shift if the series is longer than 20
					
					lasttimehttp = point[0];
		            // add the point
		            chart_http.series[0].addPoint(point, true, shift);

		            // call it again after one second
		            setTimeout(requestDataTCP, 1000);    
		        },
		        cache: false
		    });
		}

		
		function requestDataHTTP() {
		    $.ajax({
		        url: '<?=site_url('admin/live/live/webs/rs_bd_size/sum/');?>/'+lasttimehttp,
		        success: function(point) {
		            var series = chart_http.series[0],
						
		            shift = series.data.length > 60; // shift if the series is longer than 20
					
					lasttimehttp = point[0];
		            // add the point
		            chart_http.series[0].addPoint(point, true, shift);

		            // call it again after one second
		            setTimeout(requestDataHTTP, 1000);    
		        },
		        cache: false
		    });
		}

		function requestDataFTP() {
		    $.ajax({
		        url: '<?=site_url('admin/live/live/ftps/download_num/sum');?>/'+lasttimeftp,
		        success: function(point) {
		            var series = chart_ftp.series[0],
		                shift = series.data.length > 60; // shift if the series is longer than 20
					lasttimeftp = point[0];
		            // add the point
		            chart_ftp.series[0].addPoint(point, true, shift);

		            // call it again after one second
		            setTimeout(requestDataFTP, 1000);    
		        },
		        cache: false
		    });
		}

		function requestDataARP() {
		    $.ajax({
		        url: '<?=site_url('admin/live/live/arps/capture_date/count');?>/'+lasttimearp,
		        success: function(point) {
		            var series = chart_arp.series[0],
		                shift = series.data.length > 60; // shift if the series is longer than 20
					lasttimearp = point[0];
		            // add the point
		            chart_arp.series[0].addPoint(point, true, shift);

		            // call it again after one second
		            setTimeout(requestDataARP, 1000);    
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
		<div id="container_arp" style="width:1000px;height:250px;"></div>
		<div id="container_http" style="width:1000px;height:250px;"></div>
		<div id="container_ftp" style="width:1000px;height:250px;"></div>
	
	
	</div> <!-- #content -->
	
