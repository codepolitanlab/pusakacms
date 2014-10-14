<textarea id="pagedownMe"  class="form-control" rows="10">
	This is the *first* editor.
	------------------------------

	Just plain **Markdown**, except that the input is sanitized:

	<marquee>I'm the ghost from the past!</marquee>
</textarea>

<script type="text/javascript">
(function() {
	$("textarea#pagedownMe").pagedownBootstrap();
	$('.wmd-preview').addClass('well');
})();
</script>