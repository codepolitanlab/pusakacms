<div class="sidebar">
<?php
	$config = array(
		"ul_class" => "nav nav-pills nav-stacked",
		"current_class" => "active",
	);

	$this->pusaka->initialize($config);
	echo $this->pusaka->nav($this->uri->segment(1), 3);

?>
</div>