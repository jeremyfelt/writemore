<?php
/**
 * Template part for displaying workouts.
 *
 * Renders markdown content from post content or the hwt_workout_markdown meta field.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package writemore
 */

use Writemore\Output;
use Writemore\Markdown;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if ( is_singular( 'hwt_workout' ) ) : ?>
	<header>
		<?php the_title( '<h1 class="p-name">', '</h1>' ); ?>
	</header>
<?php endif; ?>

<?php if ( ! is_singular( 'hwt_workout' ) ) : ?>
	<header>
		<?php the_title( '<h1><a href="' . get_the_permalink() . '" class="p-name">', '</a></h1>' ); ?>
	</header>
	<?php Output\published(); ?>
<?php else : ?>
	<?php Output\published( 'full' ); ?>
<?php endif; ?>

	<div class="entry-content e-content">
		<?php
		if ( is_singular( 'hwt_workout' ) ) {
			Markdown\workout_content();
		} else {
			Markdown\workout_excerpt();
		}
		?>
	</div>

<?php if ( is_singular( 'hwt_workout' ) ) : ?>
	<footer class="entry-footer">
		<?php
		Output\published();
		get_template_part( 'template-parts/author-bio' );
		?>
	</footer>
	<section class="more-workouts">
		<?php
		Output\other_workouts();
		echo '<p>Back to <a href="' . esc_url( get_post_type_archive_link( 'hwt_workout' ) ) . '">all workouts</a>.</p>';
		?>
	</section>
	<?php
	// If comments are open or there is at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template(); // Outputs its own <section>.
	}
	?>
<?php endif; ?>

</article>
