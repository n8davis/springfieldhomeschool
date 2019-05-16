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

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="">
		<a href="<?php the_permalink()?>">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</a>
	</header>
	<div class="page-content">
		<?php the_content();?>
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
		<button data-id="<?= get_the_ID()?>" class="edit-event">Edit</button>
		<button data-id="<?= get_the_ID()?>" class="delete-event danger-btn">Delete</button>
	</div>
	<div class="btn-container display-none secondary">
		<button data-id="<?= get_the_ID()?>" class="update-event">Update</button>
		<button data-id="<?= get_the_ID()?>" class="cancel-event neutral-btn">Cancel</button>
	</div>
</article>
<hr>
<!-- #post-<?php the_ID(); ?> -->

