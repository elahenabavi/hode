<?php

// 1. Using hooks
// include('functions-woohooks.php');
// 2. Using template override
 remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close');
add_filter('woocommerce_enqueue_styles', '__return_false');
remove_action('woocommerce_single_product_summary','woocommerce_template_single_title',5);


/* پرسش های متداول */
function create_faq_cpt() {
    $labels = array(
        'name' => 'سوالات متداول',
        'singular_name' => 'سوال متداول',
        'add_new' => 'افزودن سوال',
        'add_new_item' => 'افزودن سوال جدید',
        'edit_item' => 'ویرایش سوال',
        'all_items' => 'همه سوالات',
        'menu_name' => 'سوالات متداول',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-editor-help',
        'show_in_rest' => true, // برای ویرایشگر بلوک
    );

    register_post_type('faq', $args);
}
add_action('init', 'create_faq_cpt');



/* 
add_action('wp_ajax_reserve_product', 'handle_product_reservation');
function handle_product_reservation() {
    global $wpdb;

    $user_id    = intval($_POST['user_id']);
    $product_id = intval($_POST['product_id']);
    $deposit    = floatval($_POST['deposit']);
    $days       = intval($_POST['days']);

    // بررسی موجودی
    $wallet = $wpdb->get_row($wpdb->prepare("SELECT balance, locked FROM wp_user_wallet WHERE user_id = %d", $user_id));
    if (!$wallet || $wallet->balance < $deposit) {
        wp_send_json(['success' => false, 'message' => 'موجودی کافی نیست']);
    }

    // بروزرسانی کیف پول
    $new_balance = $wallet->balance - $deposit;
    $new_locked  = $wallet->locked + $deposit;
    $wpdb->update('wp_user_wallet', [
        'balance' => $new_balance,
        'locked'  => $new_locked
    ], ['user_id' => $user_id]);

    // ثبت رزرو
    $start_date  = current_time('mysql');
    $expire_date = date('Y-m-d H:i:s', strtotime("+$days days"));
    $wpdb->insert('wp_user_reservations', [
        'user_id'     => $user_id,
        'product_id'  => $product_id,
        'deposit'     => $deposit,
        'days'        => $days,
        'start_date'  => $start_date,
        'expire_date' => $expire_date,
        'status'      => 'active'
    ]);

    // ثبت تراکنش
    $wpdb->insert('wp_user_transactions', [
        'user_id'         => $user_id,
        'type'            => 'reserve',
        'amount'          => $deposit,
        'description'     => "رزرو محصول $product_id ($days روز)",
        'transaction_date'=> current_time('mysql')
    ]);

    wp_send_json(['success' => true, 'message' => "رزرو با موفقیت انجام شد و مبلغ $deposit تومان بلوکه شد ✅"]);
}

 */
/*  */add_action('wp_ajax_update_user_profile', function(){
  $user_id = get_current_user_id();
  $name = sanitize_text_field($_POST['name']);
  $email = sanitize_email($_POST['email']);

  wp_update_user([
    'ID' => $user_id,
    'display_name' => $name,
    'user_email' => $email
  ]);

  wp_send_json(['success' => true]);
});




add_action('wp_ajax_charge_wallet', function(){
    global $wpdb;
    $user_id = get_current_user_id();
    if (!$user_id) {
        wp_send_json(['success' => false, 'message' => 'کاربر وارد نشده است']);
    }

    $amount = floatval($_POST['amount']);
    if ($amount <= 0) {
        wp_send_json(['success' => false, 'message' => 'مبلغ نامعتبر است']);
    }

    // بررسی وجود کیف پول
    $wallet = $wpdb->get_row($wpdb->prepare("SELECT balance, locked FROM wp_user_wallet WHERE user_id = %d", $user_id));

    if ($wallet) {
        $new_balance = $wallet->balance + $amount;
        $wpdb->update('wp_user_wallet', ['balance' => $new_balance], ['user_id' => $user_id]);
    } else {
        $new_balance = $amount;
        $wpdb->insert('wp_user_wallet', [
            'user_id' => $user_id,
            'balance' => $new_balance,
            'locked'  => 0
        ]);
    }

    // ثبت تراکنش
    $date = current_time('mysql');
    $wpdb->insert('wp_user_transactions', [
        'user_id' => $user_id,
        'type' => 'credit',
        'amount' => $amount,
        'description' => 'شارژ کیف پول (پرداخت تستی)',
        'transaction_date' => $date
    ]);

    wp_send_json([
        'success' => true,
        'transaction' => [
            'type' => 'credit',
            'amount' => $amount,
            'desc' => 'شارژ کیف پول (پرداخت تستی)',
            'date' => $date
        ],
        'message' => "کیف پول شما به مبلغ {$amount} تومان با موفقیت شارژ شد ✅"
    ]);
});

/*  *//* add_action('wp_ajax_charge_wallet', function(){
  global $wpdb;
  $user_id = get_current_user_id();
  $amount = floatval($_POST['amount']);

  $wallet = $wpdb->get_row($wpdb->prepare("SELECT balance FROM wp_user_wallet WHERE user_id = %d", $user_id));
  $new_balance = $wallet ? $wallet->balance + $amount : $amount;

  $wpdb->update('wp_user_wallet', ['balance' => $new_balance], ['user_id' => $user_id]);

  $wpdb->insert('wp_user_transactions', [
    'user_id' => $user_id,
    'type' => 'credit',
    'amount' => $amount,
    'description' => 'شارژ کیف پول (پرداخت تستی)',
    'transaction_date' => current_time('mysql')
  ]);

  wp_send_json([
    'success' => true,
    'transaction' => [
      'type' => 'credit',
      'amount' => $amount,
      'desc' => 'شارژ کیف پول (پرداخت تستی)',
      'date' => current_time('mysql')
    ],
    'message' => "کیف پول شما به مبلغ {$amount} تومان با موفقیت شارژ شد ✅"
  ]);
});

 */
