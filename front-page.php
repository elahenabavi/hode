<?php
session_start();
get_header();
$_SESSION["pay"]="no";?>
<div class="grid grid-cols-1 lg:max-w-[80%] max-w-[90%] mx-auto">
    <div class="">
    <div class="relative mt-10 rounded-xl overflow-hidden ">
  <div class="slide hidden fade  lg:h-130 h-52 md:h-90 ">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/form.jpg" class="w-full h-full object-cover rounded-xl" />
  </div>
  <div class="slide hidden fade lg:h-130 h-52 md:h-90 ">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/slider1.png" class="w-full h-full object-cover rounded-xl" />
  </div>
  <div class="slide hidden fade  lg:h-130 h-52 md:h-90 ">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/slider2.jpg" class="w-full h-full object-cover rounded-xl" />
  </div>
  <div class="slide hidden fade lg:h-130 h-52 md:h-90 ">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/slider3.jpg" class="w-full h-full object-cover rounded-xl" />
  </div>
  <!-- دکمه‌های ناوبری -->
  <button onclick="changeSlide(-1)" class="absolute top-1/2  right-4  -translate-y-1/2 bg-black/40 hover:bg-black/70 text-[#fafafa] md:px-3 md:py-2  px-2 py-1 rounded-full transition">❮</button>
  <button onclick="changeSlide(1)" class="absolute top-1/2 left-4 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-[#fafafa] md:px-3 md:py-2 px-2 py-1 rounded-full transition">❯</button>
</div>
    <div class="flex justify-center mt-4 space-x-2">
        <span class="dot lg:w-4 lg:h-4 md:w-3 md:h-3 h-2 w-2 bg-[#c0c0c0] rounded-full cursor-pointer transition" onclick="currentSlide(1)"></span>
        <span class="dot lg:w-4 lg:h-4 md:w-3 md:h-3 h-2 w-2 bg-[#c0c0c0] rounded-full cursor-pointer transition" onclick="currentSlide(2)"></span>
        <span class="dot lg:w-4 lg:h-4 md:w-3 md:h-3 h-2 w-2 bg-[#c0c0c0] rounded-full cursor-pointer transition" onclick="currentSlide(3)"></span>
        <span class="dot lg:w-4 lg:h-4 md:w-3 md:h-3 h-2 w-2 bg-[#c0c0c0] rounded-full cursor-pointer transition" onclick="currentSlide(4)"></span>
    </div>
</div>
</div>
<!-- دسته بندی ها -->
<div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:w-[80%] w-[90%] mx-auto mt-15 ">
    <?php
    $args = array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'exclude'    => array( 26, 25,15 )
    );
    $product_categories = get_terms($args);
    foreach ($product_categories as $category) {
        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
        $image = wp_get_attachment_url($thumbnail_id);
         $category_link = get_term_link($category); // لینک دسته‌بندی
?>
            <a href="<?php echo esc_url($category_link); ?>" class="group relative aspect-[3/4] mx-auto overflow-hidden rounded-xl block">
            <!-- عکس دسته -->
            <img src="<?php echo esc_url($image); ?>" 
                 alt="<?php echo esc_attr($category->name); ?>" 
                 class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110" />
            <!-- نوار بنفش نیمه‌شفاف -->
            <div class="absolute w-full h-[17%] md:h-[15%] inset-0 top-[75%] bg-pr2 opacity-50 transition-colors duration-500 ease-in-out"></div>
            <!-- عنوان دسته -->
            <span class="absolute top-[80%] left-1/2 -translate-x-1/2 text-white font-bold lg:text-lg md:text-xl text-sm transition-all duration-500 ease-in-out group-hover:lg:text-xl group-hover:text-lg group-hover:md:text-2xl group-hover:top-[82%]">
                <?php echo esc_html($category->name); ?>
            </span>
            </a>
    <?php } ?>
