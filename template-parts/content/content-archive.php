<?php
/**
 * Template part for displaying post content in archive views.
 *
 * @package writemore
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( post_type_supports( get_post_type(), 'title' ) ) :
		?>
	<header>
		<?php the_title( '<h1><a href="' . get_the_permalink() . '" class="p-name">', '</a></h1>' ); ?>
		<?php the_post_thumbnail(); ?>
	</header>
		<?php
	endif;

	if ( function_exists( 'ShortNotes\PostType\Note\reply_to_markup' ) ) {
		\ShortNotes\PostType\Note\reply_to_markup();
	}
	?>
	<div class="entry-content e-content">
		<?php \Writemore\Output\archive_content(); ?>
	</div>
</article>
