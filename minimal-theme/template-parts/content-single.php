<article class="single" id="post-<? the_ID(); ?>" <? post_class(); ?>>
	<?php $date = date("F d, Y",get_post_time()); ?>
	<?php $cats = [];foreach(get_the_category() as $item){$cats[] = $item->name;}$cats = implode(" / ",$cats); ?>
	<header class="entry-header">
		<a class="article-cover" href="<?php echo get_permalink();?>"></a>
		<?
		the_post_thumbnail();

		the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );


		if ( 'post' === get_post_type() ) :
		?>
		<div class="entry-meta">
			<? /*_s_posted_on();*/ ?>
			<?php echo "By " . get_the_author() . " - " . $date . " - " . $cats; ?>
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
		<? if(has_tag()) : ?>
		<div class="post-tags">
			<? foreach(get_the_tags() as $tag){echo "<a rel='tag' href='" . get_tag_link($tag) . "'>$tag->name</a>";}; ?>
		</div>
		<? endif;?>

		<? $next = get_next_post(); ?>
		<? $prev = get_previous_post(); ?>
		<? if($prev): ?>
		<a class="prev-post" href="<? echo get_permalink($prev);?>">
			<img src="<? echo get_the_post_thumbnail_url($prev);?>">
			<div class="prev-post-top">prev</div>
			<div class="prev-post-bottom"><? echo $prev->post_title;?></div>
		</a>
		<? endif;?>
		<? if($next):?>
		<a class="next-post" href="<? echo get_permalink($next);?>">
			<img src="<? echo get_the_post_thumbnail_url($next);?>">
			<div class="next-post-top">next</div>
			<div class="next-post-bottom"><? echo $next->post_title;?></div>
		</a>
		<? endif;?>
	</footer>
</article>
