<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["pay"]="yes";
/*
Template Name: Cart
*/
get_header();
// شروع سشن

// گرفتن همه محصولات (مثلاً در یک Loop)
$args = [
    'post_type' => 'product',
    'posts_per_page' => -1
];
$loop = new WP_Query($args);

if ($loop->have_posts()) :
    while ($loop->have_posts()) : $loop->the_post();
        global $product;
        $product_id = $product->get_id();

        // بررسی اینکه آیا سشن برای این محصول ست شده و مقداری دارد
        $session_key = 'timed_option_' . $product_id;
        if (isset($_SESSION[$session_key]) && !empty($_SESSION[$session_key])) {
            echo '';
        }
    endwhile;
endif;

wp_reset_postdata();
$user_id = get_current_user_id();

// گرفتن اشتراک فعال کاربر
global $wpdb;
$subscription = $wpdb->get_row( $wpdb->prepare(
    "SELECT plan FROM wp_user_subscriptions WHERE user_id=%d AND status='active' AND start_date <= NOW() AND end_date >= NOW() LIMIT 1",
    $user_id
) );

$membership_discount = 0;
if ($subscription) {
    if ($subscription->plan === 'gold') {
        $membership_discount = 0.05; // ۵٪
    } elseif ($subscription->plan === 'silver') {
        $membership_discount = 0.02; // ۲٪
    }
}

// محاسبه سبد
$subtotal_regular = 0;
$total_discount   = 0;
foreach ( WC()->cart->get_cart() as $cart_item ) {
    $_product = $cart_item['data'];
    $regular_price = (float) $_product->get_regular_price();
    $sale_price    = (float) $_product->get_sale_price();

    $subtotal_regular += $regular_price * $cart_item['quantity'];

    if ( $sale_price && $sale_price < $regular_price ) {
        $total_discount += ($regular_price - $sale_price) * $cart_item['quantity'];
    }
}

