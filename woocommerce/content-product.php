<?php
session_start();
$_SESSION["pay"]="no";
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined('ABSPATH') || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if (! is_a($product, WC_Product::class) || ! $product->is_visible()) {
	return;
}
?>
<?php  global $product;
$price        = (float) $product->get_price();
$regularPrice = (float) $product->get_regular_price();
$offPercent   = null;
if ($regularPrice > 0 && $price < $regularPrice) {
    $offPercent = round( 100 * ($regularPrice - $price) / $regularPrice );
    
}

?>
<div <?php wc_product_class('group relative rounded-xl shadow-xl overflow-hidden',$product); ?>>
	
	<?php
	
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action('woocommerce_before_shop_loop_item');

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	?>

<div class="relative w-full lg:h-100 h-72 md:80 overflow-hidden bg-green-200">
    <a href="<?php the_permalink(); ?>">
        <?php 
        $attachment_ids = $product->get_gallery_image_ids();
		$main_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->get_id()), 'medium' );
        ?>                
        <!-- عکس اول -->
        <img src="<?php echo esc_url($main_image[0]); ?>" 
        	alt="<?php the_title(); ?>" 
        	class="w-full object-contain md:h-80 md:object-cover <?php echo isset($attachment_ids[0]) ? 'transition-opacity duration-500 group-hover:opacity-0' : ''; ?>" />                    
        <!-- عکس دوم (فقط اگر وجود داشته باشه) -->
        <?php if ( isset($attachment_ids[0]) ) : 
        $secondary_image = wp_get_attachment_image_src( $attachment_ids[0], 'medium' ); ?>
        <img src="<?php echo esc_url($secondary_image[0]); ?>" 
        	alt="<?php the_title(); ?>" 
        	class="absolute top-0 left-0 w-full h-80 object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100" />
        <?php endif; ?>
	</a>
	<?php if(($regularPrice != $price) && ($regularPrice > 1) ): ?>
    	<span class="absolute md:top-4 top-3 right-3 py-1 lg:px-4 md:right-4 rounded-full bg-si px-2 text-xs 
				txt-wh lg:text-sm">تخفیف</span>
	<?php endif; ?>
</div>
	
<div class="absolute bottom-0 left-0 w-full bg-[#fafafa] transition-all duration-500 
            lg:h-[165px] h-26 z-20 flex flex-col justify-between "><!-- text-center  md:group-hover:h-[160px] -->
    <div class="p-3 ">
        <p class="lg:text-lg text-sm lg:font-semibold md:text-base md:font-medium line-clamp-1 text-[#4a4a4a]"><?php the_title(); ?></p>
		<div class=" mt-2 md:text-sm text-xs text-sky-700">
			<?php
			$categories = get_the_terms($product->get_id(), 'product_cat');
			if ($categories && !is_wp_error($categories)) {
				echo esc_html($categories[0]->name);
			}
			?>
		</div>
    <div class=" flex text-left justify-start mt-3" dir="ltr">
        <sub class="md:text-xs text-[10px] font-semibold md:font-medium txt-pr2 ">تومان</sub>
        <p class="mx-2 font-bold md:text-lg text-sm txt-gr1 "><?php echo toPersianNumerals(number_format($price)) ?></p>
        <?php if(($regularPrice != $price) && ($regularPrice>1)) : ?>
            <p class="txt-gr1 line-through self-center ml-1"><?php echo toPersianNumerals(number_format($regularPrice)) ?></p>
        <?php endif?>
        <?php if ($offPercent): ?>
			<span class="bg-[#c9a6df] text-[#fafafa] md:text-xs text-[11px] md:static flex py-0.5 px-1  top-2 left-3 absolute my-auto md:p-1 rounded-md ml-auto ">
            	<?php echo toPersianNumerals(number_format($offPercent)) ?>%
            </span>
        <?php endif;  ?>
    </div>
</div>
    <div class="px-3 pb-3  transition-opacity duration-300 flex text-sm justify-center"><!-- opacity-0 group-hover:opacity-100 -->
        <a href="<?php echo get_permalink($product->get_id()); ?>"
        	class="md:block hidden w-full bg-[#c0c0c0] hover:opacity-50 text-[#f8f8f8]
             rounded-xl py-2 text-center ml-2">
			جزئیات محصول 
        </a>
<div id="custom-alert-container" class="fixed top-20 left-1/2 -translate-x-1/2 z-50 space-y-2"></div>

		<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
   <?php echo wc_implode_html_attributes( array(
        'rel'        => 'nofollow',
        'data-product_id' => $product->get_id(),
        'data-product_sku' => $product->get_sku(),
        'data-quantity' => 1,
        'class'      => 'add_to_cart_button ajax_add_to_cart md:block hidden w-full bg-[#c9a6df] hover:opacity-50 text-[#fafafa] rounded-xl py-2 text-center',
    ) ); ?>>
    افزودن به سبد
</a>

</div>
</div>

</div>



<script>
    //رفرش صفحه موقع افزودن ب سبد خرید
/* jQuery(function($){
    $(document.body).on('added_to_cart', function(){
        location.reload(); // رفرش کل صفحه
    });
}); */

/* jQuery(function($){
    $(document.body).on('added_to_cart', function(){
        let $alert = $("a.added_to_cart.wc-forward");

        if($alert.length && !$alert.find(".close-btn").length){
            // افزودن دکمه ×
            $alert.append('<span class="close-btn">&times;</span>');

            // بستن دستی
            $alert.find(".close-btn").on("click", function(e){
                e.preventDefault();
                $alert.fadeOut(300, function(){ $(this).remove(); });
            });

            // محو خودکار بعد 3 ثانیه
            setTimeout(function(){
                $alert.fadeOut(300, function(){ $(this).remove(); });
            }, 3000);
        }
    });
}); */jQuery(function($){
    $(document.body).on('added_to_cart', function(){
        setTimeout(function(){
            let $alert = $("a.added_to_cart.wc-forward");

            if($alert.length && !$alert.find(".close-btn").length){
                // افزودن دکمه ×
                $alert.append('<span class="close-btn" style="margin-right:110px;cursor:pointer;">&times;</span>');

                // بستن دستی
                $alert.find(".close-btn").on("click", function(e){
                    e.preventDefault();
                    $alert.fadeOut(300, function(){ $(this).remove(); });
                    location.reload(); // رفرش دستی
                });

                // محو خودکار بعد 3 ثانیه + رفرش
                setTimeout(function(){
                    $alert.fadeOut(300, function(){
                        $(this).remove();
                        location.reload(); // رفرش خودکار
                    });
                }, 3000);
            }
        }, 300);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add_to_cart_button').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const productId = btn.getAttribute('data-product_id');

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'clear_rental_option',
                    product_id: productId
                })
            })
            .then(res => res.json())
            .then(data => {
                console.log('سشن پاک شد:', data);
            });
        });
    });
});
</script>