<? get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?
		if ( have_posts()  && !is_single()) :
		
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/content', get_post_format() );
			endwhile;
//			the_posts_navigation();
			the_posts_pagination();
		elseif(is_single()) :

			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/content-single', get_post_format() );
			endwhile;

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		else :

			get_template_part( 'template-parts/content', 'none' );
			
		endif;


		?>
		</main>
	</div>
<?
get_sidebar();
get_footer();