// اعمال تخفیف اشتراک
$membership_discount_amount = ($subtotal_regular - $total_discount) * $membership_discount;
$payable = ($subtotal_regular - $total_discount) - $membership_discount_amount;
?>
<div id="remove-alert" class="hidden  fixed lg:top-[24%] lg:right-2 top-[22%] md:top-[20%] right-0 bg-[#e35053]
 border border-[#e35053] text-[#fafafa] px-4 py-3 rounded shadow-lg z-50 flex items-center justify-between gap-4">
  <span id="remove-alert-text">محصولی از سبد خرید شما حذف شد.</span>
  <button id="close-remove-alert" class="text-[#fafafa] font-bold">×</button>
</div>
<?php defined( 'ABSPATH' ) || exit; ?>
<form class="w-full" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
      <p class="md:text-3xl text-2xl font-bold text-center text-[#4a4a4a] mt-15 gap-2">
 سبد خرید 
</p>
  <div class="flex flex-col lg:flex-row gap-6 max-w-[80%] mx-auto">
    <div class="flex-1 bg-[#fafafa] rounded-lg shadow p-4 mt-15">
      <table class="w-full hidden lg:table">
        <thead>
          <tr class="text-[#4a4a4a] text-sm  border-b border-[#c0c0c0]">
            <th class="py-2 opacity-75">عکس</th>
            <th class="py-2 opacity-75">نام محصول</th>
            <th class="py-2 opacity-75">قیمت واحد</th>
            <th class="py-2 opacity-75">تعداد</th>
            <th class="py-2 opacity-75">قیمت کل</th>
            <th class="py-2 opacity-75">حذف</th>
          </tr>
        </thead>
        <tbody id="cart-items">
          <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
            $_product   = $cart_item['data'];
            if ( ! $_product || ! $_product->exists() ) continue;
            $product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';

            $regular_price = (float) $_product->get_regular_price();
            $sale_price    = (float) $_product->get_sale_price();
            $price         = (float) $_product->get_price();

            if ( $sale_price && $sale_price < $regular_price ) {
              $discount = ($regular_price - $sale_price) * $cart_item['quantity'];
            } else {
              $discount = 0;
            }
          ?>
          <tr class="border-b border-[#c0c0c0] cart-item"
                data-name="<?php echo esc_attr($_product->get_name()); ?>"
              data-key="<?php echo esc_attr( $cart_item_key ); ?>"
              data-price="<?php echo esc_attr( $sale_price && $sale_price < $regular_price ? $sale_price : $regular_price ); ?>"
              data-regular="<?php echo esc_attr( $regular_price ); ?>">

            <td class="py-3">
              <a href="<?php echo esc_url( $product_permalink ); ?>">
                <?php echo $_product->get_image( 'thumbnail', [ 'class' => 'w-17 h-17 rounded-lg object-cover' ] ); ?>
              </a>
            </td>
            <td class="text-[#4a4a4a] text-center flex flex-col pt-8"><?php echo $_product->get_name(); ?>
            <p class="text-[#4a4a4a] text-sm"><?php
            $product_id = $cart_item['product_id'];
           if (isset($_SESSION['rental_option'][$product_id])) {
            echo "مدت انتخاب:" . $_SESSION['rental_option'][$product_id]."روز";
            } else {
            echo "";
            }?>
            </p>
            </td>
            <td class="text-center text-[#4a4a4a]">
              <?php if ( $sale_price && $sale_price < $regular_price ) : ?>
                <span class="ml-2"><?php echo toPersianNumerals(wc_price( $sale_price )); ?></span>
              <?php else : ?>
                <?php echo toPersianNumerals(wc_price( $regular_price )); ?>
              <?php endif; ?>
            </td>
            <td>
              <div class="flex items-center justify-center gap-2">
                <button type="button" class="qty-btn px-2  bg-[#c9a6df] hover:bg-[#c0c0c0] rounded-sm text-[#fafafa]" data-action="minus">−</button>
                <input 
                  type="text" 
                  name="cart[<?php echo $cart_item_key; ?>][qty]" 
                  value="<?php echo esc_attr( $cart_item['quantity'] ); ?>" 
                  min="1" 
                  class="w-10 text-center text-[#4a4a4a] qty-input"
                />
                <button type="button" class="qty-btn px-2  bg-[#c9a6df] hover:bg-[#c0c0c0] rounded-sm text-[#fafafa]" data-action="plus">+</button>
              </div>
            </td>
            <td class="text-center subtotal text-[#4a4a4a] ">
            <?php
            if ( $sale_price && $sale_price != $regular_price ) { 
               
                echo toPersianNumerals(wc_price( $sale_price * $cart_item['quantity'] )); }
            else
                echo toPersianNumerals(wc_price( $regular_price * $cart_item['quantity'] ));     
                ?>
            </td>
            <td class="text-center text-[#4a4a4a]">
              <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="text-white px-1  rounded-sm bg-red-500 remove-item">×</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- موبایل -->
      <div class="lg:hidden p-2 flex flex-col gap-4 text-[#4a4a4a]" id="cart-items-mobile">
        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
          $_product   = $cart_item['data'];
          if ( ! $_product || ! $_product->exists() ) continue;
          $product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';

          $regular_price = (float) $_product->get_regular_price();
          $sale_price    = (float) $_product->get_sale_price();
        ?>
        <div class="flex p-4 items-center justify-between border border-[#c0c0c0]  rounded-lg cart-item" 
        data-name="<?php echo esc_attr($_product->get_name()); ?>"
        data-key="<?php echo esc_attr( $cart_item_key ); ?>"
        data-price="<?php echo esc_attr( $sale_price && $sale_price < $regular_price ? $sale_price : $regular_price ); ?>"
         data-regular="<?php echo esc_attr( $regular_price ); ?>">
          <a href="<?php echo esc_url( $product_permalink ); ?>" class="flex items-center gap-3">
            <?php echo $_product->get_image( 'thumbnail', [ 'class' => 'w-15 h-15 rounded-lg object-cover' ] ); ?>
            <span class="text-[#4a4a4a] text-sm flex flex-col font-bold"><?php echo $_product->get_name(); ?>
            <p class="text-[#c9a6df] text-xs pt-1 "><?php
                $product_id = $cart_item['product_id'];
                if (isset($_SESSION['rental_option'][$product_id])) {
                    echo "مدت انتخاب:" . $_SESSION['rental_option'][$product_id];} 
                else { echo "";}?>
            </p>
            </span>
          </a>
          <div class="flex flex-col items-end gap-2">
            <span class="text-sm text-[#4a4a4a] ">
              <?php if ( $sale_price && $sale_price < $regular_price ) : ?>
                <span class="ml-2"><?php echo wc_price( $sale_price ); ?></span>
              <?php else : ?>
                <?php echo wc_price( $regular_price ); ?>
              <?php endif; ?>
            </span>
            <div class="flex items-center gap-2 mt-2">
              <button type="button" class="qty-btn px-2  bg-[#c9a6df] hover:bg-[#c0c0c0] rounded-sm" data-action="minus">−</button>
              <input 
                type="text" 
                name="cart[<?php echo $cart_item_key; ?>][qty]" 
                value="<?php echo esc_attr( $cart_item['quantity'] ); ?>" 
                min="0" 
                class="w-8 w-10 text-center text-[#4a4a4a] rounded qty-input"
              />
              <button type="button" class="qty-btn px-2  bg-[#c9a6df] hover:bg-[#c0c0c0] rounded-sm" data-action="plus">+</button>
            </div>
            <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="text-red-500 text-sm font-semibold remove-item mt-2 ">حذف</a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- باکس خلاصه -->
    <aside class="lg:w-1/3 bg-[#fafafa] rounded-2xl shadow md:p-5 p-8  h-fit lg:mt-15 mt-10">
      <h2 class="text-lg font-semibold mb-4 text-[#4a4a4a]">خلاصه فاکتور</h2>
      <div class="flex justify-between mb-2 text-[#4a4a4a]">
        <span>تعداد کالاها</span>
        <span id="summary-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
      </div>
      <?php 
        $subtotal_regular = 0;
        $total_discount   = 0;
        foreach ( WC()->cart->get_cart() as $cart_item ) {
          $_product = $cart_item['data'];
          $regular_price = (float) $_product->get_regular_price();
          $sale_price    = (float) $_product->get_sale_price();

          $subtotal_regular += $regular_price * $cart_item['quantity'];

          if ( $sale_price && $sale_price < $regular_price ) {
            $total_discount += ($regular_price - $sale_price) * $cart_item['quantity'];
          }
        }
        $payable = $subtotal_regular - $total_discount;
      ?>
      <div class="flex justify-between mb-2 text-[#4a4a4a]">
        <span>جمع کل</span>
        <span id="summary-subtotal"><?php echo wc_price( $subtotal_regular ); ?></span>
      </div>
      <div class="flex justify-between mb-2 text-[#4a4a4a]">
        <span>تخفیف</span>
        <span id="summary-discounts"><?php echo wc_price( $total_discount ); ?></span>
      </div>
       <div class="flex justify-between mb-2 text-[#4a4a4a]">
        <span>تخفیف اشتراک</span>
        <span id="summary-membership-discount"><?php echo wc_price( $membership_discount_amount ); ?></span>
      </div>
      <div class="flex justify-between font-bold text-[#c9a6df] text-lg mb-4">
        <span>قابل پرداخت</span>
        <span id="summary-total"><?php echo wc_price( $payable ); ?></span>
      </div>
      <?php if ( wc_coupons_enabled() ) : ?>
        <div class="flex gap-2 mb-4">
          <input type="text" id="coupon_code" class="flex-1 border border-[#c0c0c0] rounded px-2 py-1" placeholder="کد تخفیف">
          <button type="button" id="apply_coupon" class="bg-[#4a4a4a] text-[#fafafa] px-3 py-1 rounded">اعمال</button>
      </div>
      <?php endif; ?>
        <button type="button" id="update_cart_btn" class= "hidden">
            به‌روزرسانی سبد
        </button>
<!-- هر کی هر خریدی بکنه به اسم من ثبت میشه البته پیش فرض گزاشتم چون خرید صورت نمیگیره -->
<div class="grid grid-cols-2 gap-2">
<form method="post" action="">
  <button type="submit" name="elahe_direct_checkout"
    class="block w-full bg-[#c0c0c0] text-[#fafafa] text-center py-3 rounded-lg lg:hover:bg-[#c9a6df] transition">
    اقدام به پرداخت
  </button>
</form>
<button type="submit" name="test_direct_checkout"
    class="block w-full bg-[#c9a6df] text-[#fafafa] text-center py-3 rounded-lg lg:hover:bg-[#c0c0c0] transition">
  پرداخت با کیف پول
</button>
</div>
    </aside>
  </div>
</form>
<div class="mb-30"></div>

<script>
    var membershipDiscountAmount = <?php echo $membership_discount_amount; ?>;
  var payableAmount = <?php echo $payable; ?>;
jQuery(function($){

  // URL ایجکس ووکامرس
  const ajaxUrl = (window.wc_cart_params && wc_cart_params.wc_ajax_url)
    ? wc_cart_params.wc_ajax_url.toString()
    : (window.wc_add_to_cart_params ? wc_add_to_cart_params.wc_ajax_url.toString() : '');

  function endpoint(name){
    return ajaxUrl ? ajaxUrl.replace('%%endpoint%%', name) : '';
  }

  // فرمت قیمت محلی (نمایشی)
  function formatPrice(price) {
    return new Intl.NumberFormat('fa-IR', { style: 'currency', currency: 'IRR' }).format(price);
  }
// حذف آیتم با نمایش پیام
$(document).on('click', '.remove-item', function(e){
  e.preventDefault();
  const url = $(this).attr('href');
  const $row = $(this).closest('.cart-item');
const productName = $row.data('name');

  $.get(url, function(){
    $row.remove();
    updateSummaryQuick();

    // نمایش پیام حذف
    $('#remove-alert-text').text(`«${productName}» از سبد خرید شما حذف شد.`);
    $('#remove-alert').removeClass('hidden');

    // تایم‌اوت برای بسته شدن خودکار بعد از 5 ثانیه
    setTimeout(function(){
      $('#remove-alert').addClass('hidden');
    }, 5000);
  });
});

// بستن دستی پیام
$(document).on('click', '#close-remove-alert', function(){
  $('#remove-alert').addClass('hidden');
});
  // آپدیت قیمت کل هر ردیف (نمایشی)
  function updateRowSubtotal(row) {
  const price = parseFloat(row.data('price')) || 0; // قیمت واقعی
  let qty = parseInt(row.find('.qty-input').val()) || 1;
  qty = Math.max(1, qty);
  row.find('.qty-input').val(qty);
  const subtotal = price * qty;
  row.find('.subtotal').text(formatPrice(subtotal));
}

function updateSummaryQuick() {
  let container = window.innerWidth < 1024 ? '#cart-items-mobile' : '#cart-items';
  let totalItems = 0;
  let subtotal   = 0;
  let totalDiscount = 0;

  $(`${container} .cart-item`).each(function(){
    const price    = parseFloat($(this).data('price')) || 0;
    const regular  = parseFloat($(this).data('regular')) || price;
    const qty      = Math.max(1, parseInt($(this).find('.qty-input').val()) || 1);

    totalItems   += qty;
    subtotal     += regular * qty;
    totalDiscount += (regular - price) * qty;
  });

  // محاسبه تخفیف اشتراک به صورت پویا
  let membershipDiscount = <?php echo $membership_discount; ?>;
  let membershipDiscountAmount = (subtotal - totalDiscount) * membershipDiscount;
  let payable = (subtotal - totalDiscount) - membershipDiscountAmount;

  $('#summary-count').text(totalItems);
  $('#summary-subtotal').html(`<span class="amount">${formatPrice(subtotal)}</span>`);
  $('#summary-discounts').html(`<span class="amount">${formatPrice(totalDiscount)}</span>`);
  $('#summary-membership-discount').html(`<span class="amount">${formatPrice(membershipDiscountAmount)}</span>`);
  $('#summary-total').html(`<span class="amount">${formatPrice(payable)}</span>`);
}

  // ارسال تغییرات تعداد به ووکامرس
  function commitCartQuantities(done){
    const $form = $('form.w-full');

    // اگر nonce ووکامرس داخل فرم نیست، از wc_cart_params استفاده کن
    if(!$form.find('input[name="woocommerce-cart-nonce"]').length && window.wc_cart_params && wc_cart_params.cart_nonce){
      $('<input>', {type:'hidden', name:'woocommerce-cart-nonce', value: wc_cart_params.cart_nonce}).appendTo($form);
    }

    // سیگنال آپدیت
    if(!$form.find('input[name="update_cart"]').length){
      $('<input>', {type:'hidden', name:'update_cart', value:'1'}).appendTo($form);
    }

    $.post($form.attr('action'), $form.serialize())
      .always(function(){
        updateSummaryQuick();
        if(typeof done === 'function') done();
      });
  }

  // دکمه‌های + و - (فقط آپدیت محلی)
  $(document).on('click', '.qty-btn', function(){
    const $wrap = $(this).closest('.cart-item');
    const $input  = $wrap.find('.qty-input');
    const action = $(this).data('action');

    let val = parseInt($input.val()) || 1;
    if(action === 'plus') val++;
    if(action === 'minus') val = Math.max(1, val - 1);

    $input.val(val);
    updateRowSubtotal($wrap);
    updateSummaryQuick(); // فقط محلی
  });

  // تغییر مستقیم input
  $(document).on('input', '.qty-input', function(){
    const $row = $(this).closest('.cart-item');
    updateRowSubtotal($row);
    updateSummaryQuick();
  });

  // حذف آیتم
  $(document).on('click', '.remove-item', function(e){
    e.preventDefault();
    const url = $(this).attr('href');
    const $row = $(this).closest('.cart-item');

    $.get(url, function(){
      $row.remove();
      updateSummaryQuick();
    });
  });

  // دکمه به‌روزرسانی سبد
  $(document).on('click', '#update_cart_btn', function(e){
    e.preventDefault();
    commitCartQuantities(function(){
      location.reload(); // برای اینکه مطمئن بشیم همه چیز (تخفیف کوپن، موجودی و...) درست اعمال شده
    });
  });

  // کوپن
  $('#apply_coupon').on('click', function(){
    const $form = $('form.w-full');

    if(!$form.find('[name="coupon_code"]').length){
      $('<input>', {type:'hidden', name:'coupon_code', value: $('#coupon_code').val()}).appendTo($form);
    } else {
      $form.find('[name="coupon_code"]').val($('#coupon_code').val());
    }

    if(!$form.find('[name="apply_coupon"]').length){
      $('<input>', {type:'hidden', name:'apply_coupon', value:'1'}).appendTo($form);
    }

    if(!$form.find('input[name="woocommerce-cart-nonce"]').length && window.wc_cart_params && wc_cart_params.cart_nonce){
      $('<input>', {type:'hidden', name:'woocommerce-cart-nonce', value: wc_cart_params.cart_nonce}).appendTo($form);
    }

    $.post($form.attr('action'), $form.serialize(), function(){
      location.reload();
    });
  });

  // شروع اولیه
  updateSummaryQuick();

});




</script>

<?php get_footer(); ?>


