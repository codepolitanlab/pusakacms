{{ if show_title == 'true' }}
    <div class="title"><h4>{{ title }}</h4></div>
{{ endif }}

<ul class="links">
{{ navs }}
	<li class="clearfix">
		{{ if source == "uri" }}
			<a href="{{ func.site_url uri=url }}">{{ title }}</a>
		{{ else }}
			<a href="{{ source }}{{ url }}">{{ title }}</a>
		{{ endif }}
	</li>
{{ /navs }}
</ul>