/* add_action('wp_ajax_buy_subscription', function(){
  global $wpdb;
  $user_id = get_current_user_id();
  $plan = sanitize_text_field($_POST['plan']);

  $plans = [
    'silver' => ['price' => 500000, 'duration' => 30],
    'gold'   => ['price' => 1200000, 'duration' => 365]
  ];
  if(!isset($plans[$plan])) {
    wp_send_json(['success' => false, 'message' => 'پلن نامعتبر است']);
  }
  $price = $plans[$plan]['price'];
  $duration = $plans[$plan]['duration'];
  $wallet = $wpdb->get_row($wpdb->prepare("SELECT balance FROM wp_user_wallet WHERE user_id = %d", $user_id));
  if(!$wallet || $wallet->balance < $price){
    wp_send_json(['success' => false, 'message' => 'موجودی کافی نیست']);
  }
  $wpdb->update('wp_user_wallet', ['balance' => $wallet->balance - $price], ['user_id' => $user_id]);
  $start = current_time('mysql');
  $end = date('Y-m-d H:i:s', strtotime("+$duration days"));
  $wpdb->insert('wp_user_subscriptions', [
    'user_id' => $user_id,
    'plan' => $plan,
    'start_date' => $start,
    'end_date' => $end,
    'status' => 'active'
  ]);
  $plan_titles = [
    'silver' => 'نقره‌ای',
    'gold'   => 'طلایی'
  ];
  $plan_title = isset($plan_titles[$plan]) ? $plan_titles[$plan] : $plan;
  $wpdb->insert('wp_user_transactions', [
    'user_id' => $user_id,
    'type' => 'debit',
    'amount' => $price,
    'description' => "خرید اشتراک {$plan_title} (کیف پول)",
    'transaction_date' => $start
  ]);
  wp_send_json([
    'success' => true,
    'subscription' => [
      'plan' => $plan,
      'title' => $plan_title,
      'start' => $start,
      'end' => $end
    ],
    'transaction' => [
      'type' => 'debit',
      'amount' => $price,
      'desc' => "خرید اشتراک {$plan_title} (کیف پول)",
      'date' => $start
    ],
    'message' => "اشتراک پلن {$plan_title} با موفقیت فعال شد ✅"
  ]);
});
 
 */



/* 

add_action('wp_ajax_buy_subscription', function() {
    global $wpdb;
    $user_id = get_current_user_id();
    $plan = sanitize_text_field($_POST['plan'] ?? '');

    // لیست پلن‌ها
    $plans = [
        'silver' => ['price' => 500000, 'duration' => 30],
        'gold'   => ['price' => 1200000, 'duration' => 365]
    ];

    if (!isset($plans[$plan])) {
        wp_send_json(['success' => false, 'message' => 'پلن نامعتبر است']);
    }

    // بررسی اشتراک فعال
    $active_sub = $wpdb->get_row($wpdb->prepare("
        SELECT plan, start_date, end_date 
        FROM wp_user_subscriptions 
        WHERE user_id = %d AND status = 'active'
    ", $user_id));

    if ($active_sub && strtotime($active_sub->end_date) > current_time('timestamp')) {
        wp_send_json([
            'success' => false,
            'message' => "شما در حال حاضر اشتراک فعال دارید تا " . date('Y-m-d H:i', strtotime($active_sub->end_date))
        ]);
    }

    $price = $plans[$plan]['price'];
    $duration = $plans[$plan]['duration'];

    // بررسی موجودی کیف پول
    $wallet = $wpdb->get_row($wpdb->prepare("SELECT balance FROM wp_user_wallet WHERE user_id = %d", $user_id));
    if (!$wallet || $wallet->balance < $price) {
        wp_send_json(['success' => false, 'message' => 'موجودی کافی نیست']);
    }

    // کم کردن موجودی
    $wpdb->update('wp_user_wallet', ['balance' => $wallet->balance - $price], ['user_id' => $user_id]);

    // ثبت اشتراک
    $start = current_time('mysql');
    $end = date('Y-m-d H:i:s', strtotime("+$duration days"));
    $wpdb->insert('wp_user_subscriptions', [
        'user_id' => $user_id,
        'plan' => $plan,
        'start_date' => $start,
        'end_date' => $end,
        'status' => 'active'
    ]);

    // عنوان پلن
    $plan_titles = [
        'silver' => 'نقره‌ای',
        'gold'   => 'طلایی'
    ];
    $plan_title = $plan_titles[$plan] ?? $plan;

    // ثبت تراکنش
    $wpdb->insert('wp_user_transactions', [
        'user_id' => $user_id,
        'type' => 'debit',
        'amount' => $price,
        'description' => "خرید اشتراک {$plan_title} (کیف پول)",
        'transaction_date' => $start
    ]);

    // پاسخ موفق
    wp_send_json([
        'success' => true,
        'subscription' => [
            'plan' => $plan,
            'title' => $plan_title,
            'start' => $start,
            'end' => $end
        ],
        'transaction' => [
            'type' => 'debit',
            'amount' => $price,
            'desc' => "خرید اشتراک {$plan_title} (کیف پول)",
            'date' => $start
        ],
        'message' => "اشتراک پلن {$plan_title} با موفقیت فعال شد ✅"
    ]);
});


 */
