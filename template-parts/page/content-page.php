<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

$entity = get_query_var('entity');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="">
		<a href="<?php the_permalink()?>">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</a>
	</header>
	<div class="page-content">
		<?php the_content();?>
		<p><?php the_field('address')?></p>
		<p><?php the_field('event_date')?></p>
	</div>
	<div class="acf_form_content display-none">
		<button class="danger-btn toggle-edit-<?=$entity?>">x</button>
		<?php acf_form([
			'post_title'	=> true,
			'post_content'	=> true,
			'new_post'		=> array(
				'post_type'		=> $entity . 's',
				'post_status'	=> 'publish'
			),
			'return'		=> home_url('my-' . $entity . 's'),

		]); ?>
	</div>


	<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
				'after'  => '</div>',
			)
		);
		?>
	<div class="btn-container org">
		<button data-id="<?= get_the_ID()?>" class="edit-<?=$entity?>">Edit</button>
		<button data-id="<?= get_the_ID()?>" class="delete-<?=$entity?> danger-btn">Delete</button>
	</div>
</article>
<hr>
<!-- #post-<?php the_ID(); ?> -->

