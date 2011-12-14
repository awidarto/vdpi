<script>
	var lasttimetcp = 0;
	$(document).ready(function() {
		
	    var roptions = {
			lines: { show: true, color: "rgba(0, 0, 255, 0.8)" },
	        points: { show: false },
	        xaxis: { mode: "time",timeformat: "%y/%m/%d"}
	    };

	    var soptions = {
	        lines: { show: true },
	        points: { show: false },
	        xaxis: { mode: "time",timeformat: "%y/%m/%d"}
	    };

	    var data = [];
	    var retransmit = $("#retransmit");
	    var session = $("#session");

	    $.plot(retransmit, data, roptions);
	    $.plot(session, data, soptions);

	    // fetch one series, adding to what we got
	    var alreadyFetched = {};

        function fetchData() {

            function onDataReceivedRet(series) {
                data = [ series ];
                $.plot($("#retransmit"), data, roptions);
				//$.plot.setData(data);
            }

            function onDataReceivedSession(series) {
                data = [ series ];
                $.plot($("#session"), data, soptions);
				//$.plot.setData(data);
				//$.plot.setupGrid();
            }

            $.ajax({
                url: '<?=site_url('admin/home/sess');?>/'+lasttimetcp,
                type: 'GET',
                dataType: 'json',
                success: onDataReceivedSession
            });

            $.ajax({
                // usually, we'll just call the same URL, a script
                // connected to a database, but in this case we only
                // have static example files so we need to modify the
                // URL
                url: '<?=site_url('admin/home/ret');?>/'+lasttimetcp,
                type: 'GET',
                dataType: 'json',
                success: onDataReceivedRet
            });
            setTimeout(fetchData, 1000);

        }

		fetchData();
	        
	});
	

</script>


<div id="masthead">
	
	<div class="content_pad">
		
		<h1 class="no_breadcrumbs">Home</h1>
		
	</div> <!-- .content_pad -->
	
</div> <!-- #masthead -->	

<div id="content" style="text-align:center;">
	<div id="session" style="width:1000px;height:200px;margin:auto;padding-bottom:30px;"></div>
	<div id="retransmit" style="width:1000px;height:200px;margin:auto;"></div>
</div> <!-- #content -->

