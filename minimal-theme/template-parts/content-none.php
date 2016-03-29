<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><? esc_html_e( 'Nothing Found', '_s' ); ?></h1>
	</header>
	<div class="page-content">
		<?
		if ( is_search() ) : ?>
		<? // search result empty !!! ?>

			<p><? esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', '_s' ); ?></p>
			<?
				get_search_form();

		else : ?>
		<? // 404 !!! ?>

			<p><? esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', '_s' ); ?></p>
			<?
				get_search_form();

		endif; ?>
	</div>
</section>