</div>
<?php
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC'
);
$loop = new WP_Query( $args );
if ( $loop->have_posts() ) : ?>
    <section class=" lg:max-w-[80%] max-w-[90%]  mx-auto py-12">
       <hr class="lg:w-[10%] w-[20%] mx-auto border-t-2 border-[#c0c0c0] rounded">
        <h2 class="lg:text-2xl text-xl font-semibold my-4 text-center txt-gr1 ">جدیدترین محصولات</h2>
      <hr class="lg:w-[10%] w-[20%]  mx-auto border-t-2 border-[#c0c0c0] rounded">
        <div class="grid grid-cols-2 md:grid-cols-3  lg:grid-cols-4 gap-6 mt-10">
            <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                <div class="group relative rounded-xl shadowbox overflow-hidden ">
                    <div class="relative w-full lg:h-100 md:h-80 h-72 overflow-hidden bg-green-200">
                        <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                            <?php 
                            $attachment_ids = $product->get_gallery_image_ids();
                            $main_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->get_id()), 'medium' );
                            ?>
                            <!-- عکس اول -->
                            <img src="<?php echo esc_url($main_image[0]); ?>" 
                                 alt="<?php the_title(); ?>" 
                                 class="w-full object-contain md:h-80 md:object-cover  <?php echo isset($attachment_ids[0]) ? 'transition-opacity duration-500 group-hover:opacity-0' : ''; ?>" />
                            
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
                                 $offPercent = 100 * ($regularPrice - $price) / $price;
                                }
                                ?>
                        <?php if(($regularPrice != $price) && ($regularPrice > 1) ): ?>
    	                    <span class="absolute md:top-4 top-3 right-3 py-1 lg:px-4 md:right-4 rounded-full bg-[#c9a6df] px-2 text-xs 
				                         txt-wh lg:text-sm">تخفیف</span>
	                        <?php endif; ?>
                    </div> 
                    <!-- باکس پایین اون سفیده-->
                    <div class="absolute bottom-0 left-0 w-full bg-[#fafafa] transition-all duration-500 
                                h-[100px] lg:h-[110px] lg:group-hover:h-[160px] z-20 flex flex-col justify-between text-center">
                        <div class="p-3 relative">
                            <h3 class="lg:text-lg text-sm md:text-base font-semibold mb-2 line-clamp-1 txt-gr1"><?php the_title(); ?></h3>
                            <div class=" flex pt-3 justify-center"dir="ltr">            
                                <sub class="text-xs txt-pr2 ">تومان</sub>
                                <p class="mx-2 font-bold lg:text-lg text-sm txt-gr1 "><?php echo toPersianNumerals(number_format($price)) ?></p>
                                <?php if($regularPrice != $price && $regularPrice >1): ?>
                                <p class="txt-gr1 line-through lg:text-lg text-[16px] self-center ml-1"><?php echo toPersianNumerals(number_format($regularPrice)) ?></p>
                                <?php endif?>
                                <?php if ($offPercent): ?><span class="bg-[#c9a6df] text-[#fafafa] lg:px-2 rounded-md  lg:static absolute top-4 left-3 px-1 lg:text-base text-xs">
                                <?= toPersianNumerals(number_format($offPercent)) ?>%
                                </span>
                                <?php endif; ?> 
                            </div>
                        </div>                       
                        <div class="p-3  opacity-0 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-300">
                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>"
                            class="block w-full bg-[#c9a6df] hover:bg-[#c0c0c0] text-[#f8f8f8] rounded-xl py-2">
                            مشاهده و خرید
                            </a>
                        </div>
                    </div>
 
                </div>

            <?php endwhile; ?>
        </div>
    </section>
<?php endif;
/*  محصولات اسلایدر*/
wp_reset_postdata();

$args = array(
  'status'   => 'publish',
  'limit'    => 6,
  'orderby'  => 'meta_value_num',
  'meta_key' => 'total_sales',
  'order'    => 'DESC',
);
$best_sellers = wc_get_products($args);

?>
<hr class="lg:w-[10%] w-[20%]  mx-auto border-t-2 border-[#c0c0c0] rounded">
    <h2 class="lg:text-2xl text-xl font-semibold my-4 text-center txt-gr1 ">پرفروش ترین محصولات</h2>
<hr class="lg:w-[10%] w-[20%]  mx-auto border-t-2 border-[#c0c0c0] rounded">
<div class="relative lg:max-w-[80%] max-w-[90%] mx-auto mt-10">
  <div class="swiper myBestSellerSlider">
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
<button class="swiper-button-next relative top-90 
  rounded-full shadow-xl flex items-center justify-center !bg-[#c9a6df] p-3">
<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" >
  <path d="M8.62 12 L15.38 5.5" stroke="#4a4a4a" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M8.62 12 L15.38 18.5" stroke="#4a4a4a" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</button>

<button class="swiper-button-prev 
  rounded-full shadow-xl flex items-center justify-center !bg-[#c9a6df] p-3">
<svg  viewBox="0 0 24 24" fill="none"  >
  <path d="M8.62 12 L15.38 5.5" stroke="#4a4a4a" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M8.62 12 L15.38 18.5" stroke="#4a4a4a" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</button>
</div>
<!-- پرسش های متداول -->
<div class="lg:max-w-[80%] max-w-[90%] mx-auto pb-30 pt-20">
<hr class="lg:w-[10%] w-[20%] mx-auto border-t-2 border-[#c0c0c0] rounded">
    <h2 class="lg:text-2xl text-xl font-semibold my-4 text-center txt-gr1 ">پرسش های متداول</h2>
<hr class="lg:w-[10%] w-[20%]  mx-auto border-t-2 border-[#c0c0c0] rounded">
<?php
$faq_query = new WP_Query(array(
    'post_type' => 'faq',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
));

if ($faq_query->have_posts()):
?>
<div class="max-w-3xl mx-auto px-4 py-9 space-y-4">
  <?php while ($faq_query->have_posts()): $faq_query->the_post(); ?>
    <div class="border border-[#c0c0c0] rounded-md overflow-hidden shadow-sm">
      <button class="faq-toggle w-full flex items-center justify-between px-4 py-3 bg-[#fafafa] transition-all duration-300">
        <h3 class="text-right md:text-base font-semibold text-sm text-[#4a4a4a]"><?php the_title(); ?></h3>
        <span class="toggle-icon text-xl text-[#4a4a4a] transition-transform duration-300 lg:px-2  px-1  bg-[#c0c0c0] hover:bg-[#c9a6df] rounded-full">+</span>
      </button>
      <div class="faq-content max-h-0 overflow-hidden px-4 text-right text-[#4a4a4a]  transition-all duration-500 ease-in-out">
        <div class="md:py-2 py-1 lg:text-base text-sm text-[#4a4a4a] opacity-75"><?php the_content(); ?></div>
      </div>
    </div>
  <?php endwhile; wp_reset_postdata(); ?>
</div>
<?php endif; ?>
</div>
<?php get_footer()?>

