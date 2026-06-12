<?php
/**
 * Reusable template output helpers.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * URL of a drop-in theme image, or '' if it hasn't been added yet.
 *
 * Looks for assets/img/{name} with common extensions, so templates can
 * declare an image slot ("home/financial-planning") and render a styled
 * placeholder until the real file is dropped in. See assets/img/README.md
 * for the expected filenames.
 */
function ffp_image_url( $name ) {
	foreach ( [ '', '.svg', '.png', '.webp', '.jpg', '.jpeg' ] as $ext ) {
		$rel = 'assets/img/' . $name . $ext;
		if ( file_exists( get_template_directory() . '/' . $rel ) ) {
			return get_template_directory_uri() . '/' . $rel;
		}
	}
	return '';
}

/**
 * Breadcrumb trail. $crumbs is a list of [ 'label' => ..., 'url' => ... ];
 * the last crumb (or any without a url) renders as plain text.
 */
function ffp_breadcrumbs( array $crumbs ) {
	echo '<nav class="single-crumbs" aria-label="Breadcrumb">';
	$last = count( $crumbs ) - 1;
	foreach ( $crumbs as $i => $crumb ) {
		if ( $i > 0 ) {
			echo '<span class="crumb-sep">/</span>';
		}
		if ( $i < $last && ! empty( $crumb['url'] ) ) {
			printf( '<a href="%s">%s</a>', esc_url( $crumb['url'] ), esc_html( $crumb['label'] ) );
		} else {
			printf( '<span class="crumb-current">%s</span>', esc_html( $crumb['label'] ) );
		}
	}
	echo '</nav>';
}

/** Copy-link / LinkedIn / email share toolbar for a single item. */
function ffp_share_buttons( $url, $title, $kind_label = 'article' ) {
	?>
	<div class="single-share">
		<div class="single-share-label">Share this <?php echo esc_html( strtolower( $kind_label ) ); ?></div>
		<div class="single-share-buttons">
			<button class="share-btn" type="button" data-share-url="<?php echo esc_attr( $url ); ?>" data-share-title="<?php echo esc_attr( $title ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="14" height="14"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
				Copy link
			</button>
			<a class="share-btn" target="_blank" rel="noopener"
			   href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( $url ); ?>">
				<svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M19 3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14zM8 17v-7H6v7h2zm-1-8.1a1.15 1.15 0 100-2.3 1.15 1.15 0 000 2.3zM18 17v-4.1c0-2-1.1-2.9-2.5-2.9-1.2 0-1.8.7-2.1 1.1V10h-2v7h2v-3.9c0-.2 0-.4.1-.5.2-.4.5-.9 1.2-.9.9 0 1.3.7 1.3 1.7V17h2z"/></svg>
				LinkedIn
			</a>
			<a class="share-btn" target="_blank" rel="noopener"
			   href="mailto:?subject=<?php echo rawurlencode( $title ); ?>&body=<?php echo rawurlencode( 'Thought you might find this useful: ' . $url ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="14" height="14"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
				Email
			</a>
		</div>
	</div>
	<?php
}

/**
 * Hairline list of library items. Routable items link to their single
 * view; stubs render muted with a "coming soon" note.
 */
function ffp_resource_list( array $items ) {
	if ( ! $items ) {
		return;
	}
	echo '<ul class="linked-list">';
	foreach ( $items as $item ) {
		if ( ffp_item_is_routable( $item ) ) {
			printf(
				'<li><a href="%s"><span>%s</span><span class="ll-arrow">&rsaquo;</span></a></li>',
				esc_url( ffp_resource_url( $item ) ),
				esc_html( $item['title'] )
			);
		} else {
			printf(
				'<li class="ll-stub"><span>%s</span><span class="ll-soon">Coming soon</span></li>',
				esc_html( $item['title'] )
			);
		}
	}
	echo '</ul>';
}

/** "5 articles · 9 calculators · 2 videos" summary for a category. */
function ffp_category_count_label( $category ) {
	$counts = ffp_category_counts( $category );
	$parts  = [];
	foreach ( [ 'article' => 'article', 'calculator' => 'calculator', 'video' => 'video' ] as $kind => $noun ) {
		if ( $counts[ $kind ] > 0 ) {
			$parts[] = $counts[ $kind ] . ' ' . $noun . ( 1 === $counts[ $kind ] ? '' : 's' );
		}
	}
	return implode( ' · ', $parts );
}

/** Standard page hero (light or dark variant). */
function ffp_page_hero( $eyebrow, $title_html, $copy, $dark = false ) {
	?>
	<div class="page-hero <?php echo $dark ? 'page-hero-dark' : ''; ?>">
		<div class="page-hero-inner">
			<p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<h1 class="display-title"><?php echo wp_kses_post( $title_html ); ?></h1>
			<?php if ( $copy ) : ?>
				<p class="body-copy page-hero-copy"><?php echo esc_html( $copy ); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<?php
}
