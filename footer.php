<?php
/**
 * The template for displaying the footer.
 *
 * @package writemore
 */

?>
</main><!-- #main -->

<?php
if ( is_active_sidebar( 'writemore-footer' ) ) {
	?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<section>
			<?php dynamic_sidebar( 'writemore-footer' ); ?>
		</section>
	</footer>
	<?php
}
?>

<?php wp_footer(); ?>

</body>
</html>
