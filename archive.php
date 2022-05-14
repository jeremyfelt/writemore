<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WriteMore
 */

get_header();

$description = '';
$post_type   = get_post_type_object( get_post_type() );

if ( 'shortnote' === get_post_type() ) {
	$description = 'For shorter content, like notes.';
} elseif ( 'like' === get_post_type() ) {
	$description = 'A list of pages I\'ve found interesting.';
} elseif ( 'post' === get_post_type() ) {
	$description === 'For things with titles.';
}
?>

<?php if ( have_posts() ) : ?>

	<header>
		<h1><?php echo esc_html( $post_type->label ); ?></h1>
		<?php if ( ! empty( trim( $description ) ) ) : ?>
		<p><?php echo wp_kses_post( $description ); ?></p>
		<?php endif; ?>
		<p><a href="<?php echo get_post_type_archive_feed_link( get_post_type() ); ?>">Follow via RSS</a></p>
	</header><!-- .page-header -->

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php get_template_part( 'template-parts/content/content', 'single' ); ?>
	<?php endwhile; ?>

	<?php the_posts_navigation(); ?>

<?php else : ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>
