<?php get_header()?>
<?php

echo "hello";
?>

<div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6  lg:w-[80%] w-[90%] mx-auto bg-red-200">
    <?php
    $args = array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
    );
    $product_categories = get_terms($args);

    foreach ($product_categories as $category) {
        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
        $image = wp_get_attachment_url($thumbnail_id);
        ?>
        <div class="group relative w-70 h-95 mx-auto overflow-hidden rounded-2xl">
            <!-- عکس دسته -->
            <img src="<?php echo $image; ?>" 
                 alt="<?php echo $category->name; ?>" 
                 class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110" />
            
            <!-- نوار بنفش نیمه‌شفاف -->
            <div class="absolute w-full h-15 inset-0 top-[75%] bg-pr2 opacity-50 transition-colors duration-500 ease-in-out"></div>
            
            <!-- عنوان دسته -->
            <span class="absolute bottom-12 left-1/2 -translate-x-1/2 text-white font-bold text-lg transition-all duration-500 ease-in-out group-hover:text-xl group-hover:bottom-10">
                <?php echo $category->name; ?>
            </span>
        </div>
    <?php } ?>
</div>


<?php get_footer()?>