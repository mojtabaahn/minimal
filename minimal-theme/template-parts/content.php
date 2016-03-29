<article id="post-<? the_ID(); ?>" <? post_class(); ?>>
	<?php $date = date("F d, Y",get_post_time()); ?>
	<?php $cats = [];foreach(get_the_category() as $item){$cats[] = $item->name;}$cats = implode(" / ",$cats); ?>
	<header class="entry-header">
		<a class="article-cover" href="<?php echo get_permalink();?>"></a>
		<?
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		the_post_thumbnail();

		if ( 'post' === get_post_type() ) :
		?>
		<div class="entry-meta">
			<? /*_s_posted_on();*/ ?>
			<?php echo $date . " IN " . $cats; ?>
		</div>
		<?
			endif;
		?>
	</header>

	<div class="entry-content">
		<?
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', '_s' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
				'after'  => '</div>',
			) );
		?>
	</div>

	<footer class="entry-footer">
		<? _s_entry_footer(); ?>
	</footer>
</article>