add_action('wp_ajax_buy_subscription', 'buy_subscription_callback');
function buy_subscription_callback() {
    global $wpdb;
    $user_id = get_current_user_id();
    $plan = sanitize_text_field($_POST['plan']);

    // چک کردن اشتراک فعال
    $active_sub = $wpdb->get_row($wpdb->prepare("
        SELECT * FROM wp_user_subscriptions 
        WHERE user_id = %d AND status = 'active' AND end_date > NOW()
    ", $user_id));

    if ($active_sub) {
        wp_send_json([
            'success' => false,
            'message' => 'شما هم‌اکنون اشتراک فعال دارید و نیازی به خرید دوباره نیست.'
        ]);
    }

    // ادامه خرید (کم‌کردن پول و ثبت اشتراک)
    $planData = [
        'silver' => ['price' => 500000, 'days' => 30],
        'gold'   => ['price' => 1200000, 'days' => 365],
    ];

    if (!isset($planData[$plan])) {
        wp_send_json(['success' => false, 'message' => 'پلن نامعتبر است.']);
    }

    $price = $planData[$plan]['price'];

    // گرفتن موجودی
    $wallet = $wpdb->get_row($wpdb->prepare("SELECT balance FROM wp_user_wallet WHERE user_id = %d", $user_id));
    if (!$wallet || $wallet->balance < $price) {
        wp_send_json(['success' => false, 'message' => 'موجودی کیف پول کافی نیست.']);
    }

    // کم کردن از کیف پول
    $wpdb->query($wpdb->prepare("
        UPDATE wp_user_wallet SET balance = balance - %d WHERE user_id = %d
    ", $price, $user_id));

    // ثبت اشتراک
    $start = current_time('mysql');
    $end = date('Y-m-d H:i:s', strtotime("+{$planData[$plan]['days']} days"));
    $wpdb->insert('wp_user_subscriptions', [
        'user_id'    => $user_id,
        'plan'       => $plan,
        'start_date' => $start,
        'end_date'   => $end,
        'status'     => 'active'
    ]);

    // ثبت تراکنش
    $wpdb->insert('wp_user_transactions', [
        'user_id'          => $user_id,
        'type'             => 'subscription',
        'amount'           => $price,
        'description'      => "خرید پلن $plan",
        'transaction_date' => current_time('mysql')
    ]);

    wp_send_json([
        'success' => true,
        'message' => 'پلن با موفقیت فعال شد ✅',
        'subscription' => [
            'plan'  => $plan,
            'start' => $start,
            'end'   => $end
        ],
        'transaction' => [
            'type'  => 'subscription',
            'amount'=> $price,
            'desc'  => "خرید پلن $plan",
            'date'  => current_time('mysql')
        ]
    ]);
}






add_action('wp_ajax_reserve_product', function(){
  global $wpdb;
  $user_id = get_current_user_id();
  $product_id = intval($_POST['product_id']);
  $days = intval($_POST['days']);
  $deposit = floatval($_POST['deposit']);

  $wallet = $wpdb->get_row($wpdb->prepare("SELECT balance, locked FROM wp_user_wallet WHERE user_id = %d", $user_id));
  if(!$wallet || $wallet->balance < $deposit){
    wp_send_json(['success' => false, 'message' => 'موجودی کافی نیست']);
  }

  $new_balance = $wallet->balance - $deposit;
  $new_locked = $wallet->locked + $deposit;
  $wpdb->update('wp_user_wallet', ['balance' => $new_balance, 'locked' => $new_locked], ['user_id' => $user_id]);

  $start = current_time('mysql');
  $expire = date('Y-m-d H:i:s', strtotime("+$days days"));

  $wpdb->insert('wp_user_reservations', [
    'user_id' => $user_id,
    'product_id' => $product_id,
    'deposit' => $deposit,
    'days' => $days,
    'start_date' => $start,
    'expire_date' => $expire,
    'status' => 'active'
  ]);
$product_name = get_the_title($product_id);

  $wpdb->insert('wp_user_transactions', [
    'user_id' => $user_id,
    'type' => 'reserve',
    'amount' => $deposit,
    'description' => "رزرو محصول $product_name ($days روز)",
    'transaction_date' => $start
  ]);

  wp_send_json([
    'success' => true,
    'message' => "رزرو با موفقیت ثبت شد و مبلغ $deposit تومان بلوکه شد ✅",
    'reservation' => [
      'product_id' => $product_id,
      'deposit' => $deposit,
      'days' => $days,
      'start' => $start,
      'expire' => $expire,
      'status' => 'active'
    ],
    'transaction' => [
      'type' => 'reserve',
      'amount' => $deposit,
      'desc' => "رزرو محصول $product_name ($days روز)",
      'date' => $start
    ]
  ]);
});



add_action('wp_ajax_submit_ticket', function(){
  global $wpdb;
  $user_id = get_current_user_id();
  $subject = sanitize_text_field($_POST['subject']);
  $body = sanitize_textarea_field($_POST['body']);
  $desc = "تیکت: {$subject} — {$body}";
  $date = current_time('mysql');

  $wpdb->insert('wp_user_transactions', [
    'user_id' => $user_id,
    'type' => 'ticket',
    'amount' => 0,
    'description' => $desc,
    'transaction_date' => $date
  ]);

  wp_send_json([
    'success' => true,
    'transaction' => [
      'type' => 'ticket',
      'amount' => 0,
      'desc' => $desc,
      'date' => $date
    ]
  ]);
});

add_action('wp_ajax_add_user_transaction', 'add_user_transaction_callback');

function add_user_transaction_callback() {
  $user_id = get_current_user_id();
  if (!$user_id) {
    wp_send_json_error('کاربر وارد نشده');
  }

  global $wpdb;
  $type = sanitize_text_field($_POST['type']);
  $amount = floatval($_POST['amount']);
  $desc = sanitize_text_field($_POST['desc']);
$method = isset($_POST['method']) ? sanitize_text_field($_POST['method']) : 'wallet';
  $wpdb->insert('wp_user_transactions', [
    'user_id' => $user_id,
     'type'   => $method,
    'amount' => $amount,
    'description' => $desc,
    'transaction_date' => current_time('mysql')
  ]);

  wp_send_json_success();
}




//ذخیره توی سشن برای خرید مدت دار
// هندل کردن ذخیره‌ی انتخاب خرید مدت‌دار در سشن
add_action('wp_ajax_save_rental_option', 'save_rental_option');
add_action('wp_ajax_nopriv_save_rental_option', 'save_rental_option');

function save_rental_option() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $option     = isset($_POST['option']) ? sanitize_text_field($_POST['option']) : 'no';

    if ($product_id > 0) {
        $_SESSION['rental_option'][$product_id] = $option;
        wp_send_json([
            'success' => true,
            'product_id' => $product_id,
            'option' => $option,
            'message' => 'گزینه ذخیره شد'
        ]);
    } else {
        wp_send_json([
            'success' => false,
            'message' => 'محصول معتبر نیست'
        ]);
    }

    wp_die(); // حتما باید باشه
}

add_action('wp_ajax_clear_rental_option', 'clear_rental_option');
add_action('wp_ajax_nopriv_clear_rental_option', 'clear_rental_option');

function clear_rental_option() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if ($product_id > 0 && isset($_SESSION['rental_option'][$product_id])) {
        unset($_SESSION['rental_option'][$product_id]);
        wp_send_json(['success' => true, 'message' => 'سشن پاک شد']);
    } else {
        wp_send_json(['success' => false, 'message' => 'محصول یا سشن پیدا نشد']);
    }

    wp_die();
}

/* اصلاح شده ضمانت و تعویض */

add_action('woocommerce_thankyou', 'save_warranty_after_order', 10, 1);

function save_warranty_after_order($order_id) {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
  $order = wc_get_order($order_id);
  $user_id = $order->get_user_id();
  $created_at = current_time('mysql');

  foreach ($order->get_items() as $item) {
    $product_id = $item->get_product_id();

    $zemanat = wc_get_product_terms($product_id, 'pa_zemanat', ['fields' => 'names']);
    if (!empty($zemanat)) {
      global $wpdb;
      $wpdb->insert('wp_product_warranties', [
        'user_id'    => $user_id,
        'order_id'   => $order_id,
        'product_id' => $product_id,
        'start_date' => $created_at,
        'end_date'   => date('Y-m-d H:i:s', strtotime('+3 months', strtotime($created_at))),
        'created_at' => $created_at
      ]);
    }

    $taviz = wc_get_product_terms($product_id, 'pa_taviz', ['fields' => 'names']);
    if (!empty($taviz)) {
      global $wpdb;
      $wpdb->insert('wp_product_replacements', [
        'user_id'    => $user_id,
        'order_id'   => $order_id,
        'product_id' => $product_id,
        'start_date' => $created_at,
        'end_date'   => date('Y-m-d H:i:s', strtotime('+5 days', strtotime($created_at))),
        'created_at' => $created_at
      ]);
    }

    if (isset($_SESSION['rental_option'][$product_id])) {
  $session_duration = intval($_SESSION['rental_option'][$product_id]);
  $end_date = date('Y-m-d H:i:s', strtotime("+{$session_duration} days", strtotime($created_at)));
error_log("در حال بررسی محصول {$product_id} با مدت اعتبار: " . $_SESSION['rental_option'][$product_id]);
global $wpdb;
if (!isset($wpdb)) {
    error_log('❌ $wpdb در دسترس نیست!');
} else {
    error_log('✅ $wpdb آماده استفاده است.');
}
  $result = $wpdb->insert('wp_durable_purchases', [
  'user_id'          => $user_id,
  'order_id'         => $order_id,
  'product_name'     => $item->get_name(), // چون فیلد product_name داری، نه product_id
  'purchase_time'    => $created_at,
  'session_duration' => $session_duration,
  'expiration_time'  => $end_date
]);
  if (!$result) {
    error_log("خطا در درج دیتابیس: " . $wpdb->last_error);
} else {
    error_log("✅ درج موفق برای محصول {$product_id}");
}

}
  }
  // ذخیره خریدهای مدت‌دار


}



add_action('init', 'elahe_custom_checkout_redirect');

function elahe_custom_checkout_redirect() {
  if ( isset($_POST['elahe_direct_checkout']) ) {
    if ( ! is_user_logged_in() ) return;

    $user_id = get_current_user_id();
    $address = [
      'first_name' => 'کاربر',
      'last_name'  => '',
      'email'      => wp_get_current_user()->user_email,
      'phone'      => '',
      'address_1'  => '',
      'city'       => '',
      'state'      => '',
      'postcode'   => '',
      'country'    => 'IR',
    ];

    $order = wc_create_order();
    foreach ( WC()->cart->get_cart() as $item ) {
      $order->add_product( $item['data'], $item['quantity'] );
    }

    $order->set_address( $address, 'billing' );
    $order->set_customer_id( $user_id );
    $order->calculate_totals();
    $order->update_status('completed'); // یا 'processing' یا هر وضعیت دلخواه

    // اجرای تابع ذخیره‌سازی ضمانت‌نامه
    save_warranty_after_order( $order->get_id() );

    wp_redirect( $order->get_checkout_order_received_url() );
    exit;
  }
}

//=============نمایش ضمانت نامه و تعویض==============

add_action('wp_ajax_load_user_warranties', function(){
  echo do_shortcode('[user_warranties]');
  wp_die();
});
add_action('wp_ajax_load_user_replacements', function(){
  echo do_shortcode('[user_replacements]');
  wp_die();
});

/* شورتکد نمایش کالاهای ضمانت دار و تعویض  در پنل کاربری */
add_shortcode('user_replacements', function(){
  $user_id = get_current_user_id();
  global $wpdb;
  $items = $wpdb->get_results("SELECT * FROM wp_product_replacements WHERE user_id = $user_id ORDER BY created_at DESC");

  if (!$items) return '<div>هیچ تعویض کالایی ثبت نشده است.</div>';

  $html = '<table class="w-full text-sm border border-gray-200">
    <thead>
      <tr class="bg-gray-100">
        <th class="border p-2">محصول</th>
        <th class="border p-2">تاریخ شروع</th>
        <th class="border p-2">تاریخ پایان</th>
      </tr>
    </thead>
    <tbody>';

  foreach ($items as $item){
    $product_name = get_the_title($item->product_id);
    $html .= "<tr>
      <td class='border p-2'>{$product_name}</td>
      <td class='border p-2 replacement-date-start '>{$item->start_date}</td>
      <td class='border p-2 replacement-date-end'>{$item->end_date}</td>
    </tr>";
  }

  $html .= '</tbody></table>';
  return $html;
});
add_shortcode('user_warranties', function(){
  $user_id = get_current_user_id();
  global $wpdb;
  $items = $wpdb->get_results("SELECT * FROM wp_product_warranties WHERE user_id = $user_id ORDER BY created_at DESC");

  if (!$items) return '<div class="text-sm text-gray-500">هیچ ضمانت‌نامه‌ای ثبت نشده است.</div>';

  $html = '<table class="w-full text-sm border border-gray-200">
    <thead>
      <tr class="bg-gray-100">
        <th class="border p-2">محصول</th>
        <th class="border p-2">تاریخ شروع</th>
        <th class="border p-2">تاریخ پایان</th>
      </tr>
    </thead>
    <tbody>';

  foreach ($items as $item){
    $product_name = get_the_title($item->product_id);
    $html .= "<tr>
      <td class='border p-2'>{$product_name}</td>
      <td class='border p-2 warranty-date-start'>{$item->start_date}</td>
      <td class='border p-2 warranty-date-end'>{$item->end_date}</td>
    </tr>";
  }

  $html .= '</tbody></table>';
  return $html;
});


add_shortcode('user_durable_purchases', function(){
  $user_id = get_current_user_id();
  global $wpdb;
  $items = $wpdb->get_results("SELECT * FROM wp_durable_purchases WHERE user_id = $user_id ORDER BY created_at DESC");

  if (!$items) return '<div class="text-sm text-gray-500">هیچ خرید مدت‌داری ثبت نشده است.</div>';

  $html = '<table class="w-full text-sm border border-gray-200">
    <thead>
      <tr class="bg-gray-100">
        <th class="border p-2">محصول</th>
        <th class="border p-2">مدت اعتبار</th>
        <th class="border p-2">تاریخ شروع</th>
        <th class="border p-2">تاریخ پایان</th>
      </tr>
    </thead>
    <tbody>';

  foreach ($items as $item){
    $product_name = get_the_title($item->product_id);
    $html .= "<tr>
      <td class='border p-2'>{$product_name}</td>
      <td class='border p-2'>{$item->session_duration} روز</td>
      <td class='border p-2'>{$item->start_date}</td>
      <td class='border p-2'>{$item->end_date}</td>
    </tr>";
  }

  $html .= '</tbody></table>';
  return $html;
});
















add_action('template_redirect', function(){

    if ( isset($_POST['test_direct_checkout']) ) {

        if ( !is_user_logged_in() ) {
            wp_die('لطفاً ابتدا وارد حساب کاربری شوید.');
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $wpdb;
        $user_id = get_current_user_id();
        $created_at = current_time('mysql');

        // ---------- محاسبه مبلغ با تخفیف اشتراک ----------
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

        // گرفتن اشتراک کاربر
        $subscription = $wpdb->get_row( $wpdb->prepare(
            "SELECT plan FROM wp_user_subscriptions WHERE user_id=%d AND status='active' AND start_date <= NOW() AND end_date >= NOW() LIMIT 1",
            $user_id
        ) );

        $membership_discount = 0;
        if ($subscription) {
            if ($subscription->plan === 'gold') $membership_discount = 0.05;
            elseif ($subscription->plan === 'silver') $membership_discount = 0.02;
        }

        $membership_discount_amount = ($subtotal_regular - $total_discount) * $membership_discount;

        // مبلغ قابل پرداخت بعد از همه تخفیف‌ها
        $cart_total = ($subtotal_regular - $total_discount) - $membership_discount_amount;

        // ---------- بررسی موجودی کیف پول ----------
        $wallet = $wpdb->get_var($wpdb->prepare("SELECT balance FROM wp_user_wallet WHERE user_id=%d", $user_id));
        if (!$wallet || $wallet < $cart_total) {
            wp_die('موجودی کیف پول کافی نیست ❌');
        }

        // ---------- ثبت ضمانت، تعویض و خرید مدت دار قبل از خالی کردن سبد ----------
        foreach (WC()->cart->get_cart() as $cart_item) {
            $product_id = $cart_item['product_id'];
            $product_name = $cart_item['data']->get_name();

            // ضمانت نامه
            $zemanat = wc_get_product_terms($product_id, 'pa_zemanat', ['fields' => 'names']);
            if (!empty($zemanat)) {
                $wpdb->insert($wpdb->prefix . 'product_warranties', [
                    'user_id'    => $user_id,
                    'order_id'   => 0,
                    'product_id' => $product_id,
                    'start_date' => $created_at,
                    'end_date'   => date('Y-m-d H:i:s', strtotime('+3 months', strtotime($created_at))),
                    'created_at' => $created_at
                ]);
            }

            // تعویض
            $taviz = wc_get_product_terms($product_id, 'pa_taviz', ['fields' => 'names']);
            if (!empty($taviz)) {
                $wpdb->insert($wpdb->prefix . 'product_replacements', [
                    'user_id'    => $user_id,
                    'order_id'   => 0,
                    'product_id' => $product_id,
                    'start_date' => $created_at,
                    'end_date'   => date('Y-m-d H:i:s', strtotime('+5 days', strtotime($created_at))),
                    'created_at' => $created_at
                ]);
            }

            // خرید مدت دار
            if (isset($_SESSION['rental_option'][$product_id])) {
                $session_duration = intval($_SESSION['rental_option'][$product_id]);
                $end_date = date('Y-m-d H:i:s', strtotime("+{$session_duration} days", strtotime($created_at)));

                $wpdb->insert($wpdb->prefix . 'durable_purchases', [
                    'user_id'          => $user_id,
                    'order_id'         => 0,
                    'product_name'     => $product_name,
                    'purchase_time'    => $created_at,
                    'session_duration' => $session_duration,
                    'expiration_time'  => $end_date
                ]);
            }
        }

        // ---------- کم کردن از کیف پول ----------
        $wpdb->update('wp_user_wallet', ['balance' => $wallet - $cart_total], ['user_id' => $user_id]);

        // ---------- ثبت تراکنش ----------
        $wpdb->insert('wp_user_transactions', [
            'user_id'         => $user_id,
            'type'            => 'debit',
            'amount'          => $cart_total,
            'description'     => 'پرداخت سبد خرید با کیف پول',
            'transaction_date'=> $created_at
        ]);

        // ---------- خالی کردن سبد ----------
        WC()->cart->empty_cart();

        // ریدایرکت به صفحه تشکر
        wp_redirect(home_url('/thanks'));
        exit;
    }
});

/* فیلتر قیمت */









































/* 



function render_user_dashboard() {
    $user_id = get_current_user_id();
    if (!$user_id) {
        echo 'کاربر وارد نشده';
        return;
    }

    // یوزرنیم
    $user_info = get_userdata($user_id);
    $username = $user_info->user_login;

    // کیف پول
    global $wpdb;
    $wallet = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM wp_user_wallet WHERE user_id = %d", $user_id)
    );
    $balance = $wallet ? $wallet->balance : 0;
    $locked  = $wallet ? $wallet->locked : 0;

    // HTML
    ?>
    <div class="dashboard  mt-2">
        <p><?php echo number_format($balance); ?> تومان</p> 
    </div>
    <?php
}
// ================================
// هندلر گرفتن اشتراک فعال کاربر
// ================================
function handle_get_active_subscription() {
 
global $wpdb;

// گرفتن آی‌دی کاربر فعلی
$user_id = get_current_user_id();
if (!$user_id) {
    echo 'کاربر وارد نشده';
    return;
}

// گرفتن رکورد آخرین اشتراک فعال کاربر
$subscription = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM wp_user_subscriptions WHERE user_id=%d ORDER BY end_date DESC LIMIT 1",
    $user_id
));

// بررسی اینکه رکورد وجود دارد
if ($subscription) {
    $subscription_id = $subscription->subscription_id;
    $plan            = $subscription->plan;
    $start_date      = $subscription->start_date;
    $end_date        = $subscription->end_date;
    $status          = $subscription->status;

    // برای تست می‌توانیم چاپ کنیم
    // echo "ID: $subscription_id, Plan: $plan, Start: $start_date, End: $end_date, Status: $status";
} else {
    $subscription_id = null;
    $plan            = null;
    $start_date      = null;
    $end_date        = null;
    $status          = null;
}
?>

<div class="bg-white rounded-lg p-4 shadow-sm">
        <div class="text-sm text-[var(--muted)]">اشتراک فعال</div>
        <div class="text-lg font-medium">
          <?php
          if($plan=="gold"){
            echo "طلایی";
          }
          elseif($plan=="silver"){
            echo "نقره ای";
          }
          else 
            echo "ندارید";
          ?>
        </div>
        <div class="text-sm text-[var(--muted)]">
          <?php 
          if($plan=="gold" || $plan=="silver"){
            echo 'پایان: '. "$end_date";
          }
          else
            echo "اشتراک بخرید";
          ?></div>
        <div class="mt-3"><button class="px-3 py-1 border rounded-md text-sm text-indigo-600 border-indigo-200" onclick="renderPage('subscriptions')">مدیریت اشتراک</button></div>
</div>
<?php

}

// ================================
// گرفتن آخرین تراکنش کاربر
// ================================

function type_of_transaction() {
 
    global $wpdb;
    $plan='';
    $user_id = get_current_user_id();
    if (!$user_id) {
        echo 'کاربر وارد نشده'; // کاربر وارد نشده
        return;
    }

    $table_name = $wpdb->prefix . 'user_transactions';

    $query = $wpdb->prepare(
        "SELECT type, transaction_date FROM $table_name WHERE user_id = %d ORDER BY transaction_date DESC LIMIT 1",
        $user_id
    );

    $transaction = $wpdb->get_row($query, ARRAY_A);

    if (!$transaction) {
        echo "تراکنشی وجود ندارد"; // تراکنشی پیدا نشد
        return;
    }
    $subscription = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM wp_user_subscriptions WHERE user_id=%d ORDER BY end_date DESC LIMIT 1",
    $user_id
    ));
    if ($subscription) {
    $plan  = $subscription->plan;
    }
    else {
    echo "";
}



    if($plan=="gold")
      $plantype="طلایی";
    elseif($plan=="silver")
      $plantype="نقره ای";
    else
      $plantype= "";

    if ($transaction['type']=="credit"){
      echo "شارژ کیف پول(پرداخت تستی)";
    }
    elseif ($transaction['type']=="debit")
      echo "پرداخت";
    elseif ($transaction['type']=="reserve")
      echo "رزرو محصول";
    elseif($transaction['type']=="subscription")
      echo "خرید اشتراک $plantype";
    
}

function date_of_transaction() {
    global $wpdb;

    $user_id = get_current_user_id();
    if (!$user_id) {
        echo "کاربر مشخص نیست"; // کاربر وارد نشده
        return;
    }

    $table_name = $wpdb->prefix . 'user_transactions';

    $query = $wpdb->prepare(
        "SELECT type, transaction_date FROM $table_name WHERE user_id = %d ORDER BY transaction_date DESC LIMIT 1",
        $user_id
    );

    $transaction = $wpdb->get_row($query, ARRAY_A);

    if (!$transaction) {
      
        return NULL;
    }
   
    echo  date('Y-m-d H:i', strtotime($transaction['transaction_date']));
}
 */
/* 
add_action('wp_ajax_save_timed_option', 'save_timed_option_to_session');
add_action('wp_ajax_nopriv_save_timed_option', 'save_timed_option_to_session');

function save_timed_option_to_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $timed_option = isset($_POST['timed_option']) ? sanitize_text_field($_POST['timed_option']) : '';

    if ($product_id && $timed_option) {
        $_SESSION['timed_option_' . $product_id] = $timed_option;
        echo 'Saved for product ' . $product_id;
    } else {
        echo 'Nothing to save';
    }
    wp_die();
}
 */



function mytheme_setup()
{
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');

  add_theme_support('custom-logo');

  add_theme_support('woocommerce');

  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');

  add_theme_support('woocommerce', array(
    'thumbnail_image_width' => 350,
    'single_image_width'    => 500,
  ));

  register_nav_menus(["Header" => "Header Menu"]);
}
add_action('after_setup_theme', 'mytheme_setup');

add_action('customize_register', function ($wp_customize) {
  // Section
  $wp_customize->add_section('hodcode_social_links', [
    'title'    => __('Social Media Links', 'hodcode'),
    'priority' => 30,
  ]);

  // Facebook
  $wp_customize->add_setting('hodcode_facebook', [
    'default'   => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control('hodcode_facebook', [
    'label'   => __('Facebook URL', 'hodcode'),
    'section' => 'hodcode_social_links',
    'type'    => 'url',
  ]);

  // Twitter
  $wp_customize->add_setting('hodcode_twitter', [
    'default'   => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control('hodcode_twitter', [
    'label'   => __('Twitter URL', 'hodcode'),
    'section' => 'hodcode_social_links',
    'type'    => 'url',
  ]);

  // LinkedIn
  $wp_customize->add_setting('hodcode_linkedin', [
    'default'   => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control('hodcode_linkedin', [
    'label'   => __('LinkedIn URL', 'hodcode'),
    'section' => 'hodcode_social_links',
    'type'    => 'url',
  ]);

  //Telegram
  $wp_customize->add_setting('hodcode_telegram', [
    'default'   => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control('hodcode_telegram', [
    'label'   => __('Telegram URL', 'hodcode'),
    'section' => 'hodcode_social_links',
    'type'    => 'url',
  ]);



  // google
  $wp_customize->add_setting('hodcode_instagram', [
    'default'   => '',
    'transport' => 'refresh',
    'sanitize_callback' => 'esc_url_raw',
  ]);
  $wp_customize->add_control('hodcode_instagram', [
    'label'   => __('Instagram URL', 'hodcode'),
    'section' => 'hodcode_social_links',
    'type'    => 'url',
  ]);

});

function hodcode_enqueue_styles()
{
    // استایل اصلی قالب
    wp_enqueue_style(
        'hodcode-style',
        get_stylesheet_uri()
    );

    // فونت اختصاصی
    wp_enqueue_style(
        'hodcode-webfont',
        get_template_directory_uri() . "/assets/fontiran.css"
    );

    // Tailwind (از CDN)
    wp_enqueue_script(
        'tailwind',
        "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4",
        array(),
        null,
        true
    );

    // Swiper CSS
    wp_enqueue_style(
        'hodcode-swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );

    // Swiper JS
    wp_enqueue_script(
        'hodcode-swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );

    // main.js (بعد از Swiper)
    wp_enqueue_script(
        'hodcode-main-js',
        get_template_directory_uri() . '/main.js',
        array('hodcode-swiper-js'), // وابسته به Swiper
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'hodcode_enqueue_styles');


update_post_meta( 38, 'total_sales', 15 ); // محصول با ID = 123
update_post_meta( 37, 'total_sales', 9 );  // محصول با ID = 124
update_post_meta( 36, 'total_sales', 5 );  // محصول با ID = 125



add_filter('woocommerce_get_availability', function($availability){
    $availability['availability'] = '';  
    return $availability;
});
add_action('init', function () {

  // register_taxonomy('product_category', ['product'], [
  //   'hierarchical'      => true,
  //   'labels'            => [
  //     'name'          => ('Product Categories'),
  //     'singular_name' => 'Product Category'
  //   ],
  //   'rewrite'           => ['slug' => 'product-category'],
  //   'show_in_rest' => true,

  // ]);

  // register_post_type('product', [
  //   'public' => true,
  //   'label'  => 'Products',

  // //   'rewrite' => ['slug' => 'product'],
  // //   'taxonomies' => ['product_category'],

  //   'supports' => [
  //     'title',
  //     'editor',
  //     'thumbnail',
  //     'excerpt',
  //     'custom-fields',
  //   ],

  //   'show_in_rest' => true,
  // ]);
});

// hodcode_add_custom_field("price","product","Price (Final)");
// hodcode_add_custom_field("old_price","product","Price (Before)");

// add_action('pre_get_posts', function ($query) {
//   if ($query->is_home() && $query->is_main_query() && !is_admin()) {
//     $query->set('post_type', 'product');
//   }
// });

function toPersianNumerals($input)
{
  // English digits
  $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

  // Persian digits
  $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

  // Replace and return
  return str_replace($english, $persian, (string) $input);
}

function hodcode_add_custom_field($fieldName, $postType, $title)
{
  add_action('add_meta_boxes', function () use ($fieldName, $postType, $title) {
    add_meta_box(
      $fieldName . '_bx`ox',
      $title,
      function ($post) use ($fieldName) {
        $value = get_post_meta($post->ID, $fieldName, true);
        wp_nonce_field($fieldName . '_nonce', $fieldName . '_nonce_field');
        echo '<input type="text" style="width:100%"
         name="' . esc_attr($fieldName) . '" value="' . esc_attr($value) . '">';
      },
      $postType,
      'normal',
      'default'
    );
  });

  add_action('save_post', function ($post_id) use ($fieldName) {
    // checks
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST[$fieldName . '_nonce_field'])) return;
    if (!wp_verify_nonce($_POST[$fieldName . '_nonce_field'], $fieldName . '_nonce')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    // save
    if (isset($_POST[$fieldName])) {
      $san = sanitize_text_field(wp_unslash($_POST[$fieldName]));
      update_post_meta($post_id, $fieldName, $san);
    } else {
      delete_post_meta($post_id, $fieldName);
    }
  });
}

// حذف دسته پیش فرض ووکامرس در سمت فرانت
add_filter( 'get_terms', function( $terms, $taxonomies, $args ) {
    if ( in_array( 'product_cat', $taxonomies ) && ! is_admin() ) {
        $terms = array_filter( $terms, function( $term ) {
            // بررسی اینکه $term آبجکت است
            if ( is_object( $term ) && isset( $term->slug ) ) {
                return $term->slug !== 'uncategorized';
            }
            return true; // اگه عدد بود، حذفش نکن
        });
    }
    return $terms;
}, 10, 3 );

// ثبت لایک
function hod_like_post() {
  if(!isset($_POST['post_id'])) wp_send_json_error();

  $post_id = intval($_POST['post_id']);
  $likes = get_post_meta($post_id, '_hod_like_count', true);
  $likes = $likes ? intval($likes) : 0;

  $action = sanitize_text_field($_POST['action_type']);
  if($action === 'like') $likes++;
  else if($action === 'unlike') $likes = max(0, $likes - 1);

  update_post_meta($post_id, '_hod_like_count', $likes);

  wp_send_json_success(['likes' => $likes]);
}
add_action('wp_ajax_hod_like_post', 'hod_like_post');
add_action('wp_ajax_nopriv_hod_like_post', 'hod_like_post');

// functions.php
function hod_blog_pagination($wp_query = null) {
    if (!$wp_query) {
        global $wp_query;
    }

    $total   = $wp_query->max_num_pages;
    $current = max(1, get_query_var('paged'));

    if ($total <= 1) return;

    $pagination_args = array(
        'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
        'format'    => '?paged=%#%',
        'current'   => $current,
        'total'     => $total,
        'type'      => 'array',
        'end_size'  => 1,
        'mid_size'  => 2,
    );

    $links = paginate_links($pagination_args);

    if (!is_array($links)) return;

    echo '<nav class="w-full flex justify-center mt-10" aria-label="Blog Pagination">';
    echo '<ul class="flex flex-wrap justify-center items-center gap-4 p-3">';

    // قبلی
    if ($current > 1) {
        echo '<li class="px-4 py-2.5 text-[#4a4a4a] rounded-md border border-[#4a4a4a] hover:bg-[#c0c0c0] hover:text-[#fafafa] opacity-75 hover:opacity-100 hover:border-[#c0c0c0]">';
        echo '<a href="' . esc_url(get_pagenum_link($current - 1)) . '">« قبلی</a></li>';
    } else {
        echo '<li class="px-4 py-2.5 text-[#4a4a4a] rounded-md border border-[#4a4a4a] bg-[#fafafa] cursor-not-allowed opacity-25">« قبلی</li>';
    }

    // لینک صفحات
    foreach ($links as $link) {
        if (strpos($link, 'prev') !== false || strpos($link, 'next') !== false) continue;

        if (strpos($link, 'current') !== false) {
            echo '<li class="px-4 py-2.5 bg-[#c9a6df] text-[#fafafa] rounded border border-[#c9a6df]">' . $link . '</li>';
        } else {
            echo '<li class="px-4 py-2.5 text-[#4a4a4a] rounded-md border border-[#4a4a4a] hover:bg-[#c0c0c0] hover:text-[#fafafa] hover:border-[#c0c0c0] opacity-75 hover:opacity-100">' . $link . '</li>';
        }
    }

    // بعدی
    if ($current < $total) {
        echo '<li class="px-4 py-2.5 text-[#4a4a4a] rounded-md border border-[#4a4a4a] hover:bg-[#c0c0c0] hover:text-[#fafafa] opacity-75 hover:opacity-100 hover:border-[#c0c0c0]">';
        echo '<a href="' . esc_url(get_pagenum_link($current + 1)) . '">بعدی »</a></li>';
    } else {
        echo '<li class="px-4 py-2.5 text-[#4a4a4a] rounded-md border border-[#4a4a4a] bg-[#fafafa] cursor-not-allowed opacity-25">بعدی »</li>';
    }

    echo '</ul>';
    echo '</nav>';
}


add_action('woocommerce_product_query', function($q) {
  if (!is_shop() && !is_product_category()) return;

  $sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : '';
  $min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : '';
  $max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : '';

  // فیلتر نوع محصول
  switch ($sort) {
    case 'new':
      $q->set('orderby', 'date');
      $q->set('order', 'DESC');
      break;

    case 'popular':
      $q->set('meta_key', 'total_sales');
      $q->set('orderby', 'meta_value_num');
      $q->set('order', 'DESC');
      break;

    case 'cheap':
      $q->set('meta_key', '_price');
      $q->set('orderby', 'meta_value_num');
      $q->set('order', 'ASC');
      break;

    case 'expensive':
      $q->set('meta_key', '_price');
      $q->set('orderby', 'meta_value_num');
      $q->set('order', 'DESC');
      break;

  }

  // فیلتر قیمت
  $meta_query = $q->get('meta_query') ?: [];

  if ($min_price) {
    $meta_query[] = [
      'key'     => '_price',
      'value'   => $min_price,
      'compare' => '>=',
      'type'    => 'NUMERIC'
    ];
  }

  if ($max_price) {
    $meta_query[] = [
      'key'     => '_price',
      'value'   => $max_price,
      'compare' => '<=',
      'type'    => 'NUMERIC'
    ];
  }

  if (!empty($meta_query)) {
    $q->set('meta_query', $meta_query);
  }
});
/* تغییر منو */
function elahe_add_menu_link_class($atts, $item, $args) {
    if ($args->theme_location === 'Header') {
        $atts['class'] = 'relative after:absolute after:-bottom-1 after:left-0
         after:w-0 after:h-[2px] after:bg-[#c9a6df] after:transition-all
         after:duration-300 hover:after:w-full text-[#4a4a4a]';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'elahe_add_menu_link_class', 10, 3);








