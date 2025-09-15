<?php
/* Template Name: دست دوم */
get_header();
global $product;
?>

<div class="max-w-[80%] mx-auto">
<?php
$categories = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
]);

$activeClasses = 'bg-[#4a4a4a] opacity-75 text-[#fafafa]';
$defaultClasses = 'text-[#4a4a4a] hover:bg-[#c0c0c0] hover:border-[#c0c0c0] hover:text-[#fafafa] bg-[#fafafa]';

$current_cat_slug = isset($_GET['product_cat']) ? sanitize_text_field($_GET['product_cat']) : '';
?>

<div class="flex gap-3 mt-12 mb-6 overflow-x-auto whitespace-nowrap no-scrollbar scrollbar-hide lg:flex-wrap">
    <a href="<?php echo get_permalink(); ?>"
        class="border border-[#4a4a4a] lg:px-4 lg:py-2 px-2 py-2 my-auto flex align-center 
				rounded-full lg:text-sm text-xs font-medium transition <?php echo empty($current_cat_slug) ? $activeClasses : $defaultClasses; ?>">
        همه محصولات
    </a>
    <?php foreach ($categories as $category) :
        $is_active = ($category->slug === $current_cat_slug);
        $finalClasses = $is_active ? $activeClasses : $defaultClasses;

        $category_link = add_query_arg([
            'product_cat' => $category->slug
        ], get_permalink()); ?>
        <a href="<?php echo esc_url($category_link); ?>"
            class="lg:px-4 py-2 px-2 border border-[#4a4a4a] rounded-full lg:text-sm text-xs 
             font-medium transition text-[#4a4a4a] <?php echo $finalClasses; ?>">
            <?php echo esc_html($category->name); ?>
        </a>
    <?php endforeach; ?>
</div>


<?php
$tax_query = [
    'relation' => 'AND',
    [
        'taxonomy' => 'pa_second-hand',
        'field'    => 'slug',
        'terms'    => ['دارد'], // مقدار ویژگی "دارد"
    ]
];

if (!empty($current_cat_slug)) {
    $tax_query[] = [
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => [$current_cat_slug],
    ];
}

$args = [
    'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => $tax_query
];

$loop = new WP_Query($args);

if ($loop->have_posts()) {
    echo '<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">';
    while ($loop->have_posts()) : $loop->the_post();
        global $product;
        $terms = get_the_terms($product->get_id(), 'product_cat');
         $category_name = '';
    if (!empty($terms) && !is_wp_error($terms)) {
        $category_name = $terms[0]->name;
    }       
        $price        = (float) $product->get_price();
        $regularPrice = (float) $product->get_regular_price();
        $offPercent   = null;
        if ($regularPrice > 0 && $price < $regularPrice) {
            $offPercent = round(100 * ($regularPrice - $price) / $regularPrice);
        }

        $attachment_ids = $product->get_gallery_image_ids();
        $main_image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'medium');
?>
<div class="group relative rounded-xl shadow-xl overflow-hidden">
    <div class="relative w-full lg:h-100 h-72 md:80 overflow-hidden bg-green-200">
        <a href="<?php the_permalink(); ?>">
            <img src="<?php echo esc_url($main_image[0]); ?>"
                alt="<?php the_title(); ?>"
                class="w-full object-contain md:h-80 md:object-cover <?php echo isset($attachment_ids[0]) ? 'transition-opacity duration-500 group-hover:opacity-0' : ''; ?>" />
            <?php if (isset($attachment_ids[0])) :
                $secondary_image = wp_get_attachment_image_src($attachment_ids[0], 'medium'); ?>
                <img src="<?php echo esc_url($secondary_image[0]); ?>"
                    alt="<?php the_title(); ?>"
                    class="absolute top-0 left-0 w-full h-80 object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100" />
            <?php endif; ?>
        </a>
        <?php if ($regularPrice != $price): ?>
            <span class="absolute top-4 py-1 px-4 right-4 rounded-full bg-si txt-wh text-sm">تخفیف</span>
        <?php endif; ?>
    </div>
<!-- باکس پایین -->
    <div class="absolute bottom-0 left-0 w-full bg-[#fafafa] transition-all duration-500 
            lg:h-[165px] h-26 z-20 flex flex-col justify-between">
        <div class="p-3">
            <h3 class="lg:text-lg text-sm lg:font-semibold md:text-base 
            font-medium line-clamp-1  text-[#4a4a4a]"><?php the_title(); ?></h3>
            <div class="pt-1 pb-1 text-xs lg:text-sm text-[#c9a6df] font-semibold">
                <?php
                $attributes = $product->get_attributes();
                if (!empty($attributes)) {
                    foreach ($attributes as $attribute) {
                        $name = wc_attribute_label($attribute->get_name());
                        $value = $product->get_attribute($attribute->get_name());
                        if ($name == 'مدت استفاده:') {
                            echo "<p >$name $value</p>";
                        }
                    }
                }
                ?>
            </div>
            <div class="flex text-left justify-start mt-3" dir="ltr">
                <sub class="md:text-xs text-[10px]  txt-pr2">تومان</sub>
                <p class="mx-2 font-bold md:text-lg text-sm txt-gr1 "><?php echo toPersianNumerals(number_format($price)); ?></p>
                <?php if (($regularPrice != $price) && ($regularPrice > 1)) : ?>
                    <p class="txt-gr1 line-through self-center ml-1"><?php echo toPersianNumerals(number_format($regularPrice)); ?></p>
                <?php endif ?>
                <?php if ($offPercent): ?>
                    <span class="bg-[#c9a6df] text-[#fafafa] text-xs flex my-auto p-1 rounded-md ml-auto">
                        <?php echo toPersianNumerals(number_format($offPercent)); ?>%
                    </span>
                <?php endif; ?>
            </div>
        </div>
        <div class="px-3 pb-3 transition-opacity duration-300 flex text-sm justify-center">
            <a href="<?php echo get_permalink($product->get_id()); ?>"
                class="md:block hidden w-full bg-[#c0c0c0] hover:opacity-50 text-[#f8f8f8] rounded-xl 
                py-2 text-center ml-2">
                جزئیات محصول
            </a>
            <div id="custom-alert-container" class="fixed top-20 left-1/2 -translate-x-1/2  z-50 space-y-2"></div>
            <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                <?php echo wc_implode_html_attributes([
                    'rel' => 'nofollow',
                    'data-product_id' => $product->get_id(),
                    'data-product_sku' => $product->get_sku(),
                    'data-quantity' => 1,
                    'class' => 'add_to_cart_button ajax_add_to_cart block w-full bg-[#c9a6df] md:block hidden hover:opacity-50 text-[#fafafa] rounded-xl py-2 text-center',
                ]); ?>>
                افزودن به سبد
            </a>
        </div>
    </div>
</div>
<?php
    endwhile;
    echo '</div>';
} else {
    echo '<p class="text-[#4a4a4a] text-base text-center mt-5">هیچ محصول  استفاده شده ای با این دسته بندی وجود ندارد</p>';
}
wp_reset_postdata();
?>

</div>
</div>
<div class="mb-20"></div>
<?php get_footer(); ?>