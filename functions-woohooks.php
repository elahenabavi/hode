<?php
session_start();
$_SESSION["pay"]="no";
// removing woo stylings
add_filter('woocommerce_enqueue_styles', '__return_false');
add_filter( 'woocommerce_product_add_to_cart_text', 'custom_add_to_cart_text' );



add_filter('woocommerce_show_page_title', function ($title) {
  if (is_shop()) {
    return false; // Hide shop title
  }
  return $title;
});


// to justify content in middle of page
add_action('woocommerce_before_main_content', 'hodecode_content_wrapper', 10);
function hodecode_content_wrapper()
{
  echo '<div id="content" class="mx-auto max-w-screen-lg">'; // Add your desired class here
}
add_action('woocommerce_after_main_content', 'hodecode_content_wrapper_end', 10);
function hodecode_content_wrapper_end()
{
  echo '</div>';
}

// remove sidebar
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');

// removing extra data at shop top page
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

// Adding category bar
add_action('woocommerce_before_shop_loop', 'hodcode_woo_cats');
function hodcode_woo_cats()
{
  $categories = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => false, // include empty categories
  ]);

  $activeClasses = 'bg-[#4a4a4a] text-[#fafafa]';
  $defaultClasses = 'text-[#4a4a4a] hover:bg-[#c0c0c0] hover:border-[#c0c0c0] hover:text-[#fafafa] bg-[#fafafa]';
  if (!empty($categories) && !is_wp_error($categories)) :
    // Get current active category ID (if on product category page)
    $current_cat_id = 0;
    if (is_tax('product_cat')) {
      $current_cat_id = get_queried_object_id();
    }
    $finalClasses = $current_cat_id == 0 ? $activeClasses : $defaultClasses;

?>
    <div class="flex flex-wrap gap-3 py-4">
      <a href="<?php echo bloginfo('url'); ?>"
        class="border border-[#4a4a4a] px-4 py-2 rounded-full text-sm font-medium transition <?php echo $finalClasses; ?>">
        همه محصولات
      </a>
      <?php foreach ($categories as $category) :
        $is_active = ($category->term_id === $current_cat_id);
        $finalClasses = $is_active ? $activeClasses : $defaultClasses;
      ?>
        <a
          href="<?php echo esc_url(get_term_link($category)); ?>"
          class="px-4 py-2 border border-[#4a4a4a] rounded-full text-sm font-medium transition <?php echo $finalClasses; ?>">
          <?php echo esc_html($category->name); ?>
        </a>
      <?php endforeach; ?>
    </div>

  <?php endif;
}

// Override product loop container
add_filter('woocommerce_product_loop_start', 'hodcode_product_loop_start');
function hodcode_product_loop_start()
{
  return '<ul class="list-none grid grid-cols-2 lg:grid-cols-4 gap-4">';
}

add_filter('woocommerce_product_loop_end', 'hodcode_product_loop_end');
function hodcode_product_loop_end()
{
  return '</ul>';
}

// Product card classes
add_filter('woocommerce_post_class', 'add_bootstrap_product_classes', 10, 2);
function add_bootstrap_product_classes($classes, $product)
{
  $classes[] = 'list-none rounded-lg overflow-hidden bg-[#fafafa]'; // Adjust based on Bootstrap grid size (e.g., col-md-3, col-lg-4)
  return $classes;
}











add_action("woocommerce_after_shop_loop_item", "hodcode_product_loop_item_details_wrapper_close", 40);
function hodcode_product_loop_item_details_wrapper_close()
{
  echo '</div>';
}

// Product card title classes
add_filter('woocommerce_product_loop_title_classes', 'hodecode_product_loop_title_classes');
function hodecode_product_loop_title_classes($classes)
{
  $classes .= ' text-lg font-semibold py-2';
  return $classes;
}

// adding category below title
add_action('woocommerce_shop_loop_item_title', 'hodcode_product_loop_item_category', 15);
function hodcode_product_loop_item_category()
{
  global $product;

  ?>
  <div class="text-sm text-gray-500 mb-2">
    <?php
    $categories = get_the_terms($product->get_id(), 'product_cat');
    if ($categories && !is_wp_error($categories)) {
      echo esc_html($categories[0]->name);
    }
    ?>
  </div>
<?php
}
add_action("woocommerce_after_shop_loop_item", "hodcode_product_link_section_wrapper_close", 11);
function hodcode_product_link_section_wrapper_close()
{
  echo "</div >";
}
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close');
// Price formatting
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');
