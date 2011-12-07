<?php
require_once("jpgraph/src/jpgraph.php");

class jpGraph
{

    /**
     * Instantly get a reference of CI
     */
    public function __construct()
    {
        $this->ci = &get_instance();
    }

	public function Graph($opt){
		return new Graph($opt['width'],$opt['height'],$opt['scale']);
	}

	public function pieGraph($opt){
		require_once("jpgraph/src/jpgraph_pie.php");
		return new PieGraph($opt['width'],$opt['height']);
	}

	public function piePlot3D($data){
		require_once("jpgraph/src/jpgraph_pie3d.php");
		return new PiePlot($data);
	}
	
	public function linePlot($data){
		require_once("jpgraph/src/jpgraph_line.php");
		return new LinePlot($data);
	}

	public function barPlot($data){
		require_once("jpgraph/src/jpgraph_bar.php");
		return new BarPlot($data);
	}
	
	public function theme($theme){
		return new $theme;
	}


}