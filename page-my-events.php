<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
	global $current_user; 
	global $wp; 

	acf_form_head();

	$args = array(
	 	'post_type'     => 'events',
	 	'post_status'   => 'publish',
	    'author'        =>  $current_user->ID,
	    'orderby'       =>  'post_date',
	    'order'         =>  'ASC',
	    'posts_per_page' => 10
	 );

	$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$paged = (int) $args['paged']; 

	$events = new WP_Query($args);
	$total = $events->max_num_pages;
	$nextPage = $total === $paged ? $total : $paged + 1; 
	$prevPage = $paged === 1 ? 1 : $args['paged'] - 1; 
	$totalEvents = $events->post_count;

	$event = get_post_type_by_name('event');
	$description = ''; 

	if (is_object($event) && property_exists($event, 'description')) {
		$description = $event->description;
	}

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<button style="margin-bottom:4em;" class="toggle-new-event">+</button>
		<hr>
		<main id="main" class="site-main" role="main">
			<article id="post-new-form" class="display-none">
				<?php 

					acf_form(array(
						'post_id'		=> 'new_post',
						'post_title'	=> true,
						'post_content'	=> true,
						'new_post'		=> array(
							'post_type'		=> 'events',
							'post_status'	=> 'draft'
						),
						'return'		=> home_url('my-events'),
					));
				?>
				<hr>
			</article>
			<?php if ($totalEvents > 0) : ?>
				<?php while ( $events->have_posts() ) :
					$events->the_post();

					set_query_var('entity', 'event');
					get_template_part( 'template-parts/page/content', 'page' );

				endwhile; // End of the loop.
				
				// Reset postdata
				wp_reset_postdata();
				seventeenChildCustomPagination($nextPage, $prevPage, $paged, (int) $total);?>
			<?php else : ?>
				<h3 class="text-center">
					You can add Events by clicking the + button. 
				</h3>
				<?php if ($description !== '') : ?> 
					<p class="text-center"><?= $description?></p>
				<?php endif; ?> 
			<?php endif;?>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();
