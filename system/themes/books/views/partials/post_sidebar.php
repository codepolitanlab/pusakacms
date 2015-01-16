<div class="widget">
	<h3>Labels</h3>
	<?php $labels = $this->pusaka->get_labels();
	asort($labels);
	foreach ($labels as $url => $label): ?>
	<label class="label label-info"><?php echo anchor($url, $label); ?></label>
	<?php endforeach; ?>
</div>

<div class="widget">
	<h3>Like Our Page</h3>
	<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fnyankod&amp;width=208&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=414317858711157" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:208px; height:290px;" allowTransparency="true"></iframe>
</div>

<div class="widget">
	<h3>Follow Us</h3>
	<a class="twitter-timeline" href="https://twitter.com/nyankodTWEET" data-widget-id="267929124176269312">Tweets by @nyankodTWEET</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
