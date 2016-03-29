<?php
/**
 * _s functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

if ( ! function_exists( '_s_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _s_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( '_s', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', '_s' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( '_s_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', '_s_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_s_content_width', 640 );
}
add_action( 'after_setup_theme', '_s_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _s_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_s' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', '_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _s_scripts() {
	wp_enqueue_style( '_s-style', get_stylesheet_uri() );

	wp_enqueue_script( '_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/extras.php';

require get_template_directory() . '/inc/customizer.php';

require get_template_directory() . '/inc/jetpack.php';


function custom_comments($comment, $args, $depth) {
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
				<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<footer class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"></a>
			<div class="comment-author vcard">
				<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>

		<?php
			/* translators: 1: date, 2: time */
			printf( __('/ on %1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?> <?php edit_comment_link( __( ' / Edit' ), '  ', '' );
		?>
	<div class="reply">
		/ <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
			</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
		<br />
	<?php endif; ?>
	</footer><br/>

	<?php comment_text(); ?>

		</div>
	<?php endif; ?>
	<?php
}

function custom_comment_form(){
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	return array(
			'id_form'           => 'commentform',
			'class_form'      => 'comment-form',
			'id_submit'         => 'submit',
			'class_submit'      => 'submit',
			'name_submit'       => 'submit',
			'title_reply'       => __( 'Leave a Reply' ),
			'title_reply_to'    => __( 'Leave a Reply to %s' ),
			'cancel_reply_link' => __( 'Cancel Reply' ),
			'label_submit'      => __( 'send' ),
			'format'            => 'xhtml',

			'comment_field' =>  '<div class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
					'</label><textarea placeholder="comment" id="comment" name="comment" aria-required="true">' .
					'</textarea></div>
					<script>
					var textarea = document.getElementById("comment");
var heightLimit = 300; /* Maximum height: 200px */

textarea.oninput = function() {
  textarea.style.height = ""; /* Reset the height*/
  textarea.style.height = Math.min(textarea.scrollHeight, heightLimit) + "px";
};
</script>
					',

			'must_log_in' => '<p class="must-log-in">' .
					sprintf(
							__( 'You must be <a href="%s">logged in</a> to post a comment.' ),
							wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
					) . '</p>',

			'logged_in_as' => '<p class="logged-in-as">' .
					sprintf(
							__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
							admin_url( 'profile.php' ),
							wp_get_current_user()->user_nicename,
							wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
					) . '</p>',

			'comment_notes_before' => '<p class="comment-notes">' .
					__( 'Your email address will not be published.' ) . ( $req ? " Name and email address are required fields." : '' ) .
					'</p>',

			'comment_notes_after' => '<p class="form-allowed-tags">' .
					sprintf(
							__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
							' <code>' . allowed_tags() . '</code>'
					) . '</p>',

			'fields' => apply_filters( 'comment_form_default_fields', array(

					'author' =>
							'<div class="comment-form-author"><label for="author">' . __( 'Name', 'domainreference' ) . '</label> ' .
							( $req ? '<span class="required">*</span>' : '' ) .
							'<input  placeholder="name" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
							'" size="30"' . $aria_req . ' /></div>',

					'email' =>
							'<div class="comment-form-email"><label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' .
							( $req ? '<span class="required">*</span>' : '' ) .
							'<input placeholder="email" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
							'" size="30"' . $aria_req . ' /></div>',

					'url' =>
							'<div class="comment-form-url"><label for="url">' . __( 'Website', 'domainreference' ) . '</label>' .
							'<input placeholder="website" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
							'" size="30" /></div>',
			) ),
	);
}

function add_hello_world_page(){
	add_menu_page("hello world !","hello world again !","manage_network","hello-world",function(){
//		echo "<h1>hi darling !</h1>";
		echo isset($_POST["update"]) ? 1 : 0;
		echo "<form method=post><input name='update' type='submit'/></form>";
	});
}
add_action("admin_menu","add_hello_world_page");

function custome_tax(){
	register_taxonomy("method","post",["hierarchy" => false,"label" => "methodology"]);
}
add_action("init","custome_tax");