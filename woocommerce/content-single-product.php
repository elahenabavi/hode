<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["pay"]="no";

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
$price        = (float) $product->get_price();
$regularPrice = (float) $product->get_regular_price();
$offPercent   = null;
if ($regularPrice > 0 && $price < $regularPrice) {
    $offPercent = round( 100 * ($regularPrice - $price) / $regularPrice );
}

?>
<?php
global $product;
/* if ( ! $product || ! $product->is_type('variable') ) return; */
if ( ! $product ) {
    $product = wc_get_product( get_the_ID() );
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( ' max-w-screen-lg mx-auto mb-15', $product ); ?>>
</div>
<div id="alertwalleterror" class="hidden  bg-[#e35053] py-3 px-8 z-60 rounded-lg text-[#fafafa]"></div>
<div id="alertwalletsuccess" class="hidden bg-[#74c69d] py-3 px-8 z-60 rounded-lg text-[#fafafa]"></div>
<div class="max-w-[80%] mx-auto rtl">
  <div class="flex flex-col lg:flex-row gap-12">
    <!--  گالری محصول -->
<?php
global $product;
$gallery_ids = $product->get_gallery_image_ids();
$featured_id = get_post_thumbnail_id($product->get_id());

// ترکیب تصویر شاخص و گالری (بدون تکرار)
$image_ids = array_values(array_unique(array_merge([$featured_id], $gallery_ids)));

if (!empty($image_ids)):
    // تصویر اصلی اولیه
    $main_id = $image_ids[0];
    $main_large = wp_get_attachment_image_src($main_id, 'large');
    $main_thumb = wp_get_attachment_image_src($main_id, 'thumbnail');
?>
<div class="lg:w-1/2 product-gallery">
  <!-- تصویر بزرگ -->
  <div class="relative group rounded-lg overflow-hidden shadow-lg">
    <img id="mainImage"
         src="<?php echo esc_url($main_large[0]); ?>"
         alt="<?php echo esc_attr(get_the_title()); ?>"
         class="w-full h-[450px] object-cover transition-transform duration-500 group-hover:scale-105"
         data-large="<?php echo esc_url($main_large[0]); ?>"
         data-thumb="<?php echo esc_url($main_thumb[0]); ?>"
         data-id="<?php echo esc_attr($main_id); ?>" />
  </div>

  <?php
  // بندانگشتی‌ها: همه تصاویر به جز تصویر بزرگ فعلی
  $thumb_ids = array_filter($image_ids, function($id) use ($main_id) { return $id != $main_id; });
  if (!empty($thumb_ids)):
  ?>
  <div class="flex gap-3 mt-4   overflow-x-hidden gallery-thumbs">
    <?php foreach ($thumb_ids as $id):
      $img_large = wp_get_attachment_image_src($id, 'large');
      $img_thumb = wp_get_attachment_image_src($id, 'thumbnail');
      if (!$img_large || !$img_thumb) continue;
    ?>
      <img
        class="thumb w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-purple-500 hover:scale-110 transition-all"
        src="<?php echo esc_url($img_thumb[0]); ?>"
        data-large="<?php echo esc_url($img_large[0]); ?>"
        data-thumb="<?php echo esc_url($img_thumb[0]); ?>"
        data-id="<?php echo esc_attr($id); ?>"
        alt="<?php echo esc_attr(get_the_title() . ' thumbnail'); ?>"
      />
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>
<?php endif; ?>
<div class="lg:w-1/2 flex flex-col gap-6 ">	
<?php
$limittime="no";
// بررسی اینکه آیا محصول ویژگی "خرید مدت دار" دارد
$attributes = $product->get_attributes();
foreach( $attributes as $attribute ):
    $name = wc_attribute_label( $attribute->get_name() ); 
    if ($name === 'modat'):
        $product_id = $product->get_id();
		$limittime="yes";
?>
<div class="flex">
<h1 class="lg:text-4xl  text-3xl font-semibold text-[#4a4a4a] tracking-tight"><?php the_title(); ?></h1>
<div class=" inline-block lg:mt-3 mt-2 mr-3 relative">
    <span 
        class="px-2 w-25 py-1 bg-[#c9a6df] hover:underline md:text-sm text-xs text-[#fafafa] rounded-2xl cursor-pointer"
        data-product-id="<?php echo $product_id; ?>"
        onclick="toggleSelect(this)">
        خرید مدت دار
    </span>
    <!-- سلکت آپشن مخفی -->
    <select 
        class="hidden absolute top-full mt-2 left-0 bg-[#fafafa] border border-[#c0c0c0] rounded-lg shadow px-2 py-1 text-sm mr-10"
        data-select-product="<?php echo $product_id; ?>">
        <option value="">انتخاب کنید</option>
        <option value="3">3 روز</option>
        <option value="6">6 روز</option>
        <option value="9">9 روز</option>
        <option value="12">12 روز</option>
        <option value="15">15 روز</option>
    </select>
</div>
</div>
<?php 
    endif;
endforeach;
if($limittime=="no"){
	?>
	<h1 class="lg:text-4xl  text-3xl font-semibold text-[#4a4a4a] tracking-tight"><?php the_title(); ?></h1>
	<?php
}
?>
<style>

</style>
<!--  قیمت -->
        <div class="flex items-center gap-3 lg:text-2xl text-xl ">
       <?php if(($regularPrice != $price)&& ($regularPrice>1)): ?>
            <del class="text-gray-400 text-lg"><?php echo toPersianNumerals(number_format($product->get_regular_price())); ?> تومان</del>
            <?php endif; ?>
            <span class="font-semibold  text-[#c9a6df] "><?php echo toPersianNumerals(number_format($product->get_price())); ?> تومان</span>
		</div>
<div class="grid grid-cols-1  info-product" >
<?php
$attributes = $product->get_attributes();
if ( $product->is_type('simple') ) {
	?>
	<div class="">
	<?php
	if ( ! empty( $attributes ) ) {
        foreach ( $attributes as $attribute ) {
            $name = wc_attribute_label( $attribute->get_name() ); 
            $value = $product->get_attribute( $attribute->get_name() );
            if ( $name == 'سایز:' || $name == 'جنس:' || $name == 'رنگ ثابت:' || $name == 'حساسیت:' || $name=='مدت استفاده:') {
				echo '<p class="text-base font-bold mt-3 text-[#4a4a4a]">'
				. esc_html($name) .'</p> <p class="text-base text-[#c9a6df] font-semibold ">'
				 . $value .'</p>';
            }
        }  
	}
	?>
	</div>
	<?php
    woocommerce_simple_add_to_cart();
}
else{
	?>
	<p class="text-end text-sm text-[#4a4a4a] font-semibold mb-1">انتخاب رنگ</p>
	<?php
		woocommerce_template_single_add_to_cart();
}
?>
</div>
        <!--  تب‌ها -->
        <div class="mt-8">
            <div class="flex gap-6 border-b border-gray-200">
                <div class="tab cursor-pointer pb-3 font-semibold border-b-2 border-[#c9a6df] text-[#c9a6df] transition" data-tab="desc">توضیحات</div>
                <div class="tab cursor-pointer pb-3 font-semibold text-[#4a4a4a] hover:text-[#c9a6df] transition" data-tab="reviews">نقد و بررسی</div>
                <div class="tab cursor-pointer pb-3 font-semibold text-[#4a4a4a] hover:text-[#c9a6df] transition" data-tab="additional">ویژگی‌ها</div>
				<div class="tab cursor-pointer pb-3 font-semibold text-[#4a4a4a] hover:text-[#c9a6df] transition" data-tab="reserveproduct">رزرو</div>
            </div>
            <div class="tab-content mt-6 animate-fade" id="desc"><?php the_content(); ?></div>
            <div class="tab-content hidden mt-6 animate-fade" id="reviews">
                <div class="space-y-4">
				<?php get_template_part('comments'); ?>
                </div>
            </div>
			<?php
			$attributes = $product->get_attributes();
			 ?>
            <div class="tab-content hidden mt-6 animate-fade" id="additional">
                <div class="bg-[#fafafa] p-4 rounded-xl border border-[#c0c0c0] ">
                    <?php 
						if ( ! empty( $attributes ) ) {
        					foreach ( $attributes as $attribute ) {
            					$name = wc_attribute_label( $attribute->get_name() ); 
            					$value = $product->get_attribute( $attribute->get_name() );
            						if ( $name != 'مدل'  &&
										 $name != 'رنگ لباس' && $name != 'مدت استفاده:' && $name !='modat') {
                                        if ($name=='color') {
                                            $name="رنگبندی:";
                                        }   
                                        elseif($name=='size')
                                            $name=="سایز:";
                                        elseif($name=='material')
                                            $name="جنس:";
										echo ' <div class="flex mt-2"> <p class="text-sm font-bold  text-[#4a4a4a] ">'
										. esc_html($name) .'</p> <p class="text-sm text-[#4a4a4a] opacity-75 font-semibold px-3">'
				 						. $value .'</p> </div>';    }   }	}
	                                else{
		                                echo '<p class="text-[#4a4a4a] text-sm">در حال حاضر اطلاعات بیشتری در دسترس نیست.</p>';
	                                    }

            $secondhand="no";?>
					
                </div>
            </div>
			<div class="tab-content" id="reserveproduct">	
			<?php
			if ( ! empty( $attributes ) ) {
    		foreach ( $attributes as $attribute ) {
        			$name = wc_attribute_label( $attribute->get_name() ); 
        			$value = $product->get_attribute( $attribute->get_name() );
        	if ( $name == 'مدت استفاده:'){ 
					$secondhand="yes";}
			}  
	}?>
	<?php
	if($secondhand!="yes"){ 
	global $product, $wpdb;
	$product_price = $product->get_price();
	$product_id = $product->get_id();
	$user_id = get_current_user_id();
	// دریافت موجودی کیف پول
	$wallet = $wpdb->get_row(
    $wpdb->prepare("SELECT balance, locked FROM wp_user_wallet WHERE user_id = %d", $user_id));
	$balance = $wallet ? $wallet->balance : 0;
	$locked = $wallet ? $wallet->locked : 0;
?>
<div class="mt-4">
  <button id="btnReserve" class="px-8 py-2 bg-[#4a4a4a] text-[#fafafa] hover:bg-[#fafafa] hover:border-[#4a4a4a] hover:border hover:text-[#4a4a4a] rounded-md">رزرو</button>
  <div id="reserveOptions" class="mt-2 hidden">
    <label class="text-[#4a4a4a] font-semibold">مدت رزرو (روز):</label>
    <select id="reserveDays" class="border border-[#c0c0c0] rounded-md py-1 px-2  text-[#4a4a4a]">
      <option value="2">2 روز</option>
      <option value="4">4 روز</option>
      <option value="6">6 روز</option>
      <option value="8">8 روز</option>
	  <option value="10">10 روز</option>
    </select>
    <div class="mt-2">
      <span id="depositAmount" class="text-[#4a4a4a] font-semibold">مبلغ ودیعه: 0 تومان</span>
    </div>
    <button id="confirmReserve" class="mt-2 px-3 py-1 hover:bg-[#c0c0c0] bg-[#c9a6df] text-white rounded-md">تایید رزرو</button>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const productPrice = <?php echo $product_price; ?>;
    const productId = <?php echo $product_id; ?>;
    const userId = <?php echo $user_id; ?>;
    let walletBalance = <?php echo $balance; ?>;
    let walletLocked = <?php echo $locked; ?>;

    const btnReserve = document.getElementById('btnReserve');
    const reserveOptions = document.getElementById('reserveOptions');
    const reserveDays = document.getElementById('reserveDays');
    const depositAmount = document.getElementById('depositAmount');
    const confirmReserve = document.getElementById('confirmReserve');

    btnReserve.addEventListener('click', () => reserveOptions.classList.toggle('hidden'));

    function updateDeposit() {
        const days = parseInt(reserveDays.value);
        const deposit = Math.ceil(productPrice * 0.1 * days);
        depositAmount.innerText = `مبلغ ودیعه: ${deposit} تومان`;
    }

    reserveDays.addEventListener('change', updateDeposit);
    updateDeposit();

    confirmReserve.addEventListener('click', () => {
        const days = parseInt(reserveDays.value);
        const deposit = Math.ceil(productPrice * 0.1 * days);

        if (walletBalance < deposit) {
			let msgBox = document.getElementById("alertwalleterror");
           document.getElementById("alertwalleterror").innerText = "موجودی کافی نیست. لطفا کیف پول را شارژ کنید.";
		   msgBox.classList.remove("hidden");
		    setTimeout(() => {
       	   msgBox.classList.add("hidden");
    	}, 4000);
            return;
        }

        // ارسال اطلاعات رزرو به PHP با AJAX
        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'reserve_product',
                user_id: userId,
                product_id: productId,
                deposit: deposit,
                days: days
            })
        })
        .then(res => res.json())
        .then(data => {
			 let msgBox = document.getElementById("alertwalletsuccess");
            if (data.success) {
                /* alert(data.message); */
				msgBox.classList.remove("hidden");
				msgBox.innerText = data.message;
                walletBalance -= deposit;
                walletLocked += deposit;
            } else {
                /* alert(data.message); */
				msgBox.classList.remove("hidden");
				msgBox.innerText = data.message;
            }
			  setTimeout(() => {
        		msgBox.classList.add("hidden");
   			 }, 5000);
        });
    });
});
</script>

