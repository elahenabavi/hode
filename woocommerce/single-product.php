<?php
session_start();
$_SESSION["pay"]="no";
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
	/* 	do_action( 'woocommerce_before_main_content' ); */
	?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>
	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
	/* 	do_action( 'woocommerce_sidebar' ); */
	?>
<?php
global $product;

// گرفتن آی‌دی دسته‌بندی‌های محصول فعلی
$category_ids = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'ids' ) );

// آرگومان‌های کوئری
$args = array(
    'limit'   => 6,                 // تعداد محصول مرتبط
    'status'  => 'publish',         // فقط محصولات منتشر شده
    'exclude' => array( $product->get_id() ), // محصول فعلی را حذف کن
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',   // چون داریم ID می‌فرستیم
            'terms'    => $category_ids,
            'operator' => 'IN'
        )
    ),
);

// گرفتن محصولات مرتبط

$best_sellers = wc_get_products( $args );
?>
<hr class="lg:w-[10%] w-[20%]  mx-auto border-t-2 border-[#c0c0c0] rounded mt-15">
<h2 class="lg:text-2xl text-xl font-semibold my-4 text-center txt-gr1 ">
    محصولات مرتبط با "<?php echo esc_html( $product->get_name() ); ?>"
</h2>
<hr class="lg:w-[10%] w-[20%]  mx-auto border-t-2 border-[#c0c0c0] rounded">
<div class="relative lg:max-w-[80%] max-w-[90%] mx-auto mt-10">
  <div class="swiper myBestSellerSlider mb-20">
    <div class="swiper-wrapper">
      <?php foreach ($best_sellers as $product): ?>
        <div class="swiper-slide">
<div class="group relative rounded-xl shadowbox overflow-hidden  mb-4">
    <div class="relative w-full lg:h-100 md:h-80  h-72 overflow-hidden">
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
        <?php 
        $attachment_ids = $product->get_gallery_image_ids();
        $main_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->get_id()), 'medium' );
        ?>
        <!-- عکس اول -->
        <img src="<?php echo esc_url($main_image[0]); ?>" 
        alt="<?php the_title(); ?>" 
        class="w-full object-contain md:h-80 md:object-cover  <?php echo isset($attachment_ids[0]) ? 
        'transition-opacity duration-500 group-hover:opacity-0' : ''; ?>" />
        <!-- عکس دوم (فقط اگر وجود داشته باشه) -->
        <?php if ( isset($attachment_ids[0]) ) : 
            $secondary_image = wp_get_attachment_image_src( $attachment_ids[0], 'medium' ); ?>
            <img src="<?php echo esc_url($secondary_image[0]); ?>" 
            alt="<?php the_title(); ?>" 
            class="absolute top-0 left-0 w-full h-75 object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100" />
        <?php endif; ?>
        </a>
         <?php
	        global $product;
            $price = (float) $product->get_price();
            $regularPrice = (float) $product->get_regular_price();
            $offPercent=0;
            if ($price > 1 && $regularPrice > $price) {
            $offPercent = 100 * ($regularPrice - $price) / $price;}?>
            <?php if(($regularPrice != $price) && ($regularPrice > 1) ): ?>
    	    <span class="absolute md:top-4 top-3 right-3 py-1 lg:px-4 md:right-4 rounded-full bg-[#c9a6df] px-2 text-xs 
				        txt-wh lg:text-sm">تخفیف</span>
	        <?php endif; ?>
    </div>
                    <!--  باکس پایین اون سفیده-->
    <div class="absolute bottom-0 left-0 w-full bg-[#fafafa] transition-all duration-500 
                h-[100px] lg:h-[110px] lg:group-hover:h-[160px] z-20 flex flex-col justify-between text-center">
                <div class="p-3">
                    <h3 class="lg:text-lg text-sm md:text-base font-semibold mb-2 line-clamp-1 txt-gr1"><?php echo $product->get_name(); ?></h3>
                        <div class=" flex pt-3 justify-center"dir="ltr">
                            <?php
	                          
                                ?>
                                <sub class="text-xs txt-pr2 ">تومان</sub>
                                <p class="mx-2 font-bold lg:text-lg text-[16px] txt-gr1 "><?php echo toPersianNumerals(number_format($price)) ?></p>
                                <?php if($regularPrice != $price && $regularPrice>1): ?>
                                <p class="txt-gr1 line-through lg:text-lg text-[16px] self-center ml-1"><?php echo toPersianNumerals(number_format($regularPrice)) ?></p>
                                <?php endif?>
                                <?php if ($offPercent): ?><span class="bg-[#c9a6df] text-[#fafafa] lg:px-2 rounded-md 
                                     lg:static absolute top-4 left-3 px-1 lg:text-base text-xs">
                                <?= toPersianNumerals(number_format($offPercent)) ?>%
                                </span>
                                <?php endif; ?> 
                            </div>
                        </div>
                        <div class="p-3 opacity-0 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-300">
                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>"
                            class="block w-full bg-[#c9a6df] hover:bg-[#c0c0c0] text-[#f8f8f8] rounded-xl py-2">
                            مشاهده و خرید
                            </a>
                        </div>
                   </div>
              </div>
         </div>
      <?php endforeach; ?>
    </div>
  </div> 
<!-- دکمه های اسلایدر -->
  <button class="swiper-button-next relative top-90 lg:!bg-[#c9a6df] lg:hover:!bg-[#c0c0c0] 
  lg:p-7 p-0 rounded-full shadow-xl flex items-center justify-center">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none">
      <path d="M8.62 12 L15.38 5.5" stroke="#4a4a4a" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M8.62 12 L15.38 18.5" stroke="#4a4a4a" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>

  <button class="swiper-button-prev lg:hover:!bg-[#c0c0c0] lg:!bg-[#c9a6df] lg:p-7 p-0 rounded-full shadow-xl flex items-center justify-center">
    <svg viewBox="0 0 24 24" fill="none">
      <path d="M8.62 12 L15.38 5.5" stroke="#4a4a4a" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M8.62 12 L15.38 18.5" stroke="#4a4a4a" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>
</div>










<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
