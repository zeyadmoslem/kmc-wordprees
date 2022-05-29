<?php

/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function kmc_blocks_cgb_block_assets()
{ // phpcs:ignore
	// Register block styles for both frontend + backend.
	wp_register_style(
		'kmc_blocks-cgb-style-css', // Handle.
		plugins_url('dist/blocks.style.build.css', dirname(__FILE__)), // Block style CSS.
		is_admin() ? array('wp-editor') : null, // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'kmc_blocks-cgb-block-js', // Handle.
		plugins_url('/dist/blocks.build.js', dirname(__FILE__)), // Block.build.js: We register the block here. Built with Webpack.
		array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), // Dependencies, defined above.
		null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'kmc_blocks-cgb-block-editor-css', // Handle.
		plugins_url('dist/blocks.editor.build.css', dirname(__FILE__)), // Block editor CSS.
		array('wp-edit-blocks'), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'kmc_blocks-bootstrap4', // Handle.
		'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', // Block editor CSS.
		array('wp-edit-blocks'), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'kmc_blocks-cgb-block-js',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path(__DIR__),
			'pluginDirUrl'  => plugin_dir_url(__DIR__),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'kmc/services',
		array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'kmc_blocks-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'kmc_blocks-cgb-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'kmc_blocks-bootstrap4',
			'render_callback' => 'render_services',

		)
	);

	register_block_type(
		'kmc/news',
		array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'kmc_blocks-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'kmc_blocks-cgb-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'kmc_blocks-bootstrap4',
			'render_callback' => 'render_news',

		)
	);

	register_block_type(
		'kmc/doctors',
		array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'kmc_blocks-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'kmc_blocks-cgb-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'kmc_blocks-bootstrap4',
			'render_callback' => 'render_doctors',

		)
	);
}

// Render Services Block Sections
function render_services()
{

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, site_url() . '/wp-json/services/v1/all');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);

	$response = curl_exec($curl);

	curl_close($curl);

	$services = json_decode($response, TRUE);

	ob_start();
	echo "<div class='row p-4'>";
	$output = ob_get_clean();

	foreach (array_reverse($services) as $service => $value) {

		$output .= '<div class="col-lg-4 col-md-6 col-sm-12 services-item p-3">';
		$output .= '<span>' . $value['icon'] . '</span>';
		$output .= '<h4 class="pt-2">' . $value['title'] . '</h4>';
		$output .= '<p>' . $value['description'] . '</p>';
		$output .= '<a  class="gutentor-button gutentor-block-button gutentor-icon-after" href=' . $value['link'] . '>
		 				<i class="gutentor-button-icon fas fa-long-arrow-alt-right"></i>
						<span>Mehr erfahren</span>
					</a>';

		$output .=  '</div>';
	}

	ob_start();
	$output .= "</div>";
	$output .= ob_get_clean();
	return $output;
}


// Render News Block Sections
function render_news()
{

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, site_url() . '/wp-json/news/v1/all');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);

	$response = curl_exec($curl);

	curl_close($curl);

	$news = json_decode($response, TRUE);

	ob_start();
	echo "<div class='row p-4 pt-5 '>";
	$output = ob_get_clean();

	foreach ($news as $item => $value) {

		$output .= '<div class="col-xs-12 col-md-6 news-item">
						<div class="box one">
						<div class="content">
							<h3>' . $value['title'] . '</h3>
							<p>' . $value['description'] . '</p>
							<a href="' . $value['link'] . '">Weiterlesen</a>
						</div>
						</div>
					</div>';
	}

	ob_start();
	$output .= "</div>";
	$output .= ob_get_clean();
	return $output;
}

// Render Doctors Block Sections
function render_doctors()
{

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, site_url() . '/wp-json/doctors/v1/all');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	$response = curl_exec($curl);
	curl_close($curl);
	$news = json_decode($response, TRUE);

	ob_start();
	echo "<div class='row p-4'>";
	$output = ob_get_clean();

	foreach ($news as $item => $value) {

		$output .= '<div class="col-sm-12 col-md-3 doctors-item p-3">
						<a href="' . $value['link'] . '">
							<div class="item-card">
								<div class="top">
								</div>
								<div class="center">
									<img src="' . $value['image'] . '" alt="img-responsive" />
								</div>
								<div class="bottom">
									<h3>' . $value['title'] . '</h3>
									<p>' . $value['description'] . '</p>
								</div>
							</div>
						</a>
					</div>';
	}

	ob_start();
	$output .= "</div>";
	$output .= ob_get_clean();
	return $output;
}

// Hook: Block assets.
add_action('init', 'kmc_blocks_cgb_block_assets');
