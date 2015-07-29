{{ if show_title == 'true' }}
    <div class="title"><h4>{{ title }}</h4></div>
{{ endif }}

<div class="tags">
	{{ labels }}
	<a href="{{ func.site_url url=url }}"> {{ label }} </a>
	{{ /labels }}
</div>
