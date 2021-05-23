<?php
/**
 * The template for displaying author info below posts.
 */

?>
<?php if ( (bool) get_the_author_meta( 'description' ) && post_type_supports( get_post_type(), 'author' ) ) : ?>
	<div class="author-bio <?php echo get_option( 'show_avatars' ) ? 'show-avatars' : ''; ?>">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), '85' ); ?>
		<div class="author-bio-content">
			<h2 class="author-title">
			<?php
			printf(
				/* translators: %s: Author name. */
				esc_html__( 'By %s', 'writemore' ),
				get_the_author()
			);
			?>
			</h2>
			<p class="author-description"> <?php the_author_meta( 'description' ); ?></p><!-- .author-description -->
		</div><!-- .author-bio-content -->
	</div><!-- .author-bio -->
<?php endif; ?>
