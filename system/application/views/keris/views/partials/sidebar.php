<div class="sidebar">
<?php
	$config = array(
		"ul_class" => "nav nav-pills nav-stacked",
		"current_class" => "active",
		"start" => $this->uri->segment(1),
		"depth" => 2
	);

	$this->fizl->initialize($config);
	echo $this->fizl->nav($this->uri->segment(1));

?>
</div>