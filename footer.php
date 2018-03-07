<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link       https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    cashier
 * @copyright  Copyright (c) 2018, Danny Cooper
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

?>

		</div><!-- .wrapper -->
	</div><!-- .site-content -->

	<footer class="site-footer" role="contentinfo">
		<div class="wrapper">
			<div class="site-info">

				<?php
				// translators: %1$s: theme name.
				// translators: %2$s: theme author.
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'cashier' ), '<a href="https://olympusthemes.com/themes/cashier">Cashier</a>', 'OlympusThemes' );
				?>

			</div><!-- .site-info -->
		</div><!-- .wrapper -->
	</footer><!-- .site-footer -->

<?php wp_footer(); ?>

</div><!-- .site-wrapper -->

</body>
</html>
