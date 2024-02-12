<?php
/**
 * The template for displaying author info below posts.
 *
 * @package writemore
 */

?>

<div class="author-bio p-author h-card">
	<?php
	echo get_avatar(
		get_the_author_meta( 'ID' ),
		300,
		'',
		"Jeremy's profile photo: a selfie taken while walking through Berlin.",
		array(
			'class' => 'u-photo',
		)
	);

	if ( is_active_sidebar( 'writemore-author-bio' ) ) {
		?>
		<div class="author-bio-content">
			<?php dynamic_sidebar( 'writemore-author-bio' ); ?>
		</div>
		<?php
	}
	?>
</div>
