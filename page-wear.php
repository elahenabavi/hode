<?php
/* Template Name: چی بخرم؟ */
get_header();
?>

<div class="lg:max-w-[80%] max-w-[90%] mx-auto my-20">
<form method="get" action="" class="mb-6 flex flex-wrap gap-4 items-center">
  <?php
  // دریافت رنگ‌ها از ویژگی dresscolor
  $colors = get_terms([
      'taxonomy'   => 'pa_dresscolor',
      'hide_empty' => false,
  ]);

  // دریافت مدل‌ها از ویژگی model
  $models = get_terms([
      'taxonomy'   => 'pa_model',
      'hide_empty' => false,
  ]);
  ?>

  <div>
    <label for="dresscolor" class="text-[#4a4a4a] lg:text-lg text-base font-semibold">انتخاب رنگ لباس:</label>
    <select name="dresscolor" id="dresscolor" required class="text-[#c9a6df] lg:text-base text-sm font-semibold">
      <option value="" class="text-[#c9a6df] md:text-base text-xs font-semibold">انتخاب رنگ</option>
      <?php foreach ($colors as $color): ?>
        <option value="<?php echo esc_attr($color->slug); ?>"
                class="text-[#4a4a4a] lg:text-base text-xs font-semibold"
                <?php selected($_GET['dresscolor'] ?? '', $color->slug); ?>>
          <?php echo esc_html($color->name); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="lg:mx-15">
    <label for="model" class="text-[#4a4a4a] lg:text-lg text-base font-semibold">انتخاب مدل لباس:</label>
    <select name="model" id="model" required class="text-[#c9a6df] lg:text-base text-sm font-semibold">
      <option value="" class="text-[#c9a6df] lg:text-base text-xs font-semibold">انتخاب مدل</option>
      <?php foreach ($models as $model): ?>
        <option value="<?php echo esc_attr($model->slug); ?>"
                class="text-[#4a4a4a] lg:text-base text-xs font-semibold"
                <?php selected($_GET['model'] ?? '', $model->slug); ?>>
          <?php echo esc_html($model->name); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <button type="submit"
          class="bg-[#c9a6df] text-[#fafafa] lg:px-4 lg:py-2 px-2 py-1 rounded-md hover:bg-[#c0c0c0] md:mr-auto lg:mr-0">
    جستجو
  </button>
</form>
  <!-- منو  دسته بندی ها -->
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
  <a href="<?php echo esc_url(add_query_arg(['product_cat' => ''], get_permalink())); ?>"
     class="border border-[#4a4a4a] lg:px-4 lg:py-2 px-2 py-2 my-auto flex align-center 
            rounded-full lg:text-sm text-xs font-medium transition <?php echo empty($current_cat_slug) ? $activeClasses : $defaultClasses; ?>">
    همه محصولات
  </a>

  <?php foreach ($categories as $category) :
    $is_active = ($category->slug === $current_cat_slug);
    $finalClasses = $is_active ? $activeClasses : $defaultClasses;

    // حفظ فیلترهای رنگ و مدل هنگام کلیک روی دسته‌بندی
    $category_link = add_query_arg([
        'product_cat' => $category->slug,
        'dresscolor'  => $_GET['dresscolor'] ?? '',
        'model'       => $_GET['model'] ?? ''
    ], get_permalink());
  ?>
    <a href="<?php echo esc_url($category_link); ?>"
       class="lg:px-4 py-2 px-2 border border-[#4a4a4a] rounded-full lg:text-sm text-xs 
              font-medium transition <?php echo $finalClasses; ?>">
      <?php echo esc_html($category->name); ?>
    </a>
  <?php endforeach; ?>
</div>
<?php
if (
    isset($_GET['dresscolor']) && !empty($_GET['dresscolor']) &&
    isset($_GET['model']) && !empty($_GET['model'])
) {
    $selected_color = sanitize_text_field($_GET['dresscolor']);
    $selected_model = sanitize_text_field($_GET['model']);
    $selected_cat   = isset($_GET['product_cat']) ? sanitize_text_field($_GET['product_cat']) : '';

    $tax_query = [
        'relation' => 'AND',
        [
            'taxonomy' => 'pa_dresscolor',
            'field'    => 'slug',
            'terms'    => $selected_color,
        ],
        [
            'taxonomy' => 'pa_model',
            'field'    => 'slug',
            'terms'    => $selected_model,
        ]
    ];

    if (!empty($selected_cat)) {
        $tax_query[] = [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $selected_cat,
        ];
    }

    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => $tax_query
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo "<h2 class='mb-4 text-center text-[#4a4a4a]'>محصولات مناسب با انتخاب شما:</h2>";
        echo "<div class='products grid lg:grid-cols-4 md:grid-cols-3 grid-cols-2 gap-6'>";
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
        echo "</div>";
        wp_reset_postdata();
    } else {
        echo "<p>هیچ محصولی با این ترکیب پیدا نشد.</p>";
    }
}
?>
</div>

<?php get_footer(); ?>