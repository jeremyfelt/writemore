<?php
/**
 * The template for displaying author info below posts.
 */

?>
<?php if ( (bool) get_the_author_meta( 'description' ) && post_type_supports( get_post_type(), 'author' ) ) : ?>
	<div class="author-bio p-author h-card <?php echo get_option( 'show_avatars' ) ? 'show-avatars' : ''; ?>">
		<?php
		echo get_avatar(
			get_the_author_meta( 'ID' ),
			'85',
			'',
			"Jeremy's profile photo: a selfie taken while walking through Berlin.",
			array(
				'class' => 'u-photo',
			)
		);
		?>
		<div class="author-bio-content">
			<p class="author-name"><a href="<?php echo esc_url( site_url() ); ?>" class="u-url p-name"><?php echo get_the_author(); ?></a> posted this piece of content on the internet.</p>
		</div><!-- .author-bio-content -->
	</div><!-- .author-bio -->
<?php endif; ?>
