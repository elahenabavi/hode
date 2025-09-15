<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}
?>
<nav class="woocommerce-pagination w-full flex justify-center mt-15" aria-label="<?php esc_attr_e( 'Product Pagination', 'woocommerce' ); ?>">
	<?php
	$pagination_args = apply_filters(
		'woocommerce_pagination_args',
		array(
			'base'      => $base,
			'format'    => $format,
			'add_args'  => false,
			'current'   => max( 1, $current ),
			'total'     => $total,
			'type'      => 'array',
			'end_size'  => 1,
			'mid_size'  => 2,
		)
	);

	$links = paginate_links( $pagination_args );

	if ( is_array( $links ) ) {
		echo '<ul class="flex flex-wrap justify-center items-center lg:gap-4 gap-3  p-3">';

		// دکمه قبلی
		if ( $current > 1 ) {
			echo '<li class="lg:px-4 md:px-3 px-2 lg:py-2.5 md:py-1.5 py-1  text-[#4a4a4a] rounded-md border border-[#4a4a4a] hover:bg-[#c0c0c0] hover:text-[#fafafa] opacity-75 hover:opacity-100 hover:border-[#c0c0c0] text-sm md:text-base"><a href="' . esc_url( get_pagenum_link( $current - 1 ) ) . '">' . __('قبلی', 'woocommerce') . '</a></li>';
		} else {
			echo '<li class="lg:px-4 md:px-3 px-2 lg:py-2.5 md:py-1.5 py-1 text-[#4a4a4a] rounded-md border border-[#4a4a4a] bg-[#fafafa] cursor-not-allowed opacity-25 text-sm md:text-base">' . __('قبلی', 'woocommerce') . '</li>';
		}

		// لینک‌های صفحه (بدون دکمه‌های قبلی/بعدی)
		foreach ( $links as $link ) {
			if ( strpos( $link, 'prev' ) !== false || strpos( $link, 'next' ) !== false ) {
				continue; // حذف دکمه‌های prev/next از paginate_links
			}
			if ( strpos( $link, 'current' ) !== false ) {
				echo '<li class="lg:px-4 md:px-3 px-2 lg:py-2.5 md:py-1.5 py-0.5 bg-[#c9a6df] text-[#fafafa] rounded border border-[#c9a6df] ">' . $link . '</li>';
			} else {
				echo '<li class="lg:px-4 md:px-3 px-2 lg:py-2.5 md:py-1.5 py-1 text-[#4a4a4a] rounded-md border border-[#4a4a4a] hover:bg-[#c0c0c0] hover:text-[#fafafa] hover:border-[#c0c0c0] opacity-75 hover:opacity-100 text-sm md:text-base">' . $link . '</li>';
			}
		}

		// دکمه بعدی
		if ( $current < $total ) {
			echo '<li class="lg:px-4 md:px-3 px-2 lg:py-2.5 md:py-1.5 py-1 text-[#4a4a4a] rounded-md border border-[#4a4a4a] hover:bg-[#c0c0c0] hover:text-[#fafafa] opacity-75 hover:opacity-100 hover:border-[#c0c0c0] text-sm md:text-base"><a href="' . esc_url( get_pagenum_link( $current + 1 ) ) . '">' . __('بعدی', 'woocommerce') . '</a></li>';
		} else {
			echo '<li class="lg:px-4 md:px-3 px-2 lg:py-2.5 md:py-1.5 py-1 text-[#4a4a4a] rounded-md border border-[#4a4a4a] bg-[#fafafa] cursor-not-allowed opacity-25">' . __('بعدی', 'woocommerce') . '</li>';
		}

		echo '</ul>';
	}
	?>
</nav>