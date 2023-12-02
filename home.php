<?php
/**
 * The template for displaying the /blog(/page/)(n) views.
 *
 * @package writemore
 */

get_header();

$post_type = get_post_type_object( get_post_type() );
?>

<?php if ( have_posts() ) : ?>

	<header>
		<h1><?php echo esc_html( $post_type->label ); ?></h1>
		<p>For things with titles.</p>
		<p><a href="<?php echo esc_url( get_feed_link() ); ?>">Follow via RSS</a></p>
	</header><!-- .page-header -->

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php get_template_part( 'template-parts/content/card', get_post_type() ); ?>
	<?php endwhile; ?>

	<?php
	the_posts_navigation(
		array(
			'prev_text' => 'View older ' . strtolower( $post_type->labels->name ),
			'next_text' => 'View newer ' . strtolower( $post_type->labels->name ),
		)
	);
	?>

<?php else : ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>
