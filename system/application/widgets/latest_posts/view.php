{{ if show_title == 'true' }}
<div class="title"><h4>{{ title }}</h4></div>
{{ endif }}

<div class="small_slider_hots owl-carousel owl-theme">
	<div class="item clearfix">
		<ul class="small_posts">
			{{ latest_posts }}
			<li class="clearfix">
				<a class="s_thumb hover-shadow" href="{{ func.site_url url=url }}"><img width="70" height="70" src="<?php echo get_theme_image("assets/thumb13.jpg", false); ?>" alt="#"></a>
				<h3><a href="{{ func.site_url url=url }}">{{ title }}</a></h3>
				<div class="meta mb"> <a class="cat color1" href="#" title="View all posts under Entertainment">Kegiatan</a><span class="post_rating" href="#" title="Rating">25 Agustus 2014</span> </div>
			</li>
			{{ /latest_posts }}
		</ul>
	</div>
</div>