<?php }

 if($secondhand =="yes") {
    echo '<p class="text-[#4a4a4a] text-center pt-5 md:text-base text-sm ">محصولات دست دوم شامل رزرو نمیباشند.</p>';
 }
?>
			</div>
        </div>
    </div>
  </div>
</div>
<script>
//  تب‌ها
const tabs = document.querySelectorAll('.tab');
const contents = document.querySelectorAll('.tab-content');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        // همه تب‌ها ریست بشن
        tabs.forEach(t => {
            t.classList.remove('border-b-2', 'border-[#c9a6df]', 'text-[#c9a6df]');
            t.classList.add('text-[#4a4a4a]');
        });

        // همه محتواها مخفی بشن
        contents.forEach(c => c.classList.add('hidden'));

        // تب انتخاب شده فعال بشه
        tab.classList.add('border-b-2', 'border-[#c9a6df]', 'text-[#c9a6df]');
        tab.classList.remove('text-[#4a4a4a]');

        // محتوای مربوط به اون تب نمایش داده بشه
        document.getElementById(tab.dataset.tab).classList.remove('hidden');
    });
});


document.querySelectorAll(".color-option").forEach(opt=>{
    const color = opt.dataset.color;
    const selectEl = document.querySelector('select[name^="attribute_pa_color"]');
    opt.addEventListener("click", ()=>{
        if(selectEl){
            selectEl.value = color;
            selectEl.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });
});

document.addEventListener("DOMContentLoaded", function(){
    document.querySelector('[data-tab="desc"]').click();
    const selects = document.querySelectorAll("select[data-select-product]");
    const toggleBtns = document.querySelectorAll("span[data-product-id]");
    toggleBtns.forEach(btn => {
        btn.addEventListener("click", function(){
            const productId = this.dataset.productId;
            const select = document.querySelector(`select[data-select-product="${productId}"]`);
            if (!select) return;

            select.classList.toggle("hidden");
            select.classList.toggle("animate-fadeIn");
        });
    });
    selects.forEach(sel => {
        sel.addEventListener("change", function(){
            const productId = this.getAttribute("data-select-product");
            const value = this.value ? this.value : "no"; // اگر خالی بود no ذخیره بشه

            // ارسال به وردپرس Ajax
            fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                method: "POST",
                headers: {"Content-Type": "application/x-www-form-urlencoded"},
                body: new URLSearchParams({
                    action: "save_rental_option",
                    product_id: productId,
                    option: value
                })
            })
            .then(res => res.json())
            .then(data => {
                console.log("SESSION:", data);
            })
            .catch(err => console.error("Ajax error:", err));
        });
    });
});

</script>

<?php

	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
/* 	do_action( 'woocommerce_before_single_product_summary' ); */
?>


   
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
	  
/* 	woocommerce_template_single_title(); */
		?>

<?php
	 ?> 


     <?php  
	






	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */

?>

<?php /* do_action( 'woocommerce_after_single_product' );  */?>


