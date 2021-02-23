<form id="webmention-form" action="<?php echo get_webmention_endpoint(); ?>" method="post">
	<p>
		<label for="webmention-source">If you've written a response on your own site, you can enter that post's URL to
		reply with a Webmention.</label>
	</p>
	<p>
		<input id="webmention-source" type="url" autocomplete="url" name="source" placeholder="<?php esc_attr_e( 'URL of your post', 'writemore' ); ?>" />
		<input id="webmention-submit" type="submit" name="submit" value="<?php esc_attr_e( 'Send Webmention', 'writemore' ); ?>" />
	</p>
	<input id="webmention-format" type="hidden" name="format" value="html" />
	<input id="webmention-target" type="hidden" name="target" value="<?php the_permalink(); ?>" />
</form>
<p>The only requirement for your mention to be recognized is a link to this post in your post's
content. You can update or delete your post and then re-submit the URL in the form to update or remove your response from this page.</p>
<p><a href="https://indieweb.org/Webmention">Learn more about Webmentions</a>.</p>
