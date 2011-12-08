<script>
	var lasttimetcp = 0;
	$(document).ready(function() {
		
		var data = [], totalPoints = 300;
	    function getRandomData() {
	        if (data.length > 0)
	            data = data.slice(1);

	        // do a random walk
	        while (data.length < totalPoints) {
	            var prev = data.length > 0 ? data[data.length - 1] : 50;
	            var y = prev + Math.random() * 10 - 5;
	            if (y < 0)
	                y = 0;
	            if (y > 100)
	                y = 100;
	            data.push(y);
	        }

	        // zip the generated y values with the x values
	        var res = [];
	        for (var i = 0; i < data.length; ++i)
	            res.push([i, data[i]])
	        return res;
	    }
		

	    // setup control widget
	    var updateInterval = 30;
	    $("#updateInterval").val(updateInterval).change(function () {
	        var v = $(this).val();
	        if (v && !isNaN(+v)) {
	            updateInterval = +v;
	            if (updateInterval < 1)
	                updateInterval = 1;
	            if (updateInterval > 2000)
	                updateInterval = 2000;
	            $(this).val("" + updateInterval);
	        }
	    });

	    // setup plot
	    var options = {
	        series: { shadowSize: 0 }, // drawing is faster without shadows
	        yaxis: { min: 0, max: 10000 },
	        xaxis: { show: false }
	    };
	    var plot = $.plot($("#container_tcp"), [ getRandomData() ], options);

	    function update() {

		    $.ajax({
		        url: '<?=site_url('admin/home/sess');?>/'+lasttimetcp,
		        success: function(point) {
			        plot.setData([point]);
		        },
		        cache: false
		    });

	        //plot.setData([ getRandomData() ]);
	        // since the axes don't change, we don't need to call plot.setupGrid()
	        //plot.draw();

	        setTimeout(update, updateInterval);
	    }

	    update();

	        
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
	<div id="container_tcp" style="width:1000px;height:500px;"></div>
	<p>Time between updates: <input id="updateInterval" type="text" value="" style="text-align: right; width:5em"> milliseconds</p>
    
</div> <!-- #content -->

