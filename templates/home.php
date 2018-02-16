<?php
/**
 * Template Name: Homepage Template
 * Template Post Type: page
 *
 * @package    cashier
 * @copyright  Copyright (c) 2018, Danny Cooper
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

get_header(); ?>

<?php if ( is_active_sidebar( 'homepage-1' ) ) { ?>

	<div class="content-area">

		<?php dynamic_sidebar( 'homepage-1' ); ?>

	</div><!-- .content-area -->

<?php } else { ?>

	<ul class="products">
		<?php
			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => 12,
			);
			$loop = new WP_Query( $args );

		if ( $loop->have_posts() ) {

			while ( $loop->have_posts() ) :

				$loop->the_post();

				wc_get_template_part( 'content', 'product' );

			endwhile;

		} else {
			echo esc_html__( 'No products found', 'cashier' );
		}
			wp_reset_postdata();
		?>
	</ul><!--/.products-->

<?php }

get_footer();
