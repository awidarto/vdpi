<script>
	var lasttimehttp = 0;
	var lasttimeftp = 0;
	$(document).ready(function() {
	    chart_http = new Highcharts.Chart({
	        chart: {
	            renderTo: 'container_http',
				defaultSeriesType: 'column',
	            events: {
	                load: requestDataHTTP
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
				defaultSeriesType: 'column',
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
	        
	});
	
	function requestDataHTTP() {
	    $.ajax({
	        url: '<?=site_url('admin/vdpi/live/webs/rs_bd_size/sum/');?>/'+lasttimehttp+'/300000',
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
	        url: '<?=site_url('admin/vdpi/live/ftps/download_num/sum');?>/'+lasttimeftp+'/300000',
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

</script>

<div id="content">
	<div id="lasttime"></div>
	<div id="container_http" style="width:1000px;height:250px;"></div>
	<div id="container_ftp" style="width:1000px;height:250px;"></div>


</div> <!-- #content -->

