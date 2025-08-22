<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'flex max-w-screen-lg mx-auto justify-between mt-13', $product ); ?>>

<div class="flex max-w-screen-lg justify-between mt-13 mx-auto"><!-- شروع بخش وسط -->

<?php
global $product;

$args = array(
    'post_type' => 'product',
    'posts_per_page' => 4,
    'post__not_in' => array( $product->get_id() ),
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat', // بر اساس دسته‌بندی مشابه
            'field'    => 'term_id',
            'terms'    => wp_get_post_terms( $product->get_id(), 'product_cat', array('fields' => 'ids') ),
            'operator' => 'IN',
        ),

    ),
);

$related_products = new WP_Query( $args );
?>
<div class="bg-white w-58 h-60 rounded-xl border border-gray-300 border-1.5 ml-4">
<?php
if ( $related_products->have_posts() ):
    echo '<p class="pr-3 py-3 font-semibold text-gray-600">محصولات مشابه</p> ';
    while ( $related_products->have_posts() ): $related_products->the_post();?>
	<div class="flex px-3">
		<a href="<?php the_permalink();?>"> <?php if (has_post_thumbnail()) {
                the_post_thumbnail('medium', ['class' => 'w-16']);
            }?>
		</a>
   		<p class="text-xs text-gray-500 pr-1 self-center"><?php the_title();?></p>
	</div>
		<hr class="mx-3 my-2 text-gray-300">
    <?php endwhile;
endif;
?>
</div>
<?php
wp_reset_postdata();?>






<div>
    <div class="grid bg-gray-300 w-193 h-120 rounded-lg ">
<div class="place-self-center w-140">
	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>
</div>
</div>

    <div class="flex justify-between mt-2 mb-5">
       <div class=" font-semibold text-xl self-end text-gray-700 ">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
	/* 	do_action( 'woocommerce_single_product_summary' ); */
	/* 	the_title('<h1 class="product_title bg-red-300 entry-title">', '</h1'); */
	  
	woocommerce_template_single_title();
		?>
	</div>

       <div class=" flex mt-5"dir="ltr">
		<?php
	global $product;

		$price = ($product->get_price());
		$regularPrice = ($product->get_regular_price());
		$offPercent = 100 * ($regularPrice - $price) / $price
		?>
            <sup class="text-xs text-sky-700 self-end">تومان</sup>
            <p class="mx-3 font-semibold text-lg "><?php echo toPersianNumerals(number_format($price)) ?></p>
			<?php if($regularPrice != $price): ?>
            <p class="text-gray-400 line-through self-center ml-1"><?php echo toPersianNumerals(number_format($regularPrice)) ?></p>
			<?php endif?>
            <?php if ($offPercent): ?><span class="bg-red-600 text-white px-2 rounded-md ml-9">
				<?= toPersianNumerals(number_format($offPercent)) ?>%
			</span>
		<?php endif; ?> 


        </div>
    </div>
<p class="text-sm/7 text-gray-500 w-191"><?php  echo get_the_excerpt() ?></p>
<button class=" basis-xs bg-blue2 hover:bg-sky-700 text-gray-200 rounded-lg py-3 px-7 my-7 flex">
	<img src="<?php echo get_template_directory_uri();?>/assets/trolley2.png" class="w-5"><span class="self-center text-sm pr-3">افزودن به سبد</span>
</button>
    <p class="font-semibold text-xl text-gray-700">ویژگی ها</p>
     <ul class="list-disc text-gray-500 text-xs *:mr-6 *:mt-4">
        <?php
		$product= wc_get_product(get_the_ID());
		$attributes=($product->get_attributes());
		$count=count($attributes)/2;
				
		for($i=1;$i<=$count;$i++) { 
			
		 ?>
        <li><span class='text-gray-500 text-sm'><?php echo $product->get_attribute("pro$i") ?></span><span class='text-sm text-gray-700 font-semibold mr-3'><?php echo $product->get_attribute("des$i") ?></span></li>
			
     <?php  
	
	} ?>
    </ul>
</div>



	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	/* do_action( 'woocommerce_after_single_product_summary' ); */
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>


</div><!-- پایان بخش وسط -->
<div class="mb-80"></div>