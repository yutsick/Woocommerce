<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default. Please note that
 * this is the WordPress construct of pages: specifically, posts with a post
 * type of `page`.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package allmighty
 */

get_header();
?>

	<main id="main">

		<?php
		/* Start the Loop */
		while ( have_posts() ) :
			the_post();

			// Check if the page has ACF flexible content blocks
			if ( function_exists( 'have_rows' ) && have_rows( 'content_blocks' ) ) :
				// Render flexible content blocks
				allmighty_render_blocks( 'content_blocks' );
			else :
				// Fallback to default page content if no ACF blocks
				?>
				<section class="container mx-auto px-4 py-16">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="mb-8">
								<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto rounded-lg' ) ); ?>
							</div>
						<?php endif; ?>

						<header class="mb-8">
							<?php the_title( '<h1 class="text-4xl font-bold mb-4">', '</h1>' ); ?>
						</header>

						<div class="prose prose-lg max-w-none">
							<?php
							the_content();

							wp_link_pages(
								array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'allmighty' ),
									'after'  => '</div>',
								)
							);
							?>
						</div>
					</article>

					<?php
					// If comments are open, or we have at least one comment, load the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				</section>
				<?php
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
