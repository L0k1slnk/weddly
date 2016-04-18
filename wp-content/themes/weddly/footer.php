			<footer class="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

				<div id="inner-footer" class="wrap cf">

					<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p>

				</div>

			</footer>

		<?php wp_footer(); ?>

			<?php get_template_part('photoswipe'); ?>
	</body>

</html>
