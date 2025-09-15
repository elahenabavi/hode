<?php
session_start();
$_SESSION["pay"]="no";

defined('ABSPATH') || exit;

get_header('shop');

do_action('woocommerce_shop_loop_header');?>












<?php

// گرفتن دسته‌بندی‌ها
$categories = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => false, // include empty categories
]);

$activeClasses = 'bg-[#4a4a4a] opacity-75 text-[#fafafa]';
$defaultClasses = 'text-[#4a4a4a] lg:hover:bg-[#c0c0c0] lg:hover:border-[#c0c0c0] lg:hover:text-[#fafafa] bg-[#fafafa]';
$current_cat_id = 0;

if (is_tax('product_cat')) {
    $current_cat_id = get_queried_object_id();
}
?>

<div class="max-w-[80%] mx-auto md:mb-20 mb-15">
	<div class="relative inline-block text-left mt-10  rounded-lg border border-1.5 border-[#c0c0c0] z-20">
  		<button id="filterToggle" type="button" class="inline-flex items-center gap-2 px-4 py-2 
		bg-[#fafafa] rounded-md hover:bg-gray-200  transition">
     		<svg xmlns="http://www.w3.org/2000/svg"
             	 class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="#c9a6df">
          	<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                 d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 13.414V19a1 1 0 
                 01-.447.832l-4 2.5A1 1 0 018 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
        	</svg>
  			<span class="md:text-base text-sm font-semibold text-[#4a4a4a]">فیلتر محصولات</span>
  		</button>
  <form method="GET" action="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" id="filterForm"
        class="absolute mt-2 w-64 bg-[#fafafa] border border-gray-200 rounded-md shadow-lg hidden p-4 space-y-4">
    <!-- فیلتر نوع محصول -->
    <div>
      <label class="block text-sm font-medium text-[#4a4a4a] mb-1 text-start">مرتب‌سازی بر اساس</label>
      <select name="sort" class="w-full px-3 py-2 text-sm border text-[#4a4a4a] border-[#c0c0c0] rounded-md">
        <option value="" class="text-[#4a4a4a]">-- انتخاب فیلتر --</option>
        <option value="new" class="text-[#4a4a4a]">🆕 جدیدترین</option>
        <option value="popular" class="text-[#4a4a4a]">🔥 پرفروش‌ترین</option>
        <option value="cheap" class="text-[#4a4a4a]">💸 ارزان‌ترین</option>
        <option value="expensive" class="text-[#4a4a4a]">💎 گران‌ترین</option>
      </select>
    </div>
    <!-- فیلتر قیمت -->
    <div>
      <label class="block text-sm font-medium text-[#4a4a4a] mb-1 text-start">محدوده قیمت</label>
      <div class="flex items-center gap-2">
        <input type="number" name="min_price" placeholder="حداقل" class="w-1/2 px-2 py-1 border border-[#c0c0c0] rounded-md text-sm" />
        <input type="number" name="max_price" placeholder="حداکثر" class="w-1/2 px-2 py-1 border border-[#c0c0c0] rounded-md text-sm" />
      </div>
    </div>
    <button type="submit" class="w-full bg-[#c9a6df] text-[#fafafa] py-2 rounded-md hover:bg-[#4a4a4a] transition text-sm">
      اعمال فیلتر
    </button>
  </form>
</div>
<!-- دسته بندی محصولات -->
<?php if (!empty($categories) && !is_wp_error($categories)) : ?>
    <div class="mt-6 mb-6 overflow-x-auto no-scrollbar">
        <div class="flex flex-nowrap gap-3 min-w-max">
            <?php 
            $finalClasses = $current_cat_id == 0 ? $activeClasses : $defaultClasses;
            ?>
            <a href="<?php echo get_post_type_archive_link('product'); ?>"
                class="border border-[#4a4a4a] lg:px-4 lg:py-2 px-2 py-2 my-auto flex align-center 
				rounded-full lg:text-sm text-xs font-medium transition <?php echo $finalClasses; ?>">
                همه محصولات
            </a>

            <?php foreach ($categories as $category) :
                $is_active = ($category->term_id === $current_cat_id);
                $finalClasses = $is_active ? $activeClasses : $defaultClasses;
            ?>
                <a href="<?php echo esc_url(get_term_link($category)); ?>"
                    class="lg:px-4 py-2 px-2 border border-[#4a4a4a] rounded-full lg:text-sm text-xs  font-medium transition <?php echo $finalClasses; ?>">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php
woocommerce_product_loop_start();
?>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 md:gap-5 gap-4 lg:gap-6">

<?php
$has_products = false; // فلگ بررسی وجود محصول

if (wc_get_loop_prop('total')) {
    while (have_posts()) {
        the_post();
        global $product;

        // چک کردن ویژگی خرید مدت دار
        $has_attr = $product->get_attribute('second-hand');
        if (!empty($has_attr)) {
            continue; // اگر ویژگی داشت، نمایش داده نشود
        }

        do_action('woocommerce_shop_loop');
        wc_get_template_part('content', 'product');

        $has_products = true; // حداقل یک محصول وجود دارد
    }
}

// اگر هیچ محصولی نبود
if (!$has_products) {
    echo '<p class="text-center mt-8 lg:col-span-4 md:col-span-3 col-span-2  font-semibold md:text-base lg:text-lg text-sm  text-[#4a4a4a]">در این دسته بندی محصولی وجود ندارد.</p>';
}
?>

</div>
</div>

<?php
woocommerce_product_loop_end();

do_action('woocommerce_after_shop_loop');
do_action('woocommerce_after_main_content');?>

<?php get_footer('shop'); ?>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("filterToggle");
    const form = document.getElementById("filterForm");

    toggle.addEventListener("click", function () {
      form.classList.toggle("hidden");
    });
  });
</script>
