	<?php
	    function set_hilite($urlpattern){
	        $hilite = preg_match('/'.$urlpattern.'/',current_url());
	        return ($hilite)?'nav_current':'';
	    }
	
	?>
	
	<div id="header">
		
		<div class="content_pad">
			<h1><a href="./dashboard.html">Dashboard Admin</a></h1>
			
			<ul id="nav">
				<li class="<?=set_hilite('admin\/home')?> nav_icon"><a href="<?=site_url('admin/home');?>"><span class="ui-icon ui-icon-home"></span>Home</a></li>
			    <?php 
					$protocol_menu = $this->config->item('vdpi_protocol_menu');
					$application_menu = $this->config->item('vdpi_application_menu');
					$content_menu = $this->config->item('vdpi_content_menu');
				?>
				<li class="<?=set_hilite('admin\/vdpi\/aggregates$')?> nav_icon"><a href="<?=site_url('admin/vdpi/aggregates');?>"><span class="ui-icon ui-icon-signal"></span>Live Monitor</a></li>
				<li class="nav_dropdown">
					<a href="">Protocols</a>
					<div class="nav_menu">
						<ul>
							<?php foreach($protocol_menu as $key=>$val):?>
								<li class="<?=set_hilite('admin\/applications\/'.$key.'$')?>"><a href="<?=site_url('admin/applications/'.$key);?>"><span class="ui-icon ui-icon-transfer-e-w"></span><?=$val['title']?></a></li>
							<?php endforeach;?>
						</ul>
					</div> <!-- .menu -->
				</li>
				<li class="nav_dropdown">
					<a href="">Contents</a>
					<div class="nav_menu">
						<ul>
							<?php foreach($content_menu as $key=>$val):?>
								<li class="<?=set_hilite('admin\/applications\/'.$key.'$')?>"><a href="<?=site_url('admin/applications/'.$key);?>"><span class="ui-icon ui-icon-transfer-e-w"></span><?=$val['title']?></a></li>
							<?php endforeach;?>
						</ul>
					</div> <!-- .menu -->
				</li>
				<li class="nav_dropdown">
					<a href="">Applications</a>
					<div class="nav_menu">
						<ul>
							<?php foreach($application_menu as $key=>$val):?>
								<li class="<?=set_hilite('admin\/applications\/'.$key.'$')?>"><a href="<?=site_url('admin/applications/'.$key);?>"><span class="ui-icon ui-icon-transfer-e-w"></span><?=$val['title']?></a></li>
							<?php endforeach;?>
						</ul>
					</div> <!-- .menu -->
				</li>
				<li class="nav_dropdown">
					<a href="">Administrator</a>
					<div class="nav_menu">
						<ul>
							<li class="<?=set_hilite('admin\/users')?> nav_icon"><a href="<?=site_url('admin/users');?>"><span class="ui-icon ui-icon-signal"></span>Users</a></li>
							<li class="<?=set_hilite('admin\/vdpi\/settings$')?> nav_icon"><a href="<?=site_url('admin/vdpi/settings');?>"><span class="ui-icon ui-icon-signal"></span>Settings</a></li>
							<li class="<?=set_hilite('admin\/vdpi\/thresholds$')?> nav_icon"><a href="<?=site_url('admin/vdpi/thresholds');?>"><span class="ui-icon ui-icon-signal"></span>Thresholds</a></li>
							<li class="<?=set_hilite('admin\/vdpi\/applications$')?> nav_icon"><a href="<?=site_url('admin/vdpi/applications');?>"><span class="ui-icon ui-icon-signal"></span>Threshold Apps</a></li>
							<li class="<?=set_hilite('admin\/vdpi\/periodicals$')?> nav_icon"><a href="<?=site_url('admin/vdpi/periodicals');?>"><span class="ui-icon ui-icon-signal"></span>Scheduler</a></li>
							<li class="<?=set_hilite('admin\/vdpi\/reports')?> nav_icon"><a href="<?=site_url('admin/vdpi/reports');?>"><span class="ui-icon ui-icon-signal"></span>Reports</a></li>
						</ul>
					</div> <!-- .menu -->
				</li>
			</ul>
		</div> <!-- .content_pad -->
		
	</div> <!-- #header -->	
	
